<?php
namespace FrontModule;

use App\Model;
use Nette\Application\UI\Form;
use App\Model\SectionManager;
use App\Model\CategoryManager;
use App\Model\ProfileManager;
use App\Model\PictureManager;
use App\Model\TextManager;
use App\Model\UserManager;
use App\Components\IPaginationControlFactory;
use App\Components\IPictureControlFactory;
use App\Components\IMenuControlFactory;
use App\Components\IUserControlFactory;

class RankPresenter extends BasePresenter{

    private $userManager;

    public function __construct(CategoryManager $categoryMan, SectionManager $sectionMan, PictureManager $picMan,
                                    TextManager $textMan,UserManager $userMan, 
                                    IPaginationControlFactory $paginationControlFactory,
                                    IPictureControlFactory $pictureControlFactory,
                                    IMenuControlFactory $menuControlFactory,
                                    IUserControlFactory $userControlFactory){
        parent::__construct($categoryMan, $sectionMan, $picMan, $textMan,
                            $paginationControlFactory, $pictureControlFactory,
                            $menuControlFactory, $userControlFactory);

        $this->userManager = $userMan;
    }
    
    public function actionShow(){
        $paginator = &$this['paginator']->getPaginator();
        $paginator->setItemCount($this->userManager->getUserCount());        
        $paginator->setPage($this->getParameter('page', 1));
        
        $ranks = $this->userManager->getRanks($paginator->getLength(),$paginator->getOffset());
        \Tracy\Debugger::barDump($ranks);
        $this->template->ranks = $ranks;
        
        $this['breadcrumb']->addLinks([
             ['Žebříček uživatelů',$this->link('Rank:show'),'']
        ]);
    }
    
    
    protected function createComponentPaginator(){
       return $this->paginationControlFactory->create('page');
    }
    
    
}
