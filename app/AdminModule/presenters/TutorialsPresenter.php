<?php
namespace AdminModule;

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


class TutorialsPresenter extends ManagePresenter{
    
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
    
    public function actionManage(){ 

        if($this->user->isInRole('admin')){
            $tutorials = $this->filtre($this->tutorialManager);
        }
        else{
            $id = $this->user->id;
            $tutorials = $this->filtre($this->tutorialManager,$id);   
        }    
        $this['tutorialsFilterForm']->setDefaults($this->filter);
        $categories = $this->categoryManager->getCategoryFullLeafs();  
        
        $this->template->categories = $categories;
        $this->template->tutorials = $tutorials;        
        $this->template->type = $this->type;
        $this->template->sort = '';
        
        $this['breadcrumb']
                    ->addLinks([
                                ['Tutorialy',$this->link(':Admin:Tutorials:manage'),'Administrace tutorialů'],                               
                               ]);
    }
        
     public function createComponentTutorialsFilterForm(){
        $categories = $this->categoryManager->getCategoryFullLeafs();
        $one = [0 => 'Všechny'];
        $categories = $one + $categories;
        $sections = $this->tutorialManager->getTutorialsSections();
        $sections  = $one + $sections;
        $form = new Form();
        $form->setMethod(Form::GET);
        $form->addText('namesearch');
        $form->addText('descriptsearch');
        $form->addText('authorsearch');
        $form->addSelect('categorySelect','',$categories);
        $form->addSelect('sectionSelect','',$sections);
        $form->addSelect('hiddenSelect','',[ 3 =>'Všechny', 0 => 'Dokončené', 1=>'Rozpracované']);       
        $form->onSuccess[] = [$this,'filterSucceeded'];

        return $form;
    }
    
    public function handleSortTutorials($orderColumn, $orderType){    
      
        $tutorials = $this->sort($this->tutorialManager, $orderColumn, $orderType);
        
        $this->template->type = $this->type;         
        $this->template->tutorials = $tutorials;          
    }

    public function handleDeleteTutorial($tutorialId){
        $tutorial = $this->tutorialManager->getTutorial($tutorialId);        
        if(!$tutorial){
            $this->flashMessage('Zadaný tutorial neexistuje.','error');
            $this->redirect('this');
        }
        $userIsAuthor = $tutorial['users_id'] == $this->user->id;
        if(!($this->user->isInRole('admin')|| $userIsAuthor)){
            $this->flashMessage('Zadaný tutorial nemůžete smazat. Nejste jeho autorem, ani nemáte administrátorská práva.','error');
            $this->redirect('this'); 
        }
        $name = $tutorial->name;
        $this->tutorialManager->deleteTutorial($tutorialId);
        $message = "Tutoriál $name byl úspěšně smazán.";
        $this->flashMessage($message,'success');
        $this->redirect('this');
    }
    
     public function handleRemoveFilter(){
       
        $tutorials = $this->removeFilter($this->tutorialManager);
               
        $this->template->tutorials = $tutorials;
        
        $this->redirect('this');
    }
   
}

