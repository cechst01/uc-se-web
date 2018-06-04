<?php

namespace AdminModule;

use Nette;
use App\Model\SectionManager;
use App\Model\CategoryManager;
use App\Model\PictureManager;
use App\Model\TextManager;
use App\Components\IPaginationControlFactory;
use App\Components\IPictureControlFactory;
use App\Components\IMenuControlFactory;
use App\Components\IUserControlFactory;

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
    
    protected function startup(){
        parent::startup();
        if (!$this->getUser()->isAllowed($this->getName(), $this->getAction())) {
            if($this->getUser()->isLoggedIn()){
                $this->flashMessage('Nemáte dostatečná oprávnění pro tuto akci.','error');
                if($this->getUser()->isInRole('editor')){
                $this->redirect('Homepage:');                       
                }
                else{
                  $this->redirect(':Front:Homepage:');   
                }
            }
            else{
                $this->flashMessage('Pro danou akci je nutné přihlášení','info');
                $this->redirect(':Front:Sign:in',['backlink' => $this->storeRequest()]);
            }
        }
        $this['userBar']->setAdminModule();


    }
        
    
    protected function createComponentMenu(){
        
        return $this->menuControlFactory->create();
    }
    
    protected function createComponentUserBar(){
        
        return $this->userControlFactory->create($this->getUser());
    }
    
    protected function createComponentPagination(){
        
        return $this->paginationControlFactory->create('page');
    }

    protected function handleRemovePicture($pictureId){

        $this->pictureManager->deletePicture($pictureId);
    }
    
    protected function createComponentBreadcrumb(){
        
        $breadcrumb = new \App\Components\Breadcrumb();
        $breadcrumb->addLink('Administrace', $this->link(':Admin:Homepage:default'),'Administrace');

        return $breadcrumb;        
    }
    
    protected function createComponentHelpControl(){
       return $help = new \App\Components\HelpControl();        
    }


    
    //pridani vlastniho latte filtru
    protected function beforeRender() {
        parent::beforeRender();
        
        $this->template->addFilter('bool',function($int,$true,$false){
            
            $bool = $int ? $true : $false;
            return $bool;
            
        });
        
        
        $this->template->header = $this->textManager->getText('header');
        $this->template->footer = $this->textManager->getText('footer');  
      
    }
    
    
}
