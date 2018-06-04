<?php
namespace App\Model;

use Nette;
use App\Model\BaseManager;

class TextManager extends BaseManager{
    
    const   TABLE_NAME = 'text',
            COLUMN_ID = 'text_id',          
            COLUMN_TEXT = 'content';
             
    
    private $types = [  1 => 'Nápověda -Tutorial - Uživatel',
                        2 => 'Nápověda - Tutorial - Administrátor',
                        3 => 'Nápověda - Cvičení - Administrátor',
                        4 => 'Nápověda - Cvičení - Uživatel',
                        5 => 'Nápověda - Test - Administrátor',
                        6 => 'Nápověda - Test - Uživatel',
                        7 => 'Nápověda - Editor',
                        8 => 'Nápověda - Administrace sekcí',
                        9 => 'Nápověda - Administrace menu',
                        10 => 'Úvodní text',
                        11 => 'Text hlavičky',
                        12 => 'Text patičky'
                     ];
    
    private $keys = [
        'tutorial-user' => 1,
        'tutorial-admin' => 2,
        'exercise-admin' => 3,
        'exercise-user' => 4,
        'test-admin' => 5,
        'test-user' =>6,
        'editor' => 7,
        'sections' => 8,
        'menu' => 9,
        'intro' => 10,
        'header' => 11,
        'footer' => 12
    ];
 
   
    public function saveText($data){        
        $text = $this->getTextById($data[self::COLUMN_ID]);     
        if($text){
           $id = $text[self::COLUMN_ID];
           $this->database->table(self::TABLE_NAME)
                   ->where(self::COLUMN_ID,$id)
                   ->update($data);
        }
        else{
           $this->database->table(self::TABLE_NAME)
                ->insert($data); 
        }
        
    }  
    
    public function getTextById($id){
        return $this->database->table(self::TABLE_NAME)
                ->where(self::COLUMN_ID,$id)
                ->fetch();        
    }
    
    public function getText($key){    
        $id = $this->keys[$key];
        $text = $this->database->table(self::TABLE_NAME)                
                ->where(self::COLUMN_ID,$id)
                ->fetch();
       
        return $text;
    }    
   
    public function getIds(){
        
        return array_keys($this->types);
    }
    
    public function getTypes(){
        return $this->types;
    }
     public function getKeys(){
         return $this->keys;
     }
  
}
