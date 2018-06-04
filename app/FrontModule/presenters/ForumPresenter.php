<?php
namespace FrontModule;


use Nette\Application\UI\Form;
use FrontModule\ContentPresenter;
use App\Model\SectionManager;
use App\Model\CategoryManager;
use App\Model\ForumManager;
use App\Model\PostManager;
use App\Model\ThreadManager;
use App\Model\PictureManager;
use App\Model\TextManager;
use App\Components\IPaginationControlFactory;
use App\Components\IPictureControlFactory;
use App\Components\IMenuControlFactory;
use App\Components\IUserControlFactory;

class ForumPresenter extends ContentPresenter
{
    private $forumManager;
    private $threadManager;
    private $postManager;
    
    public function __construct(CategoryManager $categoryMan, SectionManager $sectionMan,
                                PictureManager $picMan, TextManager $textMan,
                                ForumManager $forMan, ThreadManager $thrMan, PostManager $postMan,
                                IPaginationControlFactory $paginationControlFactory,
                                IPictureControlFactory $pictureControlFactory,
                                IMenuControlFactory $menuControlFactory,
                                IUserControlFactory $userControlFactory) {
        
        parent::__construct($categoryMan, $sectionMan, $picMan, $textMan,
                            $paginationControlFactory, $pictureControlFactory,
                            $menuControlFactory, $userControlFactory);
        $this->forumManager = $forMan;
        $this->threadManager = $thrMan;
        $this->postManager = $postMan;
    }
    public function renderCategories(){
        
      $categories = $this->forumManager->getCategories();
      $this->template->categories = $categories;
      $this['breadcrumb']->addLinks([
         ['Fórum',$this->link('Forum:categories'),'']
      ]);
    }
    
    public function renderThreads($categoryId){
        
        $category = $this->forumManager->getCategory($categoryId);        
        
        if(!$category){
            $this->flashMessage('Zadaná kategorie neexistuje.','error');
            $this->redirect(':Front:Homepage:');
        }
        $threads = $this->threadManager->getThreads($categoryId);
        
        $paginator = &$this['pagination']->getPaginator(); // Nezapomeňte předat referencí!
        $paginator->setItemCount(count($threads));
        $paginator->setPage($this->getParameter('page', 1));
        
        $threads->limit($paginator->getLength(), $paginator->getOffset());

        $this->template->threads = $threads->fetchAll();
        $this->template->categoryId = $categoryId;
        $this->template->category = $category;
        $this['breadcrumb']->addLinks([
            ['Fórum',$this->link('Forum:categories'),'Fórum'],
            [$category->name,$this->link('Forum:threads',$categoryId),'Kategorie fóra']
        ]);
    }
    
    public function actionManageThread($categoryId,$threadId){
        $category = $this->forumManager->getCategory($categoryId);
        if(!$category){
            $this->flashMessage('Zadaná kategorie neexistuje.','error');
            $this->redirect(':Front:Homepage:');
        }
        $this['threadForm']['f_category_id']->setValue($categoryId);
        
        if($threadId){            
            $thread = $this->threadManager->getThread($threadId);
            if(!$thread){
                $this->flashMessage('Zadané vlákno neexistuje.','error');
                $this->redirect(':Front:Homepage:');
            }
            if($thread['users_id'] != $this->getUser()->id && !($this->getUser()->isInRole('admin'))){
                $this->flashMessage('Nemáte dostatečné oprávnění pro úpravu vlákna.','error');
                $this->redirect(':Front:Homepage:');
            }
            $this['threadForm']['threads_id']->setValue($threadId);
            $this['threadForm']->setDefaults($thread);  
        }
    }    
    
    
    protected function createComponentThreadForm(){
        $edit = $this->getParameter('threadId',0);
        $form = new Form();
        $form->addProtection();
        $form->addText('name','Název vlákna')
                ->setRequired('Musíte vyplnit název vlákna.')
                ->setAttribute('class','input');
        if($edit == 0){
            $form->addTextArea('content','Příspěvek')
                ->setAttribute('class','postArea')
                ->setRequired('Musíte vyplnit text příspěvku.');
        }
        $form->addHidden('f_category_id');
        $form->addHidden('threads_id');
        if($edit == 0){
            $form->addSubmit('send','Založit vlákno');
        }
        else{
           $form->addSubmit('send','Uložit změnu'); 
        }
        $form->onValidate[] = [$this,'validateThread'];
        $form->onSuccess[] = [$this,'addThread'];
        
        return $form;
    }
    
    public function validateThread($form,$values){     
        if(!empty($values['threads_id'])){
          $thread = $this->threadManager->getThread($values['threads_id']);
          if(!$thread){
            $form->addError('Zadané vlákno neexistuje');
          }
          else{
              $this->validateAuthor($thread,$form,'Zadané vlákno');
          }
        }            
    }
    
    public function addThread($form,$values){        
        $threadData = clone $values;
        unset($threadData['content']);
        $threadData['users_id'] = $this->getUser()->id;       
     
        $threadId =  $this->threadManager->saveThread($threadData);
    
         if(isset($values['content'])){                   
            $postData['users_id'] = $this->getUser()->id;
            $postData['created_at'] = date('Y-m-d-G-i-s');
            $postData['changed_at'] = date('Y-m-d-G-i-s');
            $postData['content'] = $values['content'];
            $postData['threads_id'] = $threadId;
            $this->postManager->savePost($postData);
            $message = 'Vlákno bylo úspěšně vloženo.';
         }
         else{
             $message = 'Vlákno bylo úspěšně upraveno.';            
         }
        $this->flashMessage($message,'success');
        $this->redirect(':Front:Forum:posts',['threadId' => $threadId]);
    }  
      
    public function actionPosts($threadId){
        $thread = $this->threadManager->getThread($threadId);
        if(!$thread){
            $this->flashMessage('Zadané vlákno neexistuje.','error');
            $this->redirect(':Front:Homepage:');
        }
        $category = $thread->f_category;
        $this->template->thread = $thread;
        $posts = $this->postManager->getPosts($threadId);
        $this->template->posts = $posts;
        $this['postForm']['threads_id']->setValue($threadId);
        
        $this['breadcrumb']->addLinks([
            ['Fórum', $this->link('Forum:categories'),'Fórum'],
            [$category->name,$this->link('Forum:threads',$category->forum_categories_id),'Kategorie fóra'],
            [$thread->name,$this->link('Forum:posts',$thread->threads_id),'Vlákno']
        ]);
    }
    
    protected function createComponentPostForm(){
        $form = new Form();
        $form->addProtection();
        $form->addTextArea('content','Příspěvek:')
             ->setAttribute('Class','postArea')
             ->setAttribute('id','postArea')
             ->setRequired('Musíte vyplnit text příspěvku.');
        $form->addHidden('threads_id');
        $form->addHidden('post_id');
        $form->addSubmit('send','Vložit příspěvek');
        $form->onValidate[] = [$this,'validatePost'];
        $form->onSuccess[] = [$this,'addPost'];
        
        return $form;
    }
    
    public function validatePost($form){
        $data = $form->getHttpData();
            if(!empty($data['post_id'])){
              $post = $this->postManager->getPost($data['post_id']);
              if(!$post){
                $form->addError('Zadaný příspěvek neexistuje');
            }
            else{
                $this->validateAuthor($post, $form, 'Zadaný příspěvek');
              }
            }
    }
    
    public function addPost($form)
    {
        $data = $form->getHttpData();
        
        $data['users_id'] = $this->getUser()->id;
        $data['created_at'] = date('Y-m-d-G-i-s');
        $data['changed_at'] = date('Y-m-d-G-i-s');
               
        unset($data['send'],$data['_do'],$data['_token_']);     
        
        $this->postManager->savePost($data);
        $this->flashMessage('Příspěvek byl úspěšně uložen.','success');
        $this->redirect('this');
    }
    
    public function actionManagePost($postId){
        $post = $this->postManager->getPost($postId);
        if(!$post){
            $this->flashMessage('Zadaný příspěvek neexistuje.');
            $this->redirect(':Front:Homepage:');
        }
        if($this->user->isInRole('admin')){
          $this['postForm']->setDefaults($post);  
        }
        else{
           $this->flashMessage('Nemáte dostatečné oprávnění pro úpravu příspěvku.','error');
           $this->redirect(':Front:Homepage:');
        }
         
    }
       
    public function handleManagePost($postId){        
        $post = $this->postManager->getPost($postId);
        if(!$post){
            $this->flashMessage('Zadaný příspěvek neexistuje.');
            $this->redirect('this');
        }
         $authorId = $post->users_id;
            $user = $this->getUser();
            if(($authorId == $user->id) || $user->isInRole('admin')){  
              $this['postForm']->setDefaults($post);
            }
            else{
               $this->flashMessage('Nemáte dostatečné oprávnění pro úpravu příspěvku.','error');
               $this->redirect('this');
            }
        
    }       
    
    public function handleDeleteThread($threadId){
        $thread = $this->threadManager->getThread($threadId);       
            if(!$thread){
                $this->flashMessage('Zadané vlákno neexistuje.');
                $this->redirect('this');
            }
            $authorId = $thread->users_id;
            $user = $this->getUser();
            if(($authorId == $user->id) || $user->isInRole('admin')){
                
               $this->threadManager->deleteThread($threadId);
               $this->flashMessage('Vlákno bylo úspěšně smazáno.','success');
               $this->redirect('this');
            }
            else{
               $this->flashMessage('Nemáte dostatečné oprávnění pro smazání vlákna','error');
               $this->redirect('this'); 
            }
    }
    
    public function handleDeletePost($postId){
        $post = $this->postManager->getPost($postId);
        if(!$post){
            $this->flashMessage('Zadaný příspěvek neexistuje.');
            $this->redirect('this');
        }
        $authorId = $post->users_id;
        $user = $this->getUser();
        if(($authorId == $user->id) || $user->isInRole('admin')){

           $this->postManager->deletePost($postId);
           $this->flashMessage('Příspěvek byl úspěšně smazán.','success');
           $this->redirect('this');
        }
        else{
           $this->flashMessage('Nemáte dostatečné oprávnění pro smazání příspěvku','error');
           $this->redirect('this'); 
        }
}
     
    
  
   
    
}
