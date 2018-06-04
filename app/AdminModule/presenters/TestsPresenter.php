<?php
namespace AdminModule;

use Nette\Application\UI\Form;
use App\Model\SectionManager;
use App\Model\CategoryManager;
use App\Model\TestManager;
use App\Model\PictureManager;
use App\Model\TextManager;
use App\Components\IPaginationControlFactory;
use App\Components\IPictureControlFactory;
use App\Components\IMenuControlFactory;
use App\Components\IUserControlFactory;


class TestsPresenter extends ManagePresenter{
      
    private $testManager;
   
    public function __construct(CategoryManager $categoryMan, SectionManager $sectionMan,
                                PictureManager $picMan, TextManager $textMan, TestManager $testMan,
                                IPaginationControlFactory $paginationControlFactory,
                                IPictureControlFactory $pictureControlFactory,
                                IMenuControlFactory $menuControlFactory,
                                IUserControlFactory $userControlFactory) {
        
        parent::__construct($categoryMan, $sectionMan, $picMan, $textMan,
                            $paginationControlFactory, $pictureControlFactory,
                            $menuControlFactory, $userControlFactory);
        
        $this->testManager = $testMan;
    }   
    
    public function actionManage(){ 
      
         if($this->user->isInRole('admin')){
           $tests = $this->filtre($this->testManager);
         }
         else{
            $id = $this->user->id;
            $tests = $this->filtre($this->testManager,$id);
         }        
        $this['testsFiltreForm']->setDefaults($this->filter);
  
        $this->template->tests = $tests;
        $this->template->sort = '';       
        $this->template->type = $this->type; 
        
        $this['breadcrumb']
                    ->addLinks([
                                ['Testy',$this->link(':Admin:Tests:manage'),'Administrace testů'],                               
                               ]);
    }
    
    protected function createComponentTestsFiltreForm(){
        $categories = $this->categoryManager->getCategoryFullLeafs();
        $one = [0 => 'Všechny'];
        $categories = $one + $categories;
        $sections = $this->testManager->getTestsSections();
        $sections  = $one + $sections;
        $form = new Form();
        $form->addtext('namesearch');
        $form->addText('authorsearch');
        $form->addtext('descriptsearch');
        $form->addSelect('categorySelect','',$categories);
        $form->addSelect('sectionSelect','',$sections);
        $form->addSelect('hiddenselect','',[3 =>'Všechny', 0 => 'Dokončené', 1=>'Rozepsané']);
        $form->addSubmit('send','Filtrovat');
        $form->onSuccess[] = [$this,'filterSucceeded'];

        return $form;
    }    

    public function handleSortTests($orderColumn, $orderType){
      
        $tests = $this->sort($this->testManager, $orderColumn, $orderType);
 
        $this->template->tests = $tests;
   
    }    
    
    public function handleDeleteTest($testId){
        $test = $this->testManager->getTest($testId);        
        if(!$test){
            $this->flashMessage('Zadaný test neexistuje.','error');
            $this->redirect('this');
        }
        $userIsAuthor = $test['users_id'] == $this->user->id;
        if(!($this->user->isInRole('admin')|| $userIsAuthor)){
            $this->flashMessage('Zadaný test nemůžete smazat. Nejste jeho autorem, ani nemáte administrátorská práva.','error');
            $this->redirect('this'); 
        }
        $name = $test['name'];
        $this->testManager->deleteTest($testId);
        $message = "Test $name byl úspěšně smazán.";
        $this->flashMessage($message,'success');
        $this->redirect('this'); 
    }
    
    public function handleRemoveFilter(){
       
        $tests = $this->removeFilter($this->testManager);
       
        $this->template->tests = $tests;
        
        $this->redirect('this');
    }  
    
}

