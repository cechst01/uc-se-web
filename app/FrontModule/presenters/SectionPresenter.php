<?php

namespace FrontModule;

use App\Model\SectionManager;
use App\Model\CategoryManager;
use App\Model\TutorialManager;
use App\Model\ExerciseManager;
use App\Model\TestManager;
use App\Model\PictureManager;
use App\Model\TextManager;
use App\Components\IPaginationControlFactory;
use App\Components\IPictureControlFactory;
use App\Components\IMenuControlFactory;
use App\Components\IUserControlFactory;

class SectionPresenter extends BasePresenter
{
    private $tutorialManager;
    private $exerciseManager;
    private $testManager;
    
     public function __construct(CategoryManager $categoryMan, SectionManager $sectionMan,
                                PictureManager $picMan,TextManager $textMan,
                                TutorialManager $tutMan, ExerciseManager $exMan,TestManager $testMan,
                                IPaginationControlFactory $paginationControlFactory,
                                IPictureControlFactory $pictureControlFactory,
                                IMenuControlFactory $menuControlFactory,
                                IUserControlFactory $userControlFactory) {
        
        parent::__construct($categoryMan, $sectionMan, $picMan, $textMan,
                            $paginationControlFactory, $pictureControlFactory,
                            $menuControlFactory, $userControlFactory);
        $this->tutorialManager = $tutMan;
        $this->exerciseManager = $exMan;
        $this->testManager = $testMan;
    }
	public function renderDefault($categoryId)
	{
          $category = $this->categoryManager->getCategory($categoryId);
          if(!$category){
              $this->flashMessage('Zadaná kategorie neexistuje.','error');
              $this->redirect(':Front:Homepage:');
          }
          $sections = $this->sectionManager->getSections($categoryId);
         
         $this->template->sections = $sections->fetchAll();
         $this->template->category = $category;
         $categoryName = $this->categoryManager->getName($categoryId,'',' > ');
         $this['breadcrumb']->addLinks([
             [$categoryName,$this->link('Section:default',$category->categories_id),'Kategorie']
         ]);
	}
        
        public function renderShow($sectionId)
        {  
            $section = $this->sectionManager->getSection($sectionId);
            if(!$section){
                $this->flashMessage('Zadaná sekce neexistuje.','error');
                $this->redirect(':Front:Homepage:');
            }
            $this->template->section = $section;
            $category = $section->category;
            //tutorials            
            $tutorials = $this->tutorialManager->getTutorials($sectionId);            
            $this->template->tutorials = $tutorials->fetchAll();
             
            
            //exercises
            $exercises = $this->exerciseManager->getExercises($sectionId);
            $this->template->exercises = $exercises->fetchAll();
          
            
            //tests
            $tests = $this->testManager->getTests($sectionId);               
            $this->template->tests = $tests->fetchAll();
           $categoryName = $this->categoryManager->getName($category->categories_id,'',' - ');
            $this['breadcrumb']->addLinks([
               [$categoryName,$this->link('Section:default',$category->categories_id),'Kategorie'],
                [$section->name,$this->link('Section:show',$section->sections_id),'Sekce']
            ]);
                    
        }
       

}