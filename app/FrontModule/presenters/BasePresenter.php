<?php

namespace FrontModule;

use Nette;
use App\Model\SectionManager;
use App\Model\CategoryManager;
use App\Model\PictureManager;
use App\Model\TextManager;
use App\Components\IPaginationControlFactory;
use App\Components\IPictureControlFactory;
use App\Components\IMenuControlFactory;
use App\Components\IUserControlFactory;
use Nette\Application\UI\Multiplier;

/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{

    protected $categoryManager;
    protected $sectionManager; 
    protected $pictureManager;      
    protected $paginationControlFactory;
    protected $pictureControlFactory;
    protected $menuControlFactory;
    protected $userControlFactory;
    protected $textManager;
    
    
    public function __construct(CategoryManager $categoryMan,
                                SectionManager $sectionMan,                              
                                PictureManager $picMan,                                                            
                                TextManager $textMan,
                                IPaginationControlFactory $paginationControlFactory,
                                IPictureControlFactory $pictureControlFactory,
                                IMenuControlFactory $menuControlFactory,
                                IUserControlFactory $userControlFactory
                                )
    {
        parent::__construct();
        $this->categoryManager = $categoryMan;
        $this->sectionManager = $sectionMan;     
        $this->pictureManager = $picMan;            
        $this->textManager = $textMan;
        $this->paginationControlFactory = $paginationControlFactory;
        $this->pictureControlFactory = $pictureControlFactory;
        $this->menuControlFactory = $menuControlFactory;
        $this->userControlFactory = $userControlFactory;
    }
      
    
    protected function createComponentMenu(){
        
        return $this->menuControlFactory->create();
    }
    
    protected function createComponentUserBar(){
        return new Multiplier(function () {

           $userBar = $this->userControlFactory->create($this->getUser());
           return $userBar;

        });
    }
    
    protected function createComponentPagination(){
        
        return $this->paginationControlFactory->create('page');
    }

    protected function handleRemovePicture($pictureId){

        $this->pictureManager->deletePicture($pictureId);
    }
    
    protected function createComponentBreadcrumb(){
        
        $breadcrumb = new \App\Components\Breadcrumb();
        $breadcrumb->addLink('Home', $this->link('Homepage:default'),'Úvodní stránka');

        return $breadcrumb;        
    }
    
    protected function createComponentHelpControl(){
       return $help = new \App\Components\HelpControl();        
    }


    
    //pridani vlastniho latte filtru
    protected function beforeRender() {
        parent::beforeRender();
        
        $this->template->addFilter('bool',function($int){
            
            $bool = $int ? 'True' : 'False';
            return $bool;
            
        });
        
        $this->template->header = $this->textManager->getText('header');
        $this->template->footer = $this->textManager->getText('footer'); 
    }
    
    
}
