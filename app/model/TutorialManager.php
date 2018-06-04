<?php
namespace App\Model;

use App\Model\BaseManager;
use Nette\Utils\Strings;

class TutorialManager extends BaseManager
{
    const
            TABLE_NAME = 'tutorials',
            COLUMN_ID = 'tutorials_id',
            COLUMN_NAME = 'name',
            COLUMN_DESRIPTION = 'description',
            COLUMN_CONTENT = 'content',
            COLUMN_SECTION_ID = 'sections_id',
            COLUMN_PICTURE_ID = 'pictures_id',
            COLUMN_CREATED = 'created_at',
            COLUMN_CHANGED = 'changed_at',
            COLUMN_HIDDEN = 'hidden',
            COLUMN_AUTHOR = 'users_id';         
    
    
    const DELETE_PICTURE = -2;
   
    public function getTutorial($tutorialId)
    {
       return  $this->database->table(self::TABLE_NAME)                
                    ->where(self::COLUMN_ID, $tutorialId)->fetch();   
    }
      
    
    public function saveTutorial($data,$authorId)
    {
        
        $data[self::COLUMN_AUTHOR] = $authorId;
        
        if(!empty($data[self::COLUMN_HIDDEN])){
          $data[self::COLUMN_HIDDEN] = 1;
        }
        else{
           $data[self::COLUMN_HIDDEN] = 0; 
        }
        
        if(empty($data[self::COLUMN_SECTION_ID])){
            unset($data[self::COLUMN_SECTION_ID]);
        }
        
        
        if($data['tutorials_id'])
        {
            $data[self::COLUMN_CHANGED] = date('Y-m-d'); 
            unset($data[self::COLUMN_AUTHOR]);
            if($data['file']){             
                
               $oldTutorial = $this->getTutorial($data[self::COLUMN_ID]);
               $oldPictureId = $oldTutorial[self::COLUMN_PICTURE_ID];
               $this->pictureManager->deletePicture($oldPictureId);
               $pictureId = $this->pictureManager->saveTutorialPicture($data['file']);
               $data[self::COLUMN_PICTURE_ID] = $pictureId;               
            }
            unset($data['file']);
               $this->database->table(self::TABLE_NAME)
                    ->where(self::COLUMN_ID,$data['tutorials_id'])
                    ->update($data);
            $id = $data[self::COLUMN_ID];
        }
        else
        {
            $data[self::COLUMN_CREATED] = date('Y-m-d');
            $data[self::COLUMN_CHANGED] = date('Y-m-d');
            if($data['file']){
            $pictureId = $this->pictureManager->saveTutorialPicture($data['file']);            
            $data[self::COLUMN_PICTURE_ID] = $pictureId;           
            }
             unset($data['file']);
        $row =  $this->database->table(self::TABLE_NAME)->insert($data);
        $id = $row->getPrimary();       
        }               
        
        return $id;
        
    }  
        
    public function getTutorials($sectionId)
    {
        return $this->database->table(self::TABLE_NAME)
                //->select(self::COLUMN_ID,self::COLUMN_NAME,self::COLUMN_DESRIPTION)
                ->where(self::COLUMN_SECTION_ID,$sectionId)
                ->where(self::COLUMN_HIDDEN,0)
                ->order(self::COLUMN_CREATED);
    }
    
    public function getFiltreItems($parameters,$userId=false){
        
        $tutorials = $this->database->table(self::TABLE_NAME);
        
            if($userId){
                $tutorials->where(self::COLUMN_AUTHOR,$userId);
            }
        
            if(empty($parameters)){
                return $tutorials;
            }

            if(isset($parameters['hiddenSelect']) && $parameters['hiddenSelect'] != 3){                
                
                $tutorials->where(self::COLUMN_HIDDEN . ' = ' . $parameters['hiddenSelect']);
            }
            
            if(isset($parameters['categorySelect']) && $parameters['categorySelect'] != 0){                
                
                $tutorials->where('sections.category_id = '. $parameters['categorySelect']);
            }
            
            if(isset($parameters['sectionSelect']) && $parameters['sectionSelect'] != 0){                
                
                $tutorials->where(self::COLUMN_SECTION_ID . ' = '. $parameters['sectionSelect']);
            } 
            
            if(!empty($parameters['namesearch'])){
                
               $tutorials->where(self::COLUMN_NAME . ' LIKE','%'.$parameters['namesearch'].'%');
            }
            
            if(!empty($parameters['descriptsearch'])){
                
               $tutorials->where(self::COLUMN_DESRIPTION . ' LIKE','%'.$parameters['descriptsearch'].'%');
            }
            
            if(!empty($parameters['authorsearch'])){
                
               $tutorials->where('users.username' . ' LIKE','%'.$parameters['authorsearch'].'%');
            }
            
            $orderTutorials = parent::order($tutorials, self::TABLE_NAME, $parameters);
              
        
        return $orderTutorials;
    }
    
    public function deletePicture($tutorialId){
        
        $this->database->table(self::TABLE_NAME)
                        ->where(self::COLUMN_ID,$tutorialId)
                        ->update([self::COLUMN_PICTURE_ID => self::DELETE_PICTURE]);
    }
    
    public function deleteTutorial($tutorialId){
        $row = $this->database->table(self::TABLE_NAME)
                    ->where(self::COLUMN_ID,$tutorialId);
        $tutorial = $row->fetch();
        $pictureId = $tutorial[self::COLUMN_PICTURE_ID];
        $row->delete();
        $this->pictureManager->deletePicture($pictureId);
                    
    }
    
    public function getTutorialsSections(){
     return  $this->database->table(self::TABLE_NAME)
                ->select('DISTINCT tutorials.'.self::COLUMN_SECTION_ID.' AS idecko' . ', sections.name AS name')
                ->order('idecko')
                ->fetchPairs('idecko','name');
     }   
          
    public function getDeletePicture(){
        return self::DELETE_PICTURE;
    }
  
   
}