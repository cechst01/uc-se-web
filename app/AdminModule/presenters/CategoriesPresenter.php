<?php
namespace AdminModule;

use Nette\Application\UI\Form;
use App\Model\SectionManager;
use App\Model\CategoryManager;
use App\Model\ForumManager;
use App\Model\PictureManager;
use App\Model\TextManager;
use App\Components\IPaginationControlFactory;
use App\Components\IPictureControlFactory;
use App\Components\IMenuControlFactory;
use App\Components\IUserControlFactory;


class CategoriesPresenter extends ManagePresenter{
     
    
    private $forumManager;
    
    public function __construct(CategoryManager $categoryMan, SectionManager $sectionMan,
                                PictureManager $picMan, TextManager $textMan,
                                ForumManager $forMan,
                                IPaginationControlFactory $paginationControlFactory,
                                IPictureControlFactory $pictureControlFactory,
                                IMenuControlFactory $menuControlFactory,
                                IUserControlFactory $userControlFactory) {
        
        parent::__construct($categoryMan, $sectionMan, $picMan, $textMan,
                            $paginationControlFactory, $pictureControlFactory,
                            $menuControlFactory, $userControlFactory);
        $this->forumManager = $forMan;
       
    }
    
    public function actionCategoryManage($categoryId){
        $category = false;
        if($categoryId){
            $category = $this->forumManager->getCategory($categoryId);
            if(!$category){
                $this->flashMessage('Zadaná kategorie neexistuje.');
                $this->redirect('this'); 
            }
        }
         
         if($category){
           $this['categoryForm']->setDefaults($category);
           $this->template->name = $category['name'];           
         }
          
        
    }
    
    protected function createComponentCategoryForm(){
        $form = new Form();
        $form->addProtection();
        $form->addText('name','Název kategorie:')
                ->setAttribute('class','input');
        $form->addTextArea('description','Popis kategorie')
                ->setAttribute('class','input');
        $form->addSubmit('send','Uložit');
        $form->addHidden('forum_categories_id');
        $form->onValidate[] = [$this,'validateCategoryForm'];
        $form->onSuccess[]  = [$this,'addCategory'];
        
        return $form;
    }
    
    public function validateCategoryForm($form,$values){      
            if(!empty($values['forum_categories_id'])){
              $category = $this->forumManager->getCategory($values['forum_categories_id']);
              if(!$category){
                $form->addError('Zadaná kategorie neexistuje');
              }
            }     
    }
    
    public function addCategory($form,$values){      
        
        $this->forumManager->saveCategory($values);
        $this->flashMessage('Kategorie byla úspěšně uložena.','success');
        $this->redirect(":Admin:Categories:categoriesManage");        
    }
    
    public function multipleDelete($deletedIds){
        if($this->getuser()->isInRole('admin')){
            $this->forumManager->deleteCategories($deletedIds);
            $this->flashMessage('Kategorie byly úspěšně smazány.','success');
            $this->redirect('this');
        }
    }
        
    public function actionCategoriesManage(){   
   
        $categories = $this->filtre($this->forumManager);

       $this['categoriesFilterForm']->setDefaults($this->filter);

       $this->template->categories = $categories;
       $this->template->type = $this->type;
       $this->template->sort = '';
       
       $this['breadcrumb']
                    ->addLinks([
                                ['Fórum',$this->link(':Admin:Categories:categories-manage'),'Administrace fóra'],                               
                               ]);
    }

    public function handleSortCategories($orderColumn, $orderType){   
                
        $categories = $this->sort($this->forumManager,$orderColumn,$orderType);      
        $this->template->categories = $categories;       
    }

    public function handleDeleteCategory($categoryId){
        $category = $this->forumManager->getCategory($categoryId);
        
        if(!$category){            
            $this->flashMessage('Zadaná kategorie neexistuje.','error');
            $this->redirect('this');
        }
        $name = $category->name;
        $this->forumManager->deleteCategory($categoryId);
        $this->flashMessage("Kategorie $name byla úspěšně smazána.",'info');
        $this->redirect('this');
    }

    public function createComponentCategoriesFilterForm(){     
        $form = new Form();
        $form->setMethod(Form::GET);
        $form->addText('namesearch');
        $form->addText('descriptsearch');
        $form->addText('authorsearch');       
        $form->addSubmit('send','Filtrovat');
        $form->onSuccess[] = [$this,'filterSucceeded'];

        return $form;
    }
    
    public function handleRemoveFilter(){              
        $categories = $this->removeFilter($this->forumManager);
  
        $this->template->categories = $categories;        
        $this->redirect('this');
    }
  
       
    
}

