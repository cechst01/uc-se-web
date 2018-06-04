<?php
namespace AdminModule;

use Nette\Application\UI\Form;


class MenuPresenter extends BasePresenter{
    
    public function actionManage(){    
        $categories = $this->categoryManager->getCategories();
        $this->template->categories = $categories; 
        
        $text = $this->textManager->getText('menu');
        $this['helpControl']->setText($text);
        
        $this['breadcrumb']
                    ->addLinks([
                                ['Menu',$this->link(':Admin:Menu:manage'),'Administrace menu'],                               
                               ]);
    }

    protected function createComponentMenuForm(){
        $form = new Form();
        $form->addProtection();        
        $form->addSubmit('send','Uložit')
                ->setAttribute('class','button');
        $form->onValidate[] = [$this,'validateMenuForm'];
        $form->onSuccess[] = [$this,'menuFormSucceeded'];

        return $form;
    }
    
    public function validateMenuForm($form){
        $data = $form->getHttpData();
        $categoriesArray = $data['id'];
        $ids = array_keys($categoriesArray);
        $ids[] = 0;
        foreach($categoriesArray as $id => $category){
            $categoryData = reset($category);
            $key = array_search($categoryData, $category);
            if($categoryData['name'] == ""){
                $form->addError('Musíte vyplnit název kategorie.');
            }            
            if($key == $id){
                $form->addError('Kategorie jsou zadané chybně.');
            }
            if(!in_array($key, $ids)){
              $form->addError('Kategorie jsou zadané chybně.');  
            }
        }
    }

    public function menuFormSucceeded($form){
        $data = $form->getHttpData();       
        $categoriesArray = $data['id'];      
        $this->categoryManager->saveCategories($categoriesArray);
        $this->flashMessage('Kategorie menu byly úspěšně uloženy','success');
        $this->redirect('this');
    }

}