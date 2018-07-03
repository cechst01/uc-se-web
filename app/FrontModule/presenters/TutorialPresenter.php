<?php
namespace FrontModule;

use Nette\Application\UI\Form;
use FrontModule\ContentPresenter;
use App\Model\SectionManager;
use App\Model\CategoryManager;
use App\Model\TutorialManager;
use App\Model\CommentManager;
use App\Model\PictureManager;
use App\Model\TextManager;
use App\Components\IPaginationControlFactory;
use App\Components\IPictureControlFactory;
use App\Components\IMenuControlFactory;
use App\Components\IUserControlFactory;



class TutorialPresenter extends ContentPresenter
{
    private $tutorialManager;
    
    private $commentManager;
    
    public function __construct(CategoryManager $categoryMan, SectionManager $sectionMan,
                                PictureManager $picMan,TextManager $textMan,
                                TutorialManager $tutMan, CommentManager $comMan,
                                IPaginationControlFactory $paginationControlFactory,
                                IPictureControlFactory $pictureControlFactory,
                                IMenuControlFactory $menuControlFactory,
                                IUserControlFactory $userControlFactory) {
        
        parent::__construct($categoryMan, $sectionMan, $picMan, $textMan,
                            $paginationControlFactory, $pictureControlFactory,
                            $menuControlFactory, $userControlFactory);
        $this->tutorialManager = $tutMan;
        $this->commentManager = $comMan;
    }
    
        public function actionShow($tutorialId)
        {
            $tutorial = $this->tutorialManager->getTutorial($tutorialId);
            if(!$tutorial){
                $this->flashMessage('Zadaný tutoriál neexistuje.','error');
                $this->redirect(':Front:Homepage:');
            }
            $comments = $this->commentManager->getComments($tutorialId);           
            $this->template->tutorial = $tutorial;         
            $this->template->comments = $comments; 
            $this->template->hidden = true;
            $this['commentForm']['tutorial_id']->setValue($tutorialId);
            
            $text = $this->textManager->getText('tutorial-user');            
            $this['helpControl']->setText($text);
            
            $section = $tutorial->section;
            $category = $section->category;
            
            $categoryName = $this->categoryManager->getName($category->categories_id,'',' > ');
            $this['breadcrumb']
                    ->addLinks([
                                [$categoryName,$this->link('Section:default',$category->categories_id),'Kategorie'],
                                [$section->name,$this->link('Section:show',$section->sections_id),'Sekce'],
                                [$tutorial->name,$this->link('Tutorial:show',$tutorialId),'Tutoriál']
                               ]);
        }
        
        public function actionTest(){
            $code = '';  
            if($_POST){
                $data = $this->request->getPost();
                if(isset($data['hidd'])){
                    $code = $data['hidd'];                    
                }
            }
            if($_GET){
                $data = $this->request->getParameters();
                if(isset($data['hidd'])){
                    $code = $data['hidd'];                    
                }
            }
            
            $this->template->code = $code; 
            $text = $this->textManager->getText('editor');
            
            $this['breadcrumb']
                    ->addLinks([
                                ['Editor',$this->link('Tutorial:test'),'Editor'],                                
                               ]);
            
            $this['helpControl']->setText($text);
        }
       
        public function createComponentCommentForm(){
            $form = new Form();
            $form->addProtection();
            $form->addTextArea('content','Komentář:')                    
                    ->setAttribute('id','commentArea')                   
                    ->setRequired('Komentář nesmí být prázdný');
            $form->addHidden('comments_id');
            $form->addHidden('tutorial_id');
            $form->addSubmit('send','Uložit komentář');
            $form->onValidate[] = [$this,'validateComment'];
            $form->onSuccess[] = [$this,'addComment'];
            
            return $form;
        }
        
        public function validateComment($form){
            $data = $form->getHttpData();
            if(!empty($data['comments_id'])){
              $comment = $this->commentManager->getComment($data['comments_id']);
              if(!$comment){
                $form->addError('Zadaný komentář neexistuje.');  
              }
              else{
                $this->validateAuthorNoAdmin($comment,$form,'Zadaný komentář');              
              }
              
            }
        }
        public function addComment($form,$values){
            $user = $this->getUser();           
            
            if($user->isLoggedIn())
            {                             
               $this->commentManager->saveComment($values,$user->id); 
               if(!empty($values['comments_id'])){
                   $this->flashMessage('Komentář byl úspěšně změněn.','success');
                   
               }
               else{
                  $this->flashMessage('Komentář byl úspěšně vložen.','success'); 
               }
               $this->redirect('this');
            }
            
        }
        
        public function handleDeleteComment($commentId){
            
            $comment = $this->commentManager->getComment($commentId);
            if(!$comment){
                $this->flashMessage('Zadaný komentář neexistuje.','error');
                $this->redirect('this');
            }
            $authorId = $comment->users_id;
            $user = $this->getUser();
            if(($authorId == $user->id) || $user->isInRole('admin')){
                
               $this->commentManager->deleteComment($commentId);
               $this->flashMessage('Komentář byl úspěšně smazán.','success');
               $this->redirect('this');
            }
            else{
               $this->flashMessage('Nemáte dostatečné oprávnění pro smazání komentáře','error');
               $this->redirect('this'); 
            }
        }
        
        public function handleEditComment($commentId){
            $comment = $this->commentManager->getComment($commentId);
            if(!$comment){
                $this->flashMessage('Zadaný komentář neexistuje.','error');
                $this->redirect('this'); 
            }
            $authorId = $comment->users_id;
            $user = $this->getUser();
            if(($authorId == $user->id) || $user->isInRole('admin')){
                $this['commentForm']->setDefaults($comment);
                $this->template->hidden = false;
            }else{
               $this->flashMessage('Nemáte dostatečné oprávnění pro úpravu komentáře','error');
               $this->redirect('this');
            }
        }
       
        protected function createComponentTestForm()
        {
            $form = new Form;
            $form->addTextArea('ar')
                    ->setAttribute('id','area')
                    ->setAttribute('class','editor');
            $form->addButton('but','Zobrazit')
                    ->setAttribute('id','vyzk');
            return $form;
        }
}
