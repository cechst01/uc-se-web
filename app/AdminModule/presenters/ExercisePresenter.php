<?php

namespace AdminModule;

use App\Model;
use Nette\Application\UI\Form;
use App\Model\SectionManager;
use App\Model\CategoryManager;
use App\Model\ExerciseManager;
use App\Model\PictureManager;
use App\Model\TextManager;
use App\Components\IPaginationControlFactory;
use App\Components\IPictureControlFactory;
use App\Components\IMenuControlFactory;
use App\Components\IUserControlFactory;


class ExercisePresenter extends ContentPresenter
{
    protected $exerciseManager;
    
    public function __construct(CategoryManager $categoryMan, SectionManager $sectionMan,
                                PictureManager $picMan, TextManager $textMan, ExerciseManager $exerMan,                                
                                IPaginationControlFactory $paginationControlFactory,
                                IPictureControlFactory $pictureControlFactory,
                                IMenuControlFactory $menuControlFactory,
                                IUserControlFactory $userControlFactory){
        parent::__construct($categoryMan, $sectionMan, $picMan,
                            $textMan, $paginationControlFactory,
                            $pictureControlFactory, $menuControlFactory,
                            $userControlFactory);
        $this->exerciseManager = $exerMan;        
    }    
    
    public function actionManage($exerciseId){
      $user = $this->getUser();
      $id = $this->getUser()->id;
      $exercise = false;
      $link = ':Admin:Tutorial:manage';
     
      if($exerciseId){          
        $exerciseArray = $this->exerciseManager->getExercise($exerciseId);
        if(!$exerciseArray[0]){
            $this->flashMessage('Zadané cvičení neexistuje.','error');
            $this->redirect('Homepage:');
        }
        $exercise = $exerciseArray[0];
        $conditions = $exerciseArray[1];         
      }
        
            if($exercise)
            {
                $exercise=$exercise->toArray();               
                $pictureId = $exercise['pictures_id'];
                
                $linkName = "Cvičení - " . $exercise['name'];
                $linkParam = $exerciseId;
                             
                if($id == $exercise['users_id'] || $user->isInRole('admin')){
                    
                    $this['picture']->initControl($this->exerciseManager,$exerciseId,$pictureId); 
                    $section = $this->sectionManager->getSectionAll($exercise['sections_id']); 
                    $exercise['category'] = $section['category_id'];               
                    $sectionItems = $this->sectionManager->getSectionsPairs($section['category_id']);

                    $this['exerciseForm']['sections_id']->setItems($sectionItems);                
                    $this['exerciseForm']->setDefaults($exercise);
                    $this->template->name = $exercise['name'];
                    $this->template->exerciseId = $exercise['exercises_id'];
                    
                    if($conditions){
                        $this['exerciseForm']['selector']->setValue($conditions[0]['selector']);
                        $this['exerciseForm']['type']->setValue($conditions[0]['type']);                    
                        $this['exerciseForm']['value']->setValue($conditions[0]['value']);
                        $this['exerciseForm']['message']->setValue($conditions[0]['message']);
                        if($conditions[0]['property']){
                            $this['exerciseForm']['property']->setValue($conditions[0]['property']);
                            $this['exerciseForm']['property']->setDisabled(false);
                        }

                        unset($conditions[0]);                
                        $this->template->conditions = $conditions;
                    }
                    $this->template->types = $this->exerciseManager->types;                   
                  
                }
                else{
                    $this->flashMessage('Zadané cvičení nemůžete upravovat. Nejste jeho autorem, ani nemáte administrátorská práva.','error');
                    $this->redirect('Homepage:');
                }
            }
            else{
              $this['picture']->initControl($this->exerciseManager,false, Model\ExerciseManager::DELETE_PICTURE);
              $linkName = 'Nové cvičení';   
              $linkParam = '';
            }
        $text = $this->textManager->getText('exercise-admin');
        $this['helpControl']->setText($text);
        
        $this['breadcrumb']
                    ->addLinks([
                                [$linkName,$this->link($link, $linkParam),'Editace cvičení'],                               
                               ]);
    }
          
    public function createComponentExerciseForm()
    {
        $maxFileSize = $this->pictureManager->maxFileSize;
        $form = new Form;
        $form->addProtection();
        $form->addHidden('exercises_id');
        $form->addSelect('category','Výběr kategorie:',$this->categoryManager->getCategoryFullLeafs())
                ->setAttribute('class','input')
                ->setPrompt('Vyberte kategorii')
                ->setRequired('Musíte vybrat kategorii.');
        $form->addSelect('sections_id','Výběr sekce:')
               ->setAttribute('class','input')
               ->setPrompt('Vyberte sekci');
        $form->addText('name','Název:')
                ->setAttribute('class','input')
                ->setRequired('Musíte zadat název.');
        $form->addCheckbox('hidden','Označit jako rozpracované.')
                ->setAttribute('title','Rozpracované cvičení se nebude uživatelům zobrazovat, tak je možné ho dokončit později.');
        $form->addTextArea('description','Popis:')
                ->setAttribute('class','input')
                ->addConditionOn($form['hidden'], Form::BLANK)
                    ->setRequired('Pokud neoznačíte cvičení jako rozpracované, musíte vyplnit popis');
        $form->addTextArea('task','Zadání cvičení:')
                ->setAttribute('class',['input','task'])
                ->addConditionOn($form['hidden'], Form::BLANK)
                    ->setRequired('Pokud neoznačíte cvičení jako rozpracované, musíte vyplnit zadání');
        $form->addInteger('points','Počet bodů za cvičení:')
                ->setRequired('Musíte zadat počet bodů')   
                ->setDefaultValue(0)
                ->addRule(Form::RANGE, "Počet bodů musí být v rozmezí %d-%d",[0,10]);
        $form->addInteger('order_by','Pořadí v sekci:')
                ->setAttribute('title','Podle pořadí se v dané sekci cvičení seřadí.')
                ->setDefaultValue(1)
                ->addConditionOn($form['hidden'], Form::BLANK)
                    ->setRequired('Pokud neoznačíte cvičení jako rozpracované, musíte vyplnit pořadí.');
        $form->addCheckbox('disable_css','Vypnout CSS')
                ->setAttribute('title','Před kontrolou cvičení bude vypnuto CSS. Zvolte v případě že chcete, aby byly uznány jen styly nastavené JavaScriptem.');
        $form->addUpload('file','Obrázek u cvičení:')
                ->setAttribute('class','input')
                ->setAttribute('accept','.jpg, .png, .gif, .jpeg')
                ->addRule(Form::IMAGE,'Jsou povolené pouze obrázky ve formátech JPEG, PNG nebo GIF.')
                ->addRule(Form::MAX_FILE_SIZE, "Maximální velikost souboru je $maxFileSize kB.", $maxFileSize * 1024)
                ->setRequired(FALSE);
        $form->addTextArea('html_code','HTML kód cvičení')
                ->setAttribute('class',['editor','input','html-editor'])
                ->addConditionOn($form['hidden'], Form::BLANK)
                    ->setRequired('Pokud neoznačíte cvičení jako rozpracované, musíte vyplnit HTML kód');
        $form->addTextArea('css_code','Css kód cvičení')
               ->setAttribute('class',['editor','input'])
               ->setAttribute('data-mode','css');
        $form->addTextArea('js_code', 'JavaScript kód cvičení')
                ->setAttribute('class',['editor','input'])
                ->setAttribute('data-mode','javascript');      
        $form ->addText("selector",'Selektor:')
              ->setAttribute('id','selector')
              ->setAttribute('class','selector');
        $form->addSelect("type","Co chcete kontrolovat:", $this->exerciseManager->types)
              ->setAttribute('id','type')
              ->setAttribute('class','type')
              ->setPrompt('Vyberte typ kontroly');
        $form->addText("property",'Vlastnost:')
             ->setAttribute('id','property')
              ->setAttribute('class','property')
             ->setDisabled();          
        $form->addTextArea('value','Hodnota:')
              ->setAttribute('id','value')
              ->setAttribute('class','value');
        $form->addTextArea('message','Chybová zpráva:')
             ->setAttribute('id','message')
             ->setAttribute('class','message');
        $form->addButton('remove','Odebrat')
                ->setAttribute('class',['remove', 'smallButton']);
        $form->addSubmit('send','Uložit')              
              ->setAttribute('class',['button','scrollTop']);        
        $form->onValidate[] = [$this,'validateForm'];
        $form->onSuccess[] = [$this,'exerciseFormSucceeded'];
        $form->onError[] = [$this, 'exerciseFormError'];
        
        return $form;
    }
    
    public function validateForm($form){        
        $data = $form->getHttpData();        
        $this->validateExercise($data, $form); 
        $this->validateSectionId($data, $form);
     }
     
     private function validateExercise($data,$form){
         if(!empty($data['exercises_id'])){
            $exercise = $this->exerciseManager->getExercise($data['exercises_id'])[0];            
            if(!$exercise){
               $form->addError('Zadané cvičení neexistuje'); 
            }
            else{
              $this->validateAuthor($exercise, $form, 'Zadané cvičení');
            }
        }        
        $this->validateConditions($form, $data['conditions']);
     }
     
     private function validateConditions($form, $conditions){
         
         foreach($conditions as $condition){
             $emptySelector = empty($condition['selector']);
             $emptyProperty = empty($condition['property']);
             if(empty($condition['type'])){
                $type2 = false; 
             }
             else{
               $type2 = $condition['type'] == 2;  
             }
             
         if(!($emptySelector) && $type2 && !($emptyProperty)){
                 $allowedProperties = $this->exerciseManager->allowedProperties;
                if(!in_array($condition['property'], $allowedProperties)){
                   $form->addError("Vlastnost $condition[property] není podporována.") ;
                }
             }
         }        
     }
               
    
    public function exerciseFormSucceeded($form){ 
        
       $user = $this->getUser();
       $usersId = $user->getId();  
       $data = $form->getHttpData();       
       unset($data['category'],$data['send'],$data['_do'],$data['_token_']);       
       $id = $this->exerciseManager->saveExercise($data,$usersId); 
       $this->template->exerciseId = $id;
       $this->flashMessage('Cvičení, bylo úspěšně uloženo','success');          
       $this->redrawControl('flashes');
       $this->redrawControl('showExercise');      
       $this->redrawControl('wrapper');
       $this->redrawControl('hiddenId');
       //$this->redirect(':Front:Exercise:show',['exerciseId' => $id]);             
    }
    
    public function exerciseFormError($form){
       $this->flashMessage(implode(' ',$form->errors),'error');          
       $this->redrawControl('flashes');
    }
    
    
    
     public function handleCategoryChange($value){
            
        $items = $this->sectionManager->getSections($value);
        $ar = array();        
        foreach ($items as $item)
        {
            $ar[$item['sections_id']] = $item['name'];         
        }                    
         $this['exerciseForm']['sections_id']->setItems($ar); 
         $this['exerciseForm']['sections_id']->setPrompt(false); 

         $this->redrawControl('wrapper');
         $this->redrawControl('form');
    }
               
        
     protected function createComponentPicture(){
            
            return $this->pictureControlFactory->create();
        }
   }

