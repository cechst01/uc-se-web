<?php
namespace AdminModule;

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


class ExercisesPresenter extends ManagePresenter{
       
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
    
    public function actionManage(){
        
        if($this->user->isInRole('admin')){
           $exercises = $this->filtre($this->exerciseManager);
        }
        else{
            $id = $this->user->id;
            $exercises = $this->filtre($this->exerciseManager,$id);
        }
       
        $this->template->exercises = $exercises;        
        $this->template->type = $this->type;
        $this->template->sort = '';
        
        $this['exercisesFiltreForm']->setDefaults($this->filter); 
        
        $this['breadcrumb']
                    ->addLinks([
                                ['Cvičení',$this->link(':Admin:Exercises:manage'),'Administrace cvičení'],                               
                               ]);
    }
    
    protected function createComponentExercisesFiltreForm(){
        $categories = $this->categoryManager->getCategoryFullLeafs();
        $one = [0 => 'Všechny'];
        $categories = $one + $categories;
        $sections = $this->exerciseManager->getExercisesSections();
        $sections  = $one + $sections;
        $form = new Form();
        $form->setMethod(Form::GET);
        $form->addText('namesearch');
        $form->addText('authorsearch');
        $form->addSelect('categorySelect','',$categories);
        $form->addSelect('sectionSelect','',$sections);
        $form->addSelect('hiddenselect','',[ 3 => 'Všechny',0 => 'Dokončené', 1 => 'Rozepsané']);
        $form->addSubmit('send','Filtrovat');
        $form->onSuccess[] = [$this,'filterSucceeded'];

        return $form;
    }   
    
    public function handleDeleteExercise($exerciseId){    
       $exercise = $this->exerciseManager->getExercise($exerciseId)[0];
       
        if(!$exercise){
            $this->flashMessage('Zadané cvičení neexistuje.','error');
            $this->redirect('this');
        }
        $userIsAuthor = $exercise['users_id'] == $this->user->id;
        if(!($this->user->isInRole('admin')|| $userIsAuthor)){
            $this->flashMessage('Zadané cvičení nemůžete smazat. Nejste jeho autorem, ani nemáte administrátorská práva.','error');
            $this->redirect('this'); 
        }
        $name = $exercise->name;
        $this->exerciseManager->deleteExercise($exerciseId);
        $message = "Cvičení $name byl úspěšně smazáno.";
        $this->flashMessage($message,'success');
        $this->redirect('this');
    }

    public function handleSortExercises($orderColumn, $orderType){
               
        $exercises = $this->sort($this->exerciseManager, $orderColumn, $orderType);
       
        $this->template->exercises = $exercises;       
   
    }
    
    public function handleRemoveFilter(){
      
        $exercises = $this->removeFilter($this->exerciseManager);      
       
        $this->template->exercises = $exercises;
        
        $this->redirect('this');
    }
   
}
