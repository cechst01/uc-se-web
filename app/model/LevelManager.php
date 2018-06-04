<?php
namespace App\Model;

use App\Model\BaseManager;


class LevelManager extends BaseManager{
    
    const   TABLE_NAME = 'user_level',
            COLUMN_ID = 'user_level_id',
            COLUMN_NAME = 'name',
            COLUMN_MAX_POINTS = 'max_points';
    
    public function getLevels(){
        return $this->database->table(self::TABLE_NAME)  
                ->order(self::COLUMN_MAX_POINTS . ' ASC')
                        ->fetchAll();
    }
    
    public function saveLevels($data){
        $this->database->beginTransaction();
        
        try{
            $this->database->table(self::TABLE_NAME)->delete();
            $this->database->query('INSERT INTO ' . self::TABLE_NAME,$this->getSaveArray($data));
           
                 
        }
        catch(Nette\Database\DriverException $e){
            $this->database->rollBack();
        }
        
        $this->database->commit();        
        
    }
    
    private function getSaveArray($data){
        $levels = $data['level'];
        $insertValues = [];
        foreach($levels as $id => $level){
           $values = [];
           $values[self::COLUMN_ID] = $id;
           $values[self::COLUMN_NAME] = $level[self::COLUMN_NAME];
           $values[self::COLUMN_MAX_POINTS] = $level[self::COLUMN_MAX_POINTS];
           $insertValues[] = $values;
        }
     
        return $insertValues;
      
    }
    
    public function getLevelId($points){
        $pointsArray = $this->getLevelPoints();
        
        foreach($pointsArray as $id => $maxPoints){
            if($points <= $maxPoints){
                return $id;
            }            
        }
        return array_values($pointsArray)[0];
    }
    
    private function getLevelPoints(){
     return   $this->database->table(self::TABLE_NAME)
                ->select(self::COLUMN_ID .', ' . self::COLUMN_MAX_POINTS)
                ->order(self::COLUMN_MAX_POINTS . ' ASC')
                ->fetchPairs(self::COLUMN_ID,self::COLUMN_MAX_POINTS);
    }
}