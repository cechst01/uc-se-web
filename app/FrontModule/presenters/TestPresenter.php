<?php
namespace FrontModule;

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

class TestPresenter extends BasePresenter
{
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
    public function renderShow($testId)
    {
        $test = $this->testManager->getTest($testId); 
        if(!$test){
                $this->flashMessage('Zadaný test neexistuje.','error');
                $this->redirect(':Front:Homepage:');
            }
              
       
        if($this->user->isLoggedIn()){
            $result = $this->testManager->getResult($test['tests_id'],$this->user->id);
        }
        else{
            $result = false;
        }
        
        if($result){
            $nextDate = $this->testManager->nextDate($result);            
           if($nextDate){
              $this->flashMessage("Tento test jste už napsal, můžete si prohlédnout jeho výsledek.",'info');
              $this->flashMessage("Znovu můžete test zkusit $nextDate",'info');
              $this->redirect('Test:result',['testId' => $testId]); 
           }
        }      
                   
            $this->template->test = $test;            
            $sectionId = $test['sections_id'];
            $section = $this->sectionManager->getSection($sectionId);             
            $category = $section->category;    
            $this['breadcrumb']->addLinks([
                [$category->name,$this->link('Section:default',$category->categories_id),'Kategorie'],
                [$section->name,$this->link('Section:show',$section->sections_id),'Sekce'],
                [$test['name'],$this->link('Test:show',$test['tests_id']),'Test']
            ]); 
            
       $text = $this->textManager->getText('test-user');
       $this['helpControl']->setText($text);
    }
    
    public function actionResult($testId){
    
        $test = $this->testManager->getTest($testId);
        $this->template->test = $test;
       
        if($this->user->isLoggedIn()){
            
            $resultArray = $this->testManager->getResult($testId,$this->user->id);
            if(!$resultArray){
                $this->flashMessage('Požadovaný výsledek neexistuje.','error');
                $this->redirect(':Front:Homepage');
            }
            $this->template->resultArray = $resultArray;           
            
        }
        else{
            
            $result = $this->getSession('result');
            if(empty($result->resultArray)){
               $this->flashMessage('Požadovaný výsledek neexistuje.','error');
               $this->redirect(':Front:Homepage:');
            }       
           
            $this->template->resultArray = $result->resultArray;  
        }
        
        $this['breadcrumb']->addLinks([               
                ['Výsledek testu - ' . $test['name'],$this->link('Test:result',$test['tests_id']),'Výsledek testu']
            ]); 
       
    }
   
    protected function createComponentResultForm(){
        $form = new Form();
        $form->addSubmit('send','Vyhodnotit test')
                ->setAttribute('class','button');
        $form->onSuccess[] = [$this,'testResult'];
        
        return $form;
    }
    
public function TestResult($form){
    
    $data = $form->getHttpData();
    if($this->user->isLoggedIn()){
       $data['users_id'] = (int)$this->user->id;  
    }
    else{
       $data['users_id'] = -1;   
    }
    $resultArray =  $this->testManager->evaluateTest($data);
    $testId = $data['tests_id'];
    if(!$this->user->isLoggedIn()){
        $result = $this->getSession('result');
        $result->setExpiration(60);
        $result->resultArray = $resultArray;   
    }
    $this->redirect("Test:result",array('testId' => $testId));
   
}
  
}
