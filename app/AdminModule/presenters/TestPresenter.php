<?php
namespace AdminModule;

use App\Model;
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


class TestPresenter extends ContentPresenter
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
        
    public function actionManage($testId)
    {
      $letters = ['A','B','C','D','E','F','G','H','I','J'];      
      $this->template->letters = $letters;
      $this->template->questionMaxFileSize = $this->pictureManager->questionMaxFileSize;
      
      $test = false;
      $user = $this->getUser();
      $id = $this->getUser()->id;
      
      $link = ':Admin:Tutorial:manage';
      
      if($testId){          
        $test = $this->testManager->getTest($testId);
        $pictureId = $test['pictures_id'];

        if(!$test){
            $this->flashMessage('Zadaný test neexistuje.','error');
            $this->redirect('Homepage:');
        }
      }
          
            if($test)
            {
                $linkName = "Test - " . $test['name'];
                $linkParam = $testId;
               
               if($id == $test['users_id'] || $user->isInRole('admin')){
                    $this['picture']->initControl($this->testManager,$testId,$pictureId);
                    $section = $this->sectionManager->getSectionAll($test['sections_id']); 
                    $test['category'] = $section['category_id'];               
                    $sectionItems = $this->sectionManager->getSectionsPairs($section['category_id']);
                    $this['testForm']['sections_id']->setItems($sectionItems);                  
                    $this['testForm']->setDefaults($test);                    
                    $this->template->questions = $test['questions']; 
                    $this->template->name = $test['name'];                    
               } 
               else{
                   $this->flashMessage('Zadaný test nemůžete upravovat. Nejste jeho autorem, ani nemáte administrátorská práva.','error');
                   $this->redirect('Homepage:');
               }             
               
            }
            else{
               $this['picture']->initControl($this->testManager,false, Model\TestManager::DELETE_PICTURE);
               $linkName = 'Nový test';   
               $linkParam = '';
            }
         $text = $this->textManager->getText('test-admin');
         $this['helpControl']->setText($text);
         
         $this['breadcrumb']
                    ->addLinks([
                                [$linkName,$this->link($link, $linkParam),'Editace tutorialu'],                               
                               ]);
    }
        
    protected function createComponentTestForm($name)
    {
        $maxFileSize = $this->pictureManager->maxFileSize;
        $form = new Form();
        $form->addProtection();
        $form->addSelect('category','Výběr kategorie:',$this->categoryManager->getCategoryFullLeafs())
               ->setAttribute('class','input')
                ->setPrompt('Vyberte kategorii')
                ->setRequired('Musíte vybrat kategorii.');                
        $form->addSelect('sections_id','Výběr sekce:')                
                 ->setAttribute('class','input')
                 ->setPrompt('Vyberte sekci');                 
        $form->addUpload('file','Obrázek testu:')
                ->setAttribute('class','input')
                ->setAttribute('accept','.jpg, .png, .gif, .jpeg')
                ->addRule(Form::IMAGE,'Jsou povolené pouze obrázky ve formátech JPEG, PNG nebo GIF.')
                ->addRule(Form::MAX_FILE_SIZE, 'Maximální velikost souboru je $maxFileSize kB.', $maxFileSize * 1024)
                ->setRequired(FALSE);
        $form->addHidden('tests_id');
        $form->addText('name','Název:')
                ->setAttribute('class','input')
                ->setRequired('Musíte zadat název.');
        $form->addCheckbox('hidden', 'Označit jako rozpracovaný')
                ->setAttribute('title','Rozpracovaný test se nebude uživatelům zobrazovat, tak je možné ho doknčit později.');
        $form->addTextArea('description','Popis:')
                ->setAttribute('class',['input','description'])
                ->addConditionOn($form['hidden'], Form::BLANK)
                   ->setRequired('Pokud neoznačíte test jako rozpracovaný, musíte vyplnit popis.');
        $form->addInteger('points', 'Počet bodů za test:')
                ->setRequired('Musíte zadat počet bodů')   
                ->setDefaultValue(0)
                ->addRule(Form::RANGE, "Počet bodů musí být v rozmezí %d-%d",[0,10]);
        $form->addSubmit('send','Uložit')
             ->setAttribute('id','add')
             ->setAttribute('class',['button']);
        $form->onValidate[] = [$this,'validateForm'];
        $form->onSuccess[] = [$this,'testFormSucceeded'];
         
        return $form;
    }
    
    public function validateForm($form){      
        $data = $form->getHttpData();       
        $this->validateSectionId($data, $form);
        $this->validateTest($data, $form);
        if(!isset($data['hidden'])){
            $this->validateQuestions($data, $form); 
        }
     }    
     
     private function validateTest($data,$form){
         if(!empty($data['tests_id'])){
            $test = $this->testManager->getTest($data['tests_id']);
            if(!$test){
               $form->addError('Zadaný test neexistuje'); 
            }
            else{
              $this->validateAuthor($test, $form,'Zadaný test');
            }
        }
     }
     
     private function validateQuestions($data,$form){
         if(empty($data['questions'])){
            $form->addError('Test musí obsahovat alespoň jednu otázku.');
            return;
         }
         $questions = $data['questions'];
         foreach($questions as $question){
             if($question['question'] == ""){
                 $form->addError('Pokud neoznačíte test jako rozpracovaný, otázka nesmí být prázdná.');
             }
             if(empty($question['answers'])){
                $form->addError('Otázka musí obsahovat odpovědi.');
                return;
             }
             if(count($question['answers']) < 2){
                 $form->addError('Na otázku musí být alespoň 2 odpovědi.');
                 return;
             }
             
             if($question['image']){
                 $this->validateImage($question['image'],$form);
             }
             
             
             foreach($question['answers'] as $answer){
                 if($answer['text'] == ''){
                     $form->addError('Pokud neoznačíte test jako rozpracovaný, odpověď nesmí být prázdná.');
                 }
             }
         }
     }
     
     private function validateImage($file,$form){
         if(!$file->isImage()){
             $form->addError('Jsou povolené pouze obrázky ve formátech JPEG, PNG nebo GIF.');
         }
         $maxSize = $this->pictureManager->questionMaxFileSize;
         if($file->getSize() > ($maxSize * 1024)){
             $form->addError("Maximální velikost souboru je  $maxSize kB.");
         }
         
         
     }
       
    
    public function testFormSucceeded($form){ 
       $data = $form->getHttpData();      
       $usersId = $this->getUser()->id;       
            
       $id =  $this->testManager->saveTest($data,$usersId);      
       $this->flashMessage('Test byl úspěšně uložen.','success');
       $this->redirect(':Front:Test:show',['testId'=> $id]);  
      
    }  
    
    public function handleCategoryChange($value){
        $items = $this->sectionManager->getSections($value);
        $ar = array();        
        foreach ($items as $item)
        {
            $ar[$item['sections_id']] = $item['name'];             
        }

         $this['testForm']['sections_id']->setItems($ar);
         $this['testForm']['sections_id']->setPrompt(false);
         $this->redrawControl('wrapper');
         $this->redrawControl('section');
    }
   
    protected function createComponentPicture(){
            
         return $this->pictureControlFactory->create();
    }

}
