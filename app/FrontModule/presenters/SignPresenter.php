<?php

namespace FrontModule;

use Nette;
use App\Forms;
use Nette\Application\UI\Form;
use App\Model\DuplicateEmailException;
use App\Model\DuplicateNameException;
use App\Model\SectionManager;
use App\Model\CategoryManager;
use App\Model\UserManager;
use App\Model\ProfileManager;
use App\Model\PictureManager;
use App\Model\TextManager;
use App\Components\IPaginationControlFactory;
use App\Components\IPictureControlFactory;
use App\Components\IMenuControlFactory;
use App\Components\IUserControlFactory;


class SignPresenter extends BasePresenter
{	
        
        /** @persistent */
       public $backlink = '';
       
       private $userManager;
       
       private $profileManager;
       
       private $passwordLength;
       
       public function __construct(CategoryManager $categoryMan, SectionManager $sectionMan,
                                    PictureManager $picMan, TextManager $textMan,
                                    UserManager $userMan, ProfileManager $profiMan,
                                    IPaginationControlFactory $paginationControlFactory,
                                    IPictureControlFactory $pictureControlFactory,
                                    IMenuControlFactory $menuControlFactory,
                                    IUserControlFactory $userControlFactory){
           
           parent::__construct($categoryMan, $sectionMan, $picMan, $textMan,
                               $paginationControlFactory, $pictureControlFactory,
                               $menuControlFactory, $userControlFactory);
           
           $this->userManager = $userMan;
           $this->profileManager = $profiMan;
           $this->passwordLength = $this->userManager->passwordLength;
       }       	
	
	protected function createComponentSignUpForm()
	{          
            $form = new Form();
            $form->getElementPrototype()->addAttributes(['class' => 'table-space5']);
            $form->addText('username', 'Uživatelské jméno:')
                    ->setRequired('Prosím vyplňte uživatelské jméno.');
            $form->addText('email', 'Váš e-mail:')
                    ->setRequired('Prosím vyplňte váš e-mail.')
                    ->addRule($form::EMAIL,'Prosím zadejte platný email.');
            $form->addPassword('password', 'Heslo:')
                    ->setOption('description', sprintf('Minimální délka je %d znaků', $this->passwordLength))
                    ->setRequired('Prosím vyplňte heslo.')
                    ->addRule($form::MIN_LENGTH, 'Zadejte heslo dlouhé alespoň %d znaků', $this->passwordLength);
            $form->addPassword('password_again', 'Heslo znovu:')
                    ->setRequired('Prosím vyplňte heslo znovu pro kontrolu.')
                    ->addRule(Form::EQUAL,'Zadaná hesla se neshodují.', $form['password']);
            $form->addSubmit('send', 'Registrovat se');

            $form->onSuccess[] = [$this,'signUpFormSucceeded'];
            return $form;
	}
        
        protected function createComponentForgottenForm(){
            $form = new Form();
            $form->getElementPrototype()->addAttributes(['class' => 'table-space5']);
            $form->addEmail('email','Email:')
                   ->setRequired('Prosím vyplňte váš e-mail.')
                   ->addRule($form::EMAIL,'Prosím zadejte platný email.');
            $form->addSubmit('send');
            $form->onSuccess[] = [$this,'forgottenFormSucceeded'];
            
            return $form;
        }
        
        protected function createComponentResetForm(){
            $form = new Form();
            $form->addPassword('password','Heslo:')
            ->setOption('description', sprintf('Minimální délka je %d znaků', $this->passwordLength))
                    ->setRequired('Prosím vyplňte heslo.')
                    ->addRule($form::MIN_LENGTH, 'Zadejte heslo dlouhé alespoň %d znaků', $this->passwordLength);
            $form->addPassword('password_check','Heslo znovu:')
                    ->setRequired('Prosím vyplňte heslo znovu pro kontrolu.')
                    ->addRule(Form::EQUAL,'Zadaná hesla se neshodují.', $form['password']);
            $form->addHidden('token');
            $form->addSubmit('send','Změnit');
            $form->onSuccess[] = [$this,'resetFormSucceeded'];
            
            return $form;
        }
        
         protected function createComponentChangeForm(){
            $form = new Form();
             $form->getElementPrototype()->addAttributes(['class' => 'table-space5']);
            $form->addText('username','Uživatelské jméno:')
                    ->setRequired('Prosím vyplňte uživatelské jméno.');
            $form->addEmail('email','Email:')
                    ->setRequired('Prosím vyplňte váš e-mail.')
                    ->addRule($form::EMAIL,'Prosím zadejte platný email.');
            $form->addPassword('old_password','Staré heslo:');                    
            $form->addPassword('new_password','Nové heslo:')
                    ->setOption('description', sprintf('Minimální délka je %d znaků', $this->passwordLength))                    
                    ->addConditionOn($form['old_password'], Form::FILLED)
                    ->setRequired('Prosím zadeje nové heslo.')
                    ->addRule($form::MIN_LENGTH, 'Zadejte heslo dlouhé alespoň %d znaků', $this->passwordLength);
            $form->addPassword('new_password_check','Nové heslo znovu:')                   
                    ->addConditionOn($form['old_password'], Form::FILLED)
                    ->setRequired('Prosím zadeje nové heslo znovu pro kontrolu.')
                    ->addRule(Form::EQUAL,'Nové heslo a heslo pro kontrolu se neshodují!',$form['new_password']);        
                  
            $form->addSubmit('send','Uložit');
            $form->onSuccess[] = [$this, 'changeFormSucceeded'];
            
            return $form;
        }               
        
         public function signUpFormSucceeded($form,$values){
            try {                              
                $this->userManager->register($values->username, $values->email, $values->password);                                
                $this->user->login($values->username, $values->password);
                $id = $this->user->id;
                $this->flashMessage('Registrace proběhla úspěšně.','success');
                $this->flashMessage('Věnujte prosím chvíli času vyplnění Vašeho profilu','info');
                $this->redirect(':Front:Profile:manage',['profileId' => $id]);
            } 
            catch (DuplicateNameException $e) {
                $this->flashMessage($e->getMessage(),'error');
                $this->redirect(':Front:Sign:up');  
            }
            catch(DuplicateEmailException $e){
                $this->flashMessage($e->getMessage(),'error');
                $this->redrawControl('flashes');
            }
        }
        
        public function forgottenFormSucceeded($form, $values){
            $email = $values->email;
            $template = $this->createTemplate()->setFile(__DIR__ . '/templates/email/email.latte');
            try{
            $this->userManager->sendToken($email,$template); 
                $this->flashMessage('E-mail s odkazem pro reset hesla byl úspěšně odeslán ','success');
                $this->redirect(':Front:Homepage:');
            }
            catch(Nette\InvalidStateException $e){
                $this->flashMessage('E-mail se nepodařilo odeslat, zkuste to prosím později','info');
                $this->redrawControl('flashes');
            }
        }
        
        public function resetFormSucceeded($form, $values){
            $token = $values->token;
            try{
                $user = $this->userManager->getUserByToken($token);
                $userId = $user->users_id;
                $values['users_id'] = $userId;
                $this->userManager->resetPassword($values);            
                $this->user->login($user->username, $values->password);
                $this->flashMessage('Změna hesla byla úspěšně provedena','success');
                $this->redirect(':Front:Homepage:');                
            }
           catch(Nette\Security\AuthenticationException $e){
                $this->flashMessage($e->getMessage(),'error');
                $this->redirect(':Front:Homepage');               
            }
           
        }
        
         public function changeFormSucceeded($form, $values){  
            $values['users_id'] = $this->user->id;
             try {
                 $this->userManager->changeData($values);
                 $identity = $this->userManager->renewIdentity($this->user->id);                       
                 $this->user->login($identity);
                 $this->flashMessage('Změna údajů byla úspěšně provedena','success');              
                 $this->redirect('this');
             }
             catch (DuplicateNameException $e) {
                $this->flashMessage($e->getMessage(),'error');
                $this->redrawControl('flashes');  
            }
            catch(DuplicateEmailException $e){
                $this->flashMessage($e->getMessage(),'error');
                $this->redrawControl('flashes');
            }
            catch(Nette\Security\AuthenticationException $e){
                $this->flashMessage($e->getMessage(),'error');
                $this->redrawControl('flashes');
            }
            
        }
        
        public function actionIn(){
            if($this->user->isLoggedIn()){
                $this->flashMessage('Už jste přihlášený.');
                $this->redirect(':Front:Homepage:default');
            }
            $this['breadcrumb']
                 ->addLinks([
                            ['Přihlášení',$this->link('Sign:in'),'Přihlášení']                            
                           ]);
        }

        public function actionUp(){
            if($this->user->isLoggedIn()){
                $this->flashMessage('Už jste registrovaný.');
                $this->redirect(':Front:Profile:manage',['profileId' => $this->user->id]);
            }
            
            $this['breadcrumb']
                 ->addLinks([
                            ['Registrace',$this->link('Sign:up'),'Registrace']                            
                           ]);
        }
        
        public function actionForgotten(){
            if($this->user->isLoggedIn()){
               $this->flashMessage('Jste přihlášen. Změnu hesla proveďte zde.');
               $this->redirect(':Front:Sign:manage',['userId' => $this->user->id]);
            }
            $this['breadcrumb']
                 ->addLinks([
                            ['Zapomenuté heslo',$this->link('Sign:forgotten'),'Zapomenuté heslo']                            
                           ]);
        }
        
        public function actionReset($token){
            $changingUser = $this->userManager->getUserByToken($token);
            if($this->userManager->checkToken($changingUser)){                
                $this['resetForm']['token']->setValue($token);                
            }
            else{
                $this->flashMessage('Odkaz pro reset hesla je chybný, nebo vypršela doba jeho platnosti','error');
                $this->redirect(':Front:Homepage:');                
            }
            
            $this['breadcrumb']
                 ->addLinks([
                            ['Reset hesla',$this->link('Sign:reset'),'Reset hesla']                            
                           ]);
            
        }
           
        public function actionManage($userId){                     
            
            if($userId == $this->getUser()->id){
             $user = $this->userManager->getUser($userId);            
             $data = ['email' => $user['email'], 'username' => $user['username']];
             $this['changeForm']->setDefaults($data);
         
            }
            else{
                $this->flashMessage('Můžete upravovat pouze svoje údaje.','error');
                $this->redirect(':Front:Sign:manage',['userId' => $this->user->id]);
            }
            
            $this['breadcrumb']
                 ->addLinks([
                            ['Změna údajů',$this->link(':Front:Sign:manage'),'Změna údajů']                            
                           ]);

        }
       

}
