<?php
namespace AdminModule;

use Nette\Application\UI\Form;
use App\Model\SectionManager;
use App\Model\CategoryManager;
use App\Model\UserManager;
use App\Model\PictureManager;
use App\Model\TextManager;
use App\Components\IPaginationControlFactory;
use App\Components\IPictureControlFactory;
use App\Components\IMenuControlFactory;
use App\Components\IUserControlFactory;

class UsersPresenter extends ManagePresenter{
      
    private $userManager;
    
    public function __construct(CategoryManager $categoryMan, SectionManager $sectionMan,
                                    PictureManager $picMan, TextManager $textMan,
                                    UserManager $userMan,
                                    IPaginationControlFactory $paginationControlFactory,
                                    IPictureControlFactory $pictureControlFactory,
                                    IMenuControlFactory $menuControlFactory,
                                    IUserControlFactory $userControlFactory){
           
           parent::__construct($categoryMan, $sectionMan, $picMan, $textMan,
                               $paginationControlFactory, $pictureControlFactory,
                               $menuControlFactory, $userControlFactory);
           
           $this->userManager = $userMan;           
       }
      
    
    public function actionManage(){
       $this['usersFilterForm']->setDefaults($this->filter);
       $roles = $this->userManager->getRoles(); 
     
       $users = $this->filtre($this->userManager);
       
       $this->template->type = $this->type;
       $this->template->users = $users;    
       $this->template->roles = $roles;
       $this->template->sort = '';
       
       $this['breadcrumb']
                    ->addLinks([
                                ['Uživatelé',$this->link(':Admin:Users:manage'),'Administrace uživatelů'],                               
                               ]);
    }
    
    public function createComponentUsersFilterForm() {
       $roles = $this->userManager->getRoles();
       array_unshift($roles,'Všechny role');
       $lock = [ 3 => 'Vše',0 => 'Odemčeno', 1 => 'Zamčeno'];
       $form = new Form();
       $form->setMethod(Form::GET);
       $form->addText('namesearch');
       $form->addText('emailsearch');   
       $form->addSubmit('send', 'Filtrovat');
       $form->addSelect('role','', $roles)
               ->setAttribute('class','roleSelect');
       $form->addSelect('lock','',$lock);
       $form->onSuccess[] = [$this ,'filterSucceeded'];

       return $form;

    }
    
    public function handleSortUsers($orderColumn,$orderType){           
        
        $users = $this->sort($this->userManager, $orderColumn,$orderType);
        
        //$this->template->type = $this->type;
        $this->template->users = $users;        
    }
    
    /*
    public function handleFiltreUsers($orderColumn, $orderType){

        $this->usersFilter['ordercolumn'] = $orderColumn;
        $this->usersFilter['ordertype'] = $orderType;    
        $users = $this->userManager->getFiltreItems($this->usersFilter);
        
        $paginator = &$this['paginator']->getPaginator();
        $paginator->setItemCount(count($users));        
        $paginator->setPage($this->getParameter('page', 1));
        
        $users->limit($paginator->getLength(),$paginator->getOffset()); 
        $this->template->users = $users->fetchAll();   
    
        $this->type = ($orderType == 'ASC')? 'DESC' : 'ASC';
        $this->template->type = $this->type;
        unset($this->usersFilter['ordercolumn'],$this->usersFilter['ordertype']);
        $this->redrawControl('users');   
    }
     * 
     */

    public function handleChangeRole($userId, $roleId){
        $user = $this->userManager->getUser($userId);
        $roles = $this->userManager->getRoles();
        if(!isset($roles[$roleId])){
          $this->flashMessage('Zadaná role neexistuje.','error');
          $this->redirect('this');  
        }
        if(!$user){
            $this->flashMessage('Zadaný uživatel neexistuje.','error');
            $this->redirect('this');
        }
        if($userId == $this->user->id){
           $this->flashMessage('Z bezpečnostních důvodů nelze měnit roli vlastního účtu.');
           $this->redirect('this');
        }
        $this->userManager->changeRole($userId,$roleId);        
        $message = "Uživateli $user->username byla přidělena role $roles[$roleId].";
        $this->flashMessage($message,'info');
        $this->redirect('this');       
    }
    
    public function handleToggleLock($userId){
        $user = $this->userManager->getUser($userId);
        if(!$user){
            $this->flashMessage('Zadaný uživatel neexistuje.','error');
            $this->redirect('this');
        }
        if($userId == $this->user->id){
           $this->flashMessage('Z bezpečnostních důvodů nelze zamčít/odemčít vlastní účet.');
           $this->redirect('this');
        }
        $this->userManager->toggleLock($userId);
        if($user->locked == 0){
            $message = "Uživateli $user->username byl zablokován účet.";
        }
        else{
           $message = "Uživateli $user->username byl odlokován účet.";
        }
        $this->flashMessage($message,'info');
        $this->redirect('this');
    }
    
    public function handleDeleteUser($userId){
        $user = $this->userManager->getUser($userId);        
        if(!$user){
            $this->flashMessage('Zadaný uživatel neexistuje.','error');
            $this->redirect('this');
        }
        if($userId == $this->user->id){
           $this->flashMessage('Z bezpečnostních důvodů nelze smazat vlastní účet.');
           $this->redirect('this');
        }     
        $name = $user->username;
        $this->userManager->deleteUser($userId);
        $message = "Uživatel $name byl úspěšně smazán.";
        $this->flashMessage($message,'success');
        $this->redirect('this');
        
    }
    
    public function handleRemoveFilter(){
       
        $this->template->users = $this->removeFilter($this->userManager);
        
        $this->redirect('this');
        
    }
    
    /*
    public function handleRemoveFilter(){
        $this->usersFilter = [];
        $users = $this->userManager->getFiltreUsers($this->usersFilter);
        
        $paginator = &$this['paginator']->getPaginator();
        $paginator->setItemCount(count($users));        
        $paginator->setPage($this->getParameter('page', 1));
        
        $users->limit($paginator->getLength(),$paginator->getOffset()); 
        $this->template->users = $users->fetchAll();   
        
        $this->redirect('this');
    }
     * 
     */
    
    /*
    protected function createComponentPaginator(){
       return $this->paginationControlFactory->create('page');
    }
*/
    
}