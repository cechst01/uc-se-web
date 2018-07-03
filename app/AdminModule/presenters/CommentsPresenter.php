<?php

namespace AdminModule;

use Nette\Application\UI\Form;
use App\Model\SectionManager;
use App\Model\CategoryManager;
use App\Model\CommentManager;
use App\Model\TutorialManager;
use App\Model\PictureManager;
use App\Model\TextManager;
use App\Components\IPaginationControlFactory;
use App\Components\IPictureControlFactory;
use App\Components\IMenuControlFactory;
use App\Components\IUserControlFactory;


class CommentsPresenter extends ManagePresenter{
       
    private $commentManager;
    private $tutorialManager;
    
    public function __construct(CategoryManager $categoryMan, SectionManager $sectionMan,
                                PictureManager $picMan,TextManager $textMan,
                                CommentManager $comMan, TutorialManager $tutMan,
                                IPaginationControlFactory $paginationControlFactory,
                                IPictureControlFactory $pictureControlFactory,
                                IMenuControlFactory $menuControlFactory,
                                IUserControlFactory $userControlFactory) {
        
        parent::__construct($categoryMan, $sectionMan, $picMan, $textMan,
                            $paginationControlFactory, $pictureControlFactory,
                            $menuControlFactory, $userControlFactory);
       
        $this->commentManager = $comMan;
        $this->tutorialManager = $tutMan;
    }
   
    public function actionManage($tutorialId){
        
        $tutorial = $this->tutorialManager->getTutorial($tutorialId);
        
        if(! $tutorial){
            $this->flashMessage('Zadaný tutorial neexistuje.','error');
            $this->redirect(':Admin:Tutorials:manage');
        }
            
        
        $this['commentsFiltreForm']->setDefaults($this->filter);   
        
        $comments = $this->filtre($this->commentManager,$tutorialId);        
       
        $this->template->comments = $comments;
        $this->template->type = $this->type;
        $this->template->sort = '';
        $this->template->tutorialId = $tutorialId;
        
        $this['breadcrumb']
                    ->addLinks([
                                ['Tutorialy' ,$this->link(':Admin:Tutorials:manage'),'Administrace tutorialů'],
                                ['Komentáře - ' . $tutorial['name'],$this->link(':Admin:Comments:manage',$tutorialId),'Administrace komentářů'],                               
                               ]);
        
    }
    
    protected function createComponentCommentsFiltreForm(){
        $form = new Form();
        $form->addText('authorsearch','Autor');
        $form->addText('contentsearch','Obsah');
        $form->addText('created_at','Vytvořeno');
        $form->addText('changed_at','Změněno');
        $form->addSubmit('send','Filtrovat');
        $form->onSuccess[] =  [$this,'filterSucceeded'];
        
        return $form;
    }
    
    public function multipleDelete($deletedIds){
        if($this->getUser()->isInRole('admin')){
            $this->commentManager->deleteComments($deletedIds);
            $this->flashMessage('Komentáře byly úspěšně smazány.','success');
            $this->redirect('this');
        }
    }
      
    public function handleDeleteComment($commentId){
        $comment = $this->commentManager->getComment($commentId);
        if(!$comment){
            $this->flashMessage('Zadaný komentář neexistuje.','error');
            $this->redirect('this');
        }        
        if(!$this->user->isInRole('admin')){
            $this->flashMessage('Zadaný komentář nemůžete smazat, nemáte administrátorská práva.','error');
            $this->redirect('this'); 
        }
        $this->commentManager->deleteComment($commentId);
        $this->flashMessage('Komentář byl úspěšně smazán.','success');
        $this->redirect('this');
    }

    public function handleSortComments($orderColumn, $orderType, $tutorialId){
            
        $comments = $this->sort($this->commentManager, $orderColumn, $orderType,$tutorialId);    
        $this->template->comments = $comments;        
     
    }    
   
     public function handleRemoveFilter($tutorialId){
        
        $comments = $this->removeFilter($this->commentManager,$tutorialId); 
       
        $this->template->comments = $comments;
          
        $this->redirect('this');
    }    
  
}


