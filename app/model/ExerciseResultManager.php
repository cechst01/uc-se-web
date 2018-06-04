<?php

namespace App\Model;

use App\Model\BaseManager;
use App\Model\UserManager;

class ExerciseResultManager extends BaseManager{
    
    const   TABLE_NAME = 'exercise_results',
            COLUMN_EXERCISES_ID = 'exercises_id',
            COLUMN_USERS_ID = 'users_id',
            COLUMN_POINTS = 'points';
    
    private $userManager;
    
    public function __construct(\Nette\Database\Context $database, PictureManager $picMan, UserManager $usrMan) {
        parent::__construct($database, $picMan);
        $this->userManager = $usrMan;
    }
    
    public function getResult($exerciseId, $userId){
        $result = $this->database->table(self::TABLE_NAME)
                    ->where(self::COLUMN_EXERCISES_ID, $exerciseId)
                    ->where(self::COLUMN_USERS_ID,$userId)
                    ->fetch();
        return $result;
    }
    
    public function saveResult($exerciseId,$userId,$points){      
        $data = [self::COLUMN_EXERCISES_ID =>$exerciseId,
                 self::COLUMN_USERS_ID => $userId,
                 self::COLUMN_POINTS => $points];
        
        $updatedPoints = $this->updateUserPoints($exerciseId, $userId,$points);
        
        $result = $this->getResult($exerciseId, $userId);
        
        if($result){
            $this->update($data);
        }
        else{
            $this->save($data);
        }
        return $updatedPoints;      
    }
    
    private function save($data){
       $this->database->table(self::TABLE_NAME)
               ->insert($data);
    }
    
    private function update($data){
        $this->database->table(self::TABLE_NAME)
               ->where(self::COLUMN_EXERCISES_ID,$data[self::COLUMN_EXERCISES_ID])
                ->where(self::COLUMN_USERS_ID,$data[self::COLUMN_USERS_ID])
               ->update($data);
    }
    
    private function updateUserPoints($exerciseId,$userId,$points){       
        $oldResult = $this->getResult($exerciseId, $userId);

        if($oldResult){
            $oldPoints = $oldResult[self::COLUMN_POINTS];
            
            if($oldPoints != $points){
                $newPoints = $points - $oldPoints;
                $points = $newPoints > 0 ? $newPoints : 0;
                $this->userManager->changePoints($userId, $points);                 
            }
            else{
                $points = 0;
            }
        }
        else{
           $this->userManager->changePoints($userId, $points); 
        }        
        
        return $points;
    }
    
    public function getResults($userId){
        return $this->database->table(self::TABLE_NAME)
                ->where(self::COLUMN_USERS_ID,$userId)
                ->fetchAll();
    }
   
}
