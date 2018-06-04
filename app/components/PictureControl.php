<?php
namespace App\Components;

use Nette\Application\UI\Control;
use App\Model\PictureManager;
use App\Model\TutorialManager;
use App\Model\ExerciseManager;
use App\Model\TestManager;

class PictureControl extends Control
{    
    const TEMPLATE = '/templates/picture.latte';
    const PICTURE_ID = 'pictures_id',
          TUTORIAL_ID = 'tutorials_id',
          EXERCISE_ID = 'exercises_id',
          TEST_ID = 'tests_id';    
    
    private $pictureManager;
    private $contentId;
    private $pictureId;
    private $manager;
        
    
    public function __construct(PictureManager $pic) {
        parent::__construct();
        $this->pictureManager = $pic;        
    }
    
    public function initControl($manager,$contentId,$pictureId){
        $this->manager = $manager;
        $this->contentId = $contentId;
        $this->pictureId = $pictureId;
    }
    
    
    public function handleDeletePicture(){      
    
      $this->manager->deletePicture($this->contentId);
      $this->pictureId = $this->manager->getDeletePicture();
      $this->redrawControl();
    }
    
    public function render()
    {
        $this->template->setFile(dirname(__FILE__) . self::TEMPLATE); // Nastaví šablonu komponenty.

        // Deklarace pomocných proměných.
        $picture = $this->pictureManager->getPicture($this->pictureId);    

        // Předává parametry do šablony.
        $this->template->picture = $picture;
       
        $this->template->render(); // Vykreslí komponentu.
    }
 
    
}

interface IPictureControlFactory
{
        /**
         * Vrací novou komponentu pro správu a vykreslování stránkování s automaticky inejectovanými závislostmi.
         * @return PictureControl komponenta pro správu a vykreslování stránkování
         */
        public function create();
}

