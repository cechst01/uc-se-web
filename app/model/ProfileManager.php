<?php
namespace App\Model;

use App\Model\BaseManager;
use App\Model\SectionManager;
use App\Model\CategoryManager;

class ProfileManager extends BaseManager{
    const TABLE_NAME = 'profiles',
          COLUMN_PICTURE_ID = 'pictures_id',
          COLUMN_ABOUT = 'about_me',
          COLUMN_MOTTO = 'motto',
          COLUMN_ID = 'users_id';
          
    
    
    const TABLE_RESULT = 'test_results',
            COLUMN_USERS = 'users_id';
    
    const DELETE_PICTURE = -4;
    
    public function saveProfile($profileData)
    {
        if($profileData[self::COLUMN_ID]){           
            
            $photo = $profileData['photo']; 
            
            if($photo->isImage() && $photo->isOk()){
              $oldProfile = $this->getProfile($profileData[self::COLUMN_ID]);                               
              $this->pictureManager->deletePicture($oldProfile[self::COLUMN_PICTURE_ID]);              
              $photoId = $this->pictureManager->saveProfilePicture($photo); 
              $profileData[self::COLUMN_PICTURE_ID] = $photoId;  
                            
            }
            unset($profileData['photo']); 
            
            $this->database->table(self::TABLE_NAME)
                           ->where(self::COLUMN_ID,$profileData[self::COLUMN_ID])
                           ->update($profileData);            
        }
       
    }
    
    public function getProfile($userId){
        
        $ret =  $this->database->table(self::TABLE_NAME)
                                  ->where(self::COLUMN_ID,$userId)
                                  ->fetch();                     
                          return $ret;
    }
    
    public function createProfile($userId){
        $profileData[self::COLUMN_ID] = $userId;
        $profileData[self::COLUMN_ABOUT] = '';
        $profileData[self::COLUMN_MOTTO] = '';       
        
        $row = $this->database->table(self::TABLE_NAME)->insert($profileData);
        
        return $row->getPrimary();
    }
    
    public function deleteProfile($id){
       $profileRow = $this->database->table(self::TABLE_NAME)
                    ->where(self::COLUMN_ID,$id);
       $profile = $profileRow->fetch();           
       $pictureId = $profile[self::COLUMN_PICTURE_ID];       
       $profileRow->delete();
       $this->pictureManager->deletePicture($pictureId);       
                    
    }
    
    public function deletePicture($profileId){
        $this->database->table(self::TABLE_NAME)
                ->where(self::COLUMN_ID,$profileId)
                ->update([self::COLUMN_PICTURE_ID => self::DELETE_PICTURE]);
    }   
        
     public function getDeletePicture(){
        return self::DELETE_PICTURE;
    }
}
