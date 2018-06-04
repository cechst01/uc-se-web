<?php
namespace FrontModule;
use FrontModule\BasePresenter;
abstract class ContentPresenter  extends BasePresenter{
    
    protected function validateSectionId($data,$form){
         $sectionId = $data['sections_id'];  
         $section = $this->sectionManager->getSection($sectionId);
         if(!$section){
             $form->addError('Musíte zadat sekci.');
         }
     }
     protected function validateAuthor($content,$form,$type){         
         $author = $content['users_id'];
         if(!($author == $this->user->id || $this->user->isInRole('admin'))){
             $form->addError($type . ' nemůžete upravovat. Nejste jeho autorem, ani nemáte administrátorská práva.');
         }
     }
     
     protected function validateAuthorNoAdmin($content,$form,$type){         
         $author = $content['users_id'];
         if(!$author == $this->user->id){
             $form->addError($type . ' nemůžete upravovat. Nejste jeho autorem.');
         }
     }
     
}

