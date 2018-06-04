<?php

namespace AdminModule;

use Nette\Application\UI\Form;
use Nette\Utils\Json;

class SectionsPresenter extends BasePresenter{

    public function actionManage(){
        $categories = $this->categoryManager->getCategoryLeafs(true);
        $catJson = Json::encode($categories);
        $this->template->categories = $categories;
        $this->template->catJson = $catJson; 
        $sections = $this->sectionManager->getSections()->fetchAll();
        $this->template->sections = $sections;
        
        $text = $this->textManager->getText('sections');
        $this['helpControl']->setText($text);
        
        $this['breadcrumb']
                    ->addLinks([
                                ['Sekce',$this->link(':Admin:Sections:manage'),'Administrace sekcí'],                               
                               ]);
    }

    protected function createComponentSectionForm(){
        $form = new Form();
        $form->addSubmit('send','Uložit')
                ->setAttribute('class','button');
        $form->onValidate[] = [$this,'formValidate'];
        $form->onSuccess[] = [$this,'sectionFormSucceeded'];    

        return $form;
    }

    public function formValidate($form){
        $categoryIds = [];
        $data = $form->getHttpData();
        if(!isset($data['sections'])){
           return;
        }
        $sections = $data['sections'];
        foreach($sections as $section){
            if(empty($section['name'])){
                $form->addError('Musíte zadat jméno sekce.');
            }
            if(empty($section['description'])){
                $form->addError('Musíte zadat popis sekce.');
            }
            $categoryIds[] = $section['category_id'];
            $uniqueIds = array_unique($categoryIds);        
        }
        $categoriesCount = $this->categoryManager->getCategoriesCount($uniqueIds);
        if($categoriesCount != count($uniqueIds)){
            $form->addError('Musíte zadat správné kategorie.');
        }

    }

    public function sectionFormSucceeded($form,$values){
        $data = $form->getHttpData();
        if(!isset($data['sections'])){
            $data['sections'] = [];
        }     
        $this->sectionManager->saveSections($data['sections']);
        $this->flashMessage('Sekce byly úspěšně uloženy.','success');
        $this->redirect('this');   
    }

}