<?php
namespace AdminModule;

use Nette\Application\UI\Form;
use App\Model\SectionManager;
use App\Model\CategoryManager;
use App\Model\ForumManager;
use App\Model\ThreadManager;
use App\Model\PostManager;
use App\Model\PictureManager;
use App\Model\TextManager;
use App\Components\IPaginationControlFactory;
use App\Components\IPictureControlFactory;
use App\Components\IMenuControlFactory;
use App\Components\IUserControlFactory;


class PostsPresenter extends ManagePresenter{ 
    
    private $forumManager;
    private $threadManager;
    private $postManager;    
   
    public function __construct(CategoryManager $categoryMan, SectionManager $sectionMan,
                                PictureManager $picMan, TextManager $textMan, PostManager $postMan,
                                ThreadManager $threMan, ForumManager $forMan,
                                IPaginationControlFactory $paginationControlFactory,
                                IPictureControlFactory $pictureControlFactory,
                                IMenuControlFactory $menuControlFactory,
                                IUserControlFactory $userControlFactory){
        parent::__construct($categoryMan, $sectionMan, $picMan,
                            $textMan, $paginationControlFactory,
                            $pictureControlFactory, $menuControlFactory,
                            $userControlFactory);
        
        $this->postManager = $postMan;
        $this->threadManager = $threMan;
        $this->forumManager = $forMan;
    }    
        
    public function actionManage($threadId){   
   
        $thread = $this->threadManager->getThread($threadId);
        if(! $thread){
            $this->flashMessage('Zadané vlákno neexistuje.','error');
            $this->redirect(':Admin:Categories:categories-manage');
        }
        
        $posts = $this->filtre($this->postManager,$threadId);

        $this['postsFilterForm']->setDefaults($this->filter);

        $this->template->posts = $posts;

        $this->template->type = $this->type;
        $this->template->threadId = $threadId;
        $this->template->sort = '';
        
        $categoryId = $thread['f_category_id'];
        $category  = $this->forumManager->getCategory($categoryId);
        
        $this['breadcrumb']
                    ->addLinks([
                                ['Fórum',$this->link(':Admin:Categories:categories-manage'),'Administrace fóra'],
                                [$category['name'],$this->link(':Admin:Threads:manage',$categoryId),'Kategorie fóra'],
                                [$thread['name'],$this->link(':Admin:Posts:manage',$threadId),'Vlákno'],
                               ]);
    }

    public function handleSortPosts($orderColumn, $orderType,$threadId){ 
              
        $posts = $this->sort($this->postManager, $orderColumn, $orderType, $threadId);      
        $this->template->posts = $posts; 
    }

    public function handleDeletePost($postId){
        $post = $this->postManager->getPost($postId);        
        if(!$post){
            $this->flashMessage('Zadaný příspěvek neexistuje.','error');
            $this->redirect('this');
        }        
        $this->postManager->deletePost($postId);
        $message = "Příspěvek byl úspěšně smazán.";
        $this->flashMessage($message,'success');
        $this->redirect('this');
    }

    public function createComponentPostsFilterForm(){     
        $form = new Form();
        $form->setMethod(Form::GET);              
        $form->addText('authorsearch');
        $form->addText('contentsearch');
        $form->addSubmit('send','Filtrovat');
        $form->onSuccess[] = [$this,'filterSucceeded'];

        return $form;
    }
    
    public function handleRemoveFilter($threadId){
       
        $posts = $this->removeFilter($this->postManager,$threadId);
        
        $this->template->posts = $posts;
        
        $this->redirect('this');
    }
   
       
    
}

