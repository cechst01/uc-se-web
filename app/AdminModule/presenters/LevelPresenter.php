<?php

namespace AdminModule;

use App\Model\SectionManager;
use App\Model\CategoryManager;
use App\Model\PictureManager;
use App\Model\TextManager;
use App\Model\LevelManager;
use App\Model\UserManager;
use App\Components\IPaginationControlFactory;
use App\Components\IPictureControlFactory;
use App\Components\IMenuControlFactory;
use App\Components\IUserControlFactory;
use Nette\Application\UI\Form;

class LevelPresenter extends BasePresenter{
   
    private $levelManager;
    
    private $userManager;
    
    public function __construct(CategoryManager $categoryMan,
                                SectionManager $sectionMan,                              
                                PictureManager $picMan,                                                           
                                TextManager $textMan,
                                LevelManager $levelMan,
                                UserManager $userMan,
                                IPaginationControlFactory $paginationControlFactory,
                                IPictureControlFactory $pictureControlFactory,
                                IMenuControlFactory $menuControlFactory,
                                IUserControlFactory $userControlFactory
                                )
    {
        parent::__construct($categoryMan,$sectionMan,$picMan,$textMan,
                            $paginationControlFactory,$pictureControlFactory,
                            $menuControlFactory,$userControlFactory);
        
       $this->levelManager = $levelMan;
       $this->userManager = $userMan;
    }
    
    public function actionManage(){
        $levels = $this->levelManager->getLevels();
        $this->template->levels = $levels;
    }
    
    protected function createComponentLevelForm(){
        $form = new Form();
        $form->addProtection();          
        $form->addSubmit('send','Uložit')
                ->setAttribute('class','button');
        $form->onValidate[] = [$this,'validateLevelForm'];
        $form->onSuccess[] = [$this,'levelFormSucceeded'];

        return $form;
    }
    
    public function validateLevelForm($form){
        $data = $form->getHttpData();
        if(!isset($data['level'])){
            $form->addError('Musí být zadána alespoň jedna úroveň.');
            return;
        }
        $levels = $data['level'];        
        $items = [];
        foreach($levels as $level){
            if(empty($level['name'])){
                $form->addError('Musíte vyplnit název úrovně.');
            }
            if($level['max_points'] < 1){
                $form->addError('Limit bodů pro úroveň musí být větší než 0.');
            }
            if(isset($items[$level['max_points']])){
                $form->addError('Body u úrovní nesmí být stejné.');
            }
            else{
                $items[$level['max_points']] = 1;
            }
        }
        
    }
    
    public function levelFormSucceeded($form){
        $data = $form->getHttpData();
        unset($data['_token_'],$data['_do'],$data['send']);
        $this->levelManager->saveLevels($data);
        $this->userManager->updateAllLevels();
        //$this->redirect('this');
    }
    
    
}



