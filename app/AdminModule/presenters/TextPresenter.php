<?php

namespace AdminModule;

use Nette\Application\UI\Form;


class TextPresenter extends BasePresenter{
        
    public function actionManage(){
        $this->template->types = $this->textManager->getTypes();
        
        $this['breadcrumb']
                    ->addLinks([
                                ['Texty',$this->link(':Admin:Text:manage'),'Administrace textů'],                               
                               ]);
    }

    public function actionAdd($id){        
        $ids = $this->textManager->getIds();
        if(!in_array($id, $ids)){
           $this->flashMessage('Zadaný text neexistuje.','error');
           $this->redirect(':Admin:Homepage:');
        }
        $types = $this->textManager->getTypes();
        $text = $this->textManager->getTextById($id);
        $this->template->name = $types[$id];
        if($text){
           $this['textForm']->setDefaults($text);
                      
        }
        else{
          $this['textForm']['text_id']->setValue($id);
          
        }
        
        $this['breadcrumb']
                    ->addLinks([
                                ['Editace textu',$this->link(':Admin:Text:add'),'Editace textu'],                               
                               ]);
    }
    
    protected function createComponentTextForm(){
        $form = new Form();
        $form->addProtection();
        $form->addHidden('text_id');
        $form->addTextArea('content','Upravovaný text:')
                ->setAttribute('class','my')
                ->setRequired('Musíte vložit text.');
        $form->addSubmit('send','Uložit');
        $form->onValidate[] = [$this,'validateForm'];
        $form->onSuccess[] = [$this,'textFormSucceeded'];

        return $form;
    }
    
    public function validateForm($form,$values){
        $ids = $this->textManager->getIds();
        if(!in_array($values->text_id, $ids)){
           $form->addError('Zadaný text neexistuje.'); 
        }
        $keys = $this->textManager->getKeys();
        if($values->text_id == $keys['header']){
            $length = mb_strlen($values->content);
            if($length > 22){
                $form->addError('Do hlavičky je možné vložit jen 15 znaků.');
            }
            
        }
    }

    public function textFormSucceeded($form,$values){       
        $this->textManager->saveText($values);    
        $this->flashMessage('Text byl úspěšně uložen.','success');
        $this->redirect('Text:manage');
        
    }
}

