<?php
namespace AdminModule;

use Nette\Application\UI\Form;
use App\Model\SectionManager;
use App\Model\CategoryManager;
use App\Model\ThreadManager;
use App\Model\ForumManager;
use App\Model\PictureManager;
use App\Model\TextManager;
use App\Components\IPaginationControlFactory;
use App\Components\IPictureControlFactory;
use App\Components\IMenuControlFactory;
use App\Components\IUserControlFactory;


class ThreadsPresenter extends ManagePresenter{
    
    private $threadManager;
    
    private $forumManager;
    
    public function __construct(CategoryManager $categoryMan, SectionManager $sectionMan,
                                PictureManager $picMan, TextManager $textMan,
                                ThreadManager $thrMan, ForumManager $forMan,
                                IPaginationControlFactory $paginationControlFactory,
                                IPictureControlFactory $pictureControlFactory,
                                IMenuControlFactory $menuControlFactory,
                                IUserControlFactory $userControlFactory) {
        
        parent::__construct($categoryMan, $sectionMan, $picMan, $textMan,
                            $paginationControlFactory, $pictureControlFactory,
                            $menuControlFactory, $userControlFactory);
        
        $this->threadManager = $thrMan;
        $this->forumManager = $forMan;
      
    }
        
    public function actionManage($categoryId){
        
        $category  = $this->forumManager->getCategory($categoryId);
        if(!$category){
            $this->flashMessage('zadaná kategorie neexistuje','error');
            $this->redirect(':Admin:Categories:categories-manage');
        }
  
        $threads = $this->filtre($this->threadManager,$categoryId);

        $this['threadsFilterForm']->setDefaults($this->filter);

        $this->template->threads = $threads;

        $this->template->type = $this->type;
        $this->template->categoryId = $categoryId;
        $this->template->sort = '';
        
        $this['breadcrumb']
                    ->addLinks([
                                ['Fórum',$this->link(':Admin:Categories:categories-manage'),'Administrace fóra'],
                                [$category['name'],$this->link(':Admin:Threads:manage',$categoryId),'Kategorie fóra'],                               
                               ]);
    
    }

    public function handleSortThreads($orderColumn, $orderType,$categoryId){    
            
        $threads = $this->sort($this->threadManager, $orderColumn, $orderType, $categoryId);
        $this->template->threads = $threads;
        $this->template->type = $this->type;       
    }
   
    public function createComponentThreadsFilterForm(){     
        $form = new Form();
        $form->setMethod(Form::GET);
        $form->addText('namesearch');        
        $form->addText('authorsearch');
        $form->addSelect('lockedSelect','',[3 =>'Všechny', 0 => 'Odemčené', 1=>'Zamčené']);
        $form->addSubmit('send','Filtrovat');
        $form->onSuccess[] = [$this,'filterSucceeded'];

        return $form;
    }
    
    public function multipleDelete($deletedIds){
        if($this->getUser()->isInRole('admin')){
            $this->threadManager->deleteThreads($deletedIds);
            $this->flashMessage('Vlákna byla úspěšně smazána.','success');
            $this->redirect('this');
        }
    }

     public function handleDeleteThread($threadId){
        $thread = $this->threadManager->getThread($threadId);        
        if(!$thread){
            $this->flashMessage('Zadané vlákno neexistuje.','error');
            $this->redirect('this');
        }
        $name = $thread->name;
        $this->threadManager->deleteThread($threadId);
        $message = "Vlákno $name bylo úspěšně smazáno.";
        $this->flashMessage($message,'success');
        $this->redirect('this');
    }
    
     public function handleLockThread($threadId){
        $thread = $this->threadManager->getThread($threadId);
        if(!$thread){
            $this->flashMessage('Zadané vlákno neexistuje.','error');
            $this->redirect('Homepage:');
        }
        $this->threadManager->toogleLock($threadId);
        if($thread->locked == 0){
            $message = "Vlákno $thread->name bylo zamčeno.";           
        }
        else{
            $message = "Vlákno $thread->name bylo odemčeno.";   
        }
        $this->flashMessage($message,'info');
        $this->redirect('this');
    }
    
    public function handleRemoveFilter($categoryId){
     
        $threads = $this->removeFilter($this->threadManager,$categoryId);
      
        $this->template->threads = $threads;
        
        $this->redirect('this');
    }    
 
}

