<?php
namespace AdminModule;

use App\Model;
use Nette\Application\UI\Form;
use App\Model\SectionManager;
use App\Model\CategoryManager;
use App\Model\TutorialManager;
use App\Model\PictureManager;
use App\Model\TextManager;
use App\Components\IPaginationControlFactory;
use App\Components\IPictureControlFactory;
use App\Components\IMenuControlFactory;
use App\Components\IUserControlFactory;

class TutorialPresenter extends ContentPresenter
{
    private $tutorialManager;    
       
    public function __construct(CategoryManager $categoryMan, SectionManager $sectionMan,
                                PictureManager $picMan,TextManager $textMan,
                                TutorialManager $tutMan,
                                IPaginationControlFactory $paginationControlFactory,
                                IPictureControlFactory $pictureControlFactory,
                                IMenuControlFactory $menuControlFactory,
                                IUserControlFactory $userControlFactory) {
        
        parent::__construct($categoryMan, $sectionMan, $picMan, $textMan,
                            $paginationControlFactory, $pictureControlFactory,
                            $menuControlFactory, $userControlFactory);
        $this->tutorialManager = $tutMan;
        
    }
        
    public function actionManage($tutorialId){    

        $user = $this->getUser();
        $id = $user->id;                     
        $tutorial = false;
        $link = ':Admin:Tutorial:manage';
        
        if($tutorialId){
           $tutorial = $this->tutorialManager->getTutorial($tutorialId);
           if(!$tutorial){
              $this->flashMessage('Zadaný tutoriál neexistuje.','error');
              $this->redirect('Homepage:');
           }
        }

        if($tutorial){ 

            $tutorial = $tutorial->toArray();               
            $pictureId = $tutorial['pictures_id'];  
            $linkName = "Tutorial - " . $tutorial['name'];
            $linkParam = $tutorialId;


                if($tutorial['users_id'] == $id || $user->isInRole('admin')){                    
                   $this['picture']->initControl($this->tutorialManager,$tutorialId,$pictureId);
                   // nastaveni kategorie a sekce pri uprave                    
                   $section = $this->sectionManager->getSectionAll($tutorial['sections_id']); 
                   $tutorial['category'] = $section['category_id'];               
                   $sectionItems = $this->sectionManager->getSectionsPairs($section['category_id']);                   
                   $this['tutorialForm']['sections_id']->setItems($sectionItems);
                   $this['tutorialForm']->setDefaults($tutorial);
                   $this->template->name = $tutorial['name'];

                }  
                else{
                    $this->flashMessage('Zadaný tutoriál nemůžete upravovat. Nejste jeho autorem, ani nemáte administrátorská práva.','error');
                    $this->redirect('Homepage:');
                }
        }
        else{
         $this['picture']->initControl($this->tutorialManager,false, Model\TutorialManager::DELETE_PICTURE);
         $linkName = 'Nový tutorial';   
         $linkParam = '';
        }

        $text = $this->textManager->getText('tutorial-admin');
        $this['helpControl']->setText($text);
        
        $this['breadcrumb']
                    ->addLinks([
                                [$linkName,$this->link($link, $linkParam),'Editace tutorialu'],                               
                               ]);

    }


    public function createComponentTutorialForm()
    {
        $maxFileSize = $this->pictureManager->maxFileSize;
                
        $form = new Form;
        $form->addProtection();
        $form->addHidden('tutorials_id');
        $form->addSelect('category','Výběr kategorie:',$this->categoryManager->getCategoryFullLeafs())
                ->setPrompt('Vyberte kategorii')
                ->setAttribute('class',['input','ajax'])
                ->setRequired('Musíte vybrat kategorii');                 
        $form->addSelect('sections_id','Výber sekce:')
               ->setAttribute('class','input')
               ->setPrompt('Vyberte sekci');              
        $form->addText('name','Název:')
                ->setAttribute('class','input')
                ->setRequired('Musíte zadat název');
        $form->addCheckbox('hidden',' Označit jako rozpracované.')
                ->setAttribute('title','Rozpracovaný tutoriál se nebude uživatelům zobrazovat, tak je možné ho dokončit později.');                 
        $form->addTextArea('description','Popis:')
                ->setAttribute('class',['input','description'])
                ->addConditionOn($form['hidden'], Form::BLANK)
                   ->setRequired('Pokud neoznačíte tutoriál jako rozpracovaný, musíte vyplnit popis');
        $form->addUpload('file','Obrázek tutoriálu:')    
                ->setAttribute('accept','.jpg, .png, .gif, .jpeg')
                ->addRule(Form::IMAGE,'Jsou povolené pouze obrázky ve formátech JPEG, PNG nebo GIF.')
                ->addRule(Form::MAX_FILE_SIZE, "Maximální velikost souboru je $maxFileSize kB.", $maxFileSize * 1024)
                ->setRequired(FALSE);
        $form->addTextArea('content','Obsah')
                ->setAttribute('class','my')
                ->addConditionOn($form['hidden'], Form::BLANK)
                   ->setRequired('Pokud neoznačíte tutoriál jako rozpracovaný, musíte vyplnit obsah');
        $form->addSubmit('send','Uložit')
              ->setAttribute('class',['button','save']);             
        $form->onValidate[] = [$this,'validateForm'];
        $form->onSuccess[] = [$this,'tutorialFormSucceeded'];

        return $form;
    }
     
    public function validateForm($form){      
        $data = $form->getHttpData();
        $this->validateSectionId($data, $form);
        $this->validateTutorial($data, $form);        
    }    
     
    private function validateTutorial($data,$form){
        if(!empty($data['tutorials_id'])){
           $tutorial = $this->tutorialManager->getTutorial($data['tutorials_id']);
           if(!$tutorial){
              $form->addError('Zadaný tutoriál neexistuje'); 
           }
           else{
             $this->validateAuthor($tutorial, $form,'Zadaný tutorial');
           }
       }
    }
   
    public function tutorialFormSucceeded($form,$values){
        $data = $form->getHttpData();    
        unset($data['category'],$data['send'],$data['_do'],$data['_token_']);                      
        $authorId = $this->user->getId();
        $id = $this->tutorialManager->saveTutorial($data,$authorId);
        $this->flashMessage('Tutoriál, byl úspěšně uložen','success');     
        $this->redirect(':Front:Tutorial:show',['tutorialId' => $id]);         
    }                 

    public function handleCategoryChange($value){     
        $items = $this->sectionManager->getSections($value);
        $ar = array();       
        foreach ($items as $item)
        {
            $ar[$item['sections_id']] = $item['name'];            
        }

         $this['tutorialForm']['sections_id']->setItems($ar);
         $this['tutorialForm']['sections_id']->setPrompt(false); 
         $this->redrawControl('wrapper');
         $this->redrawControl('form');  
    }

    protected function createComponentPicture(){
        return $this->pictureControlFactory->create();
    }

}
