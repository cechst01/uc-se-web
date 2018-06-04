<?php
namespace FrontModule;

use App\Model;
use Nette\Application\UI\Form;
use App\Model\SectionManager;
use App\Model\CategoryManager;
use App\Model\ProfileManager;
use App\Model\PictureManager;
use App\Model\TextManager;
use App\Model\ResultManager;
use App\Model\ExerciseResultManager;
use App\Model\UserManager;
use App\Model\LevelManager;
use App\Components\IPaginationControlFactory;
use App\Components\IPictureControlFactory;
use App\Components\IMenuControlFactory;
use App\Components\IUserControlFactory;


class ProfilePresenter extends BasePresenter
{
    private $profileManager;
    private $testResultManager;
    private $exerciseResultManager;
    private $userManager;
    private $levelManager;
    
    public function __construct(CategoryManager $categoryMan, SectionManager $sectionMan, PictureManager $picMan,
                                TextManager $textMan, ProfileManager $profileMan,
                                ResultManager $testReMan, ExerciseResultManager $exReMan,
                                UserManager $userMan, LevelManager $levelMan,
                                IPaginationControlFactory $paginationControlFactory,
                                IPictureControlFactory $pictureControlFactory,
                                IMenuControlFactory $menuControlFactory,
                                IUserControlFactory $userControlFactory) {
        parent::__construct($categoryMan, $sectionMan, $picMan, $textMan,
                            $paginationControlFactory, $pictureControlFactory,
                            $menuControlFactory, $userControlFactory);
        $this->profileManager = $profileMan;
        $this->testResultManager = $testReMan;
        $this->exerciseResultManager = $exReMan;
        $this->levelManager = $levelMan;
        $this->userManager = $userMan;
    }
    
    public function renderShow($profileId){
        
        $profile= $this->profileManager->getProfile($profileId);
        
        $this->checkProfile($profile);
        
        $this->setVariables($profileId, $profile);        
        
        $this['breadcrumb']->addLinks([
            ['Profil uživatele',$this->link('Profile:show',$profileId),'']
        ]);
       
    }
    
    private function checkProfile($profile){
        if(!$profile){
            $this->flashMessage('Zadaný profil neexistuje.','error');
            $this->redirect(':Front:Homepage:');
        }
    }
    
    private function setVariables($profileId, $profile){
        
        $testResults = $this->testResultManager->getResults($profileId);
        $exerciseResults = $this->exerciseResultManager->getResults($profileId);
        $rank = $this->userManager->getRank($profileId);
               
        $this->template->profile = $profile;
        $this->template->testResults = $testResults;
        $this->template->exerciseResults = $exerciseResults;
        $this->template->rank = $rank;       
        
        $this->setSex($profile);
    }
    
    private function setSex($profile){
        
        if($profile->sex){
            if($profile->sex =='female'){
                $sex = 'Žena';
            }
            else{
               $sex = 'Muž'; 
            }
        }
        else{
            $sex = '';
        }
        
        $this->template->sex = $sex;
    }
    
    public function actionManage($profileId){
        
            if($this->getUser()->id != $profileId && !($this->user->isInRole('admin'))){                
                $param = ['profileId' => $this->getUser()->id];
                $this->flashMessage('Můžete upravovat pouze svůj profil.','error');
                $this->redirect(":Front:Profile:manage", $param);               
            }
            $profile = $this->profileManager->getProfile($profileId);
            if(!$profile){
                $this->flashMessage('Zadaný profil neexistuje.','error');
                $this->redirect(':Front:Homepage:');
            }
            $pictureId = $profile[Model\ProfileManager::COLUMN_PICTURE_ID];
            $this->template->profile = $profile;       
            $this['profileForm']->setDefaults($profile);           
            $this['picture']->initControl($this->profileManager,$profileId,$pictureId);
            
             
            
        $this['breadcrumb']->addLinks([
             ['Úprava profilu',$this->link('Profile:manage',$profileId),'']
        ]);
    }
    
    protected function createComponentProfileForm()
    {
        $maxFileSize = $this->pictureManager->maxFileSize;
        $option = ['male' => 'muž' ,'female' => 'žena'];
        $form = new Form();
        $form->addUpload('photo','Nový obrázek:')
                ->setAttribute('accept','.jpg, .png, .gif, .jpeg')
                ->addRule(Form::IMAGE,'Jsou povolené pouze obrázky ve formátech JPEG, PNG nebo GIF.')
                ->addRule(Form::MAX_FILE_SIZE, "Maximální velikost souboru je $maxFileSize kB.", $maxFileSize * 1024)
                ->setRequired(FALSE);
        $form->addTextArea('about_me','Informace o mně:');   
        $form->addTextArea('motto','Motto:');
        $form->addRadioList('sex','Pohlaví:', $option);
        $form->addText('address','Bydliště:');
        $form->addText('www','www:');                 
        $form->addSubmit('send','Uložit')
                ->setAttribute('class','button');
        $form->onSuccess[] = [$this,'profileFormSuceeded'];
        
        return $form;
    }   
        
    public function profileFormSuceeded($form, $values)
    {   
        $values['users_id'] = $this->user->id;
        $id = $values['users_id'];     
        $this->profileManager->saveProfile($values);
        $this->flashMessage('Profil byl úspěšně uložen.','success');
        $this->redirect(':Front:Profile:manage',['profileId' => $id]);
    }
   
    
    protected function createComponentPicture(){
            
            return $this->pictureControlFactory->create();
    }
     
    
}
