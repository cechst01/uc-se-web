<?php
namespace App\Components;
use Nette;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\Security\User;



class UserControl extends Control{
    
    const TEMPLATE = '/templates/user.latte';
    
    private $user;
    public  $onSuccess = [];
    private $adminModule = false;
    
    private $adminEmail;
    
    public function __construct(User $user) {
        parent::__construct();
        $this->user = $user;      
    }
    
    public function render(){
        $this->template->setFile(dirname(__FILE__).self::TEMPLATE);
        $this->template->adminModule = $this->adminModule;
        $this->template->user = $this->user;
        $this->template->render();
    }
    
    protected function createComponentForm(){
        
        $form = new Form();
        $form->addText('username','Jméno:')
                ->setRequired('Prosím vyplňte uživatelské jméno.')
                ->setAttribute('class','input');
        $form->addPassword('password','Heslo:')
                ->setRequired('Prosím vyplňte heslo.')
                ->setAttribute('class','input');
        $form->addSubmit('send','Přihlásit se')
                ->setAttribute('class','smallButton');
        $form->onSuccess[] = [$this,'signIn'];
        return $form;
    }
    
    public function signIn($form, $values){       
        try{
            
            $this->user->login($values->username, $values->password);
            $this->presenter->flashMessage('Přihlášení proběhlo úspěšně.');
            $this->presenter->redirect(':Front:Homepage:');
        }
        catch(Nette\Security\AuthenticationException $e){
            $this->presenter->flashMessage($e->getMessage(),'error');
            if($e->getCode() == 4){             
                $this->presenter->flashMessage("Pro další informace kontaktuje administrátora na adrese $this->adminEmail",'info');  
           }
            $this->presenter->redirect(':Front:Sign:in');
        }        
        $this->presenter->redirect('this');
    }
    
    public function handleLogout(){        
        $this->user->logout(TRUE);
        $this->presenter->flashMessage('Odhlášení proběhlo úspěšně.');
        $this->presenter->redirect(':Front:Homepage:');
    }
    
    public function setAdminModule(){
        $this->adminModule = true;
    }
    
    public function setAdminEmail($email){
        $this->adminEmail = $email;
    }
    
}

interface IUserControlFactory
{
        /**
         * Vrací novou komponentu pro přihlášení
         * @return UserControl komponenta pro přihlášení
         */
        public function create();
}

