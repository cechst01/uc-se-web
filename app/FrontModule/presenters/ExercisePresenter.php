<?php

namespace FrontModule;

use App\Model\SectionManager;
use App\Model\CategoryManager;
use App\Model\ExerciseManager;
use App\Model\ExerciseResultManager;
use App\Model\PictureManager;
use App\Model\TextManager;
use App\Components\IPaginationControlFactory;
use App\Components\IPictureControlFactory;
use App\Components\IMenuControlFactory;
use App\Components\IUserControlFactory;



class ExercisePresenter extends BasePresenter
{   
    protected $exerciseManager;
    protected $resultManager;
    
    public function __construct(CategoryManager $categoryMan, SectionManager $sectionMan,
                                PictureManager $picMan, TextManager $textMan, ExerciseManager $exerMan,
                                ExerciseResultManager $exResMan,
                                IPaginationControlFactory $paginationControlFactory,
                                IPictureControlFactory $pictureControlFactory,
                                IMenuControlFactory $menuControlFactory,
                                IUserControlFactory $userControlFactory){
        parent::__construct($categoryMan, $sectionMan, $picMan,
                            $textMan, $paginationControlFactory,
                            $pictureControlFactory, $menuControlFactory,
                            $userControlFactory);
        $this->exerciseManager = $exerMan;
        $this->resultManager = $exResMan;
    }    
    public function renderShow($exerciseId)
    {
        $exerciseArray = $this->exerciseManager->getExercise($exerciseId);       
        $exercise = $exerciseArray[0]; 
        if(!$exercise){
            $this->flashMessage('Zadané cvičení neexistuje.','error');
            $this->redirect(':Front:Homepage:');
        }
        $this->template->exercise = $exercise;
        
        $text = $this->textManager->getText('exercise-user');
        $this['helpControl']->setText($text);
       
        $section = $exercise->sections;
        $category = $section->category;
        $this['breadcrumb']->addLinks([
            [$category->name,$this->link('Section:default',$category->categories_id),'Kategorie'],
            [$section->name,$this->link('Section:show',$section->sections_id),'Sekce'],
            [$exercise->name,$this->link('Exercise:show',$exercise->exercises_id),'Cvičení'],
        ]);
    }
    
    public function handleSaveResult($exerciseId){
        
        $exercise = $this->exerciseManager->getExercise($exerciseId)[0];        
        $points = $exercise['points'];        
        $updatedPoints = $this->resultManager->saveResult($exerciseId, $this->user->id, $points);
       
        $pointsString = "bodů";
        if($updatedPoints == 1){
           $pointsString = "bod"; 
        }
        else if($updatedPoints > 1 && $updatedPoints < 5){
           $pointsString = "body";  
        }
        
        if($points == $updatedPoints){
            $message = "Získáváš $points $pointsString.";
        } 
        else if($updatedPoints == 0){
            $message = "Body jsi získal už v předchozím pokuse.";
        }
        else{
            $message = "Oproti předchozímu pokusu získáváš navíc $updatedPoints $pointsString.";
        }
        
        $this->flashMessage("Cvičení jsi vyřešil správně. " . $message);
        $this->redrawControl('flashes');
    }
    
   }

