<?php
namespace App\Model;

use App\Model\BaseManager;

class ConditionManager extends BaseManager{
    
    const   TABLE_NAME = 'conditions',
            COLUMN_ID = 'conditions_id',
            COLUMN_SELECTOR = 'selector',
            COLUMN_TYPE = 'type',
            COLUMN_PROPERTY = 'property',
            COLUMN_VALUE = 'value',
            COLUMN_MESSAGE = 'message',
            COLUMN_EXERCISE_ID = 'exercise_id';
    
    public function saveConditions($conditions,$exerciseId){       
       foreach($conditions as $condition){           
           $condition[self::COLUMN_EXERCISE_ID] = $exerciseId;
           $this->database->table(self::TABLE_NAME)
                           ->insert($condition);   
       }           
    }
    
    public function getConditions($exerciseId){
        return $this->database->table(self::TABLE_NAME)
                           ->where(self::COLUMN_EXERCISE_ID,$exerciseId)
                           ->order(self::COLUMN_ID . ', ' . self::COLUMN_PROPERTY)
                           ->fetchAll();
    }
    
    public function deleteConditions($exerciseId){
        $this->database->table(self::TABLE_NAME)
                       ->where(self::COLUMN_EXERCISE_ID,$exerciseId)
                       ->delete();
    }
    
    public function filtreConditions($conditions){
       $newConditions = [];
       foreach($conditions as $con){
           if(!empty($con['selector'])){
               $newConditions[] = $con;
           }
       }
       return $newConditions;
    }
    
}

