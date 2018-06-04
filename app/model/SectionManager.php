<?php
namespace App\Model;

use Nette;
use App\Model\BaseManager;
use Nette\Utils\Strings;

class SectionManager extends BaseManager
{
    const 
            TABLE_NAME = 'sections',
            COLUMN_ID = 'sections_id',
            COLUMN_NAME = 'name',
            COLUMN_DESCRIPTION = 'description',
            COLUMN_CATEGORY_ID = 'category_id';
    
    public function getSection($sectionId)
    {
       return $this->database->table(self::TABLE_NAME)
                //->select(self::COLUMN_NAME. ',' .self::COLUMN_ID)
                ->where(self::COLUMN_ID, $sectionId)
                //->fetchPairs(self::COLUMN_ID, self::COLUMN_NAME);
               ->fetch();
    }
    
    public function getSections($categoryId = false)
    {
        $sections =  $this->database->table(self::TABLE_NAME)
                          ->order(self::COLUMN_CATEGORY_ID);
        
        if($categoryId){
            $sections->where(self::COLUMN_CATEGORY_ID,$categoryId);
        }
        
        return $sections;     
    }
    
     public function getSectionsPairs($categoryId = 0)
    {
        $section =  $this->database->table(self::TABLE_NAME)
                    ->select(self::COLUMN_NAME. ',' .self::COLUMN_ID);
        if($categoryId != 0){
            $section->where(self::COLUMN_CATEGORY_ID, $categoryId);
        }
                    
         return $section
                 ->order(self::COLUMN_ID)
                 ->fetchPairs(self::COLUMN_ID, self::COLUMN_NAME);
    }
    
    public function getSectionAll($sectionId){
        return $this->database->table(self::TABLE_NAME)
                ->where(self::COLUMN_ID,$sectionId)
                ->fetch();
    }
    
    public function saveSections($data){
       
       // vyberu stare prvky a ulozim jejich Id do pole        
       $oldSections = $this->database->table(self::TABLE_NAME)
                             ->fetchAll();
       // tady zbydou ID sekci ktere se maji smazat
       $ids = [];
        foreach ($oldSections as $section){
           $ids[] = $section[self::COLUMN_ID];
        }
        
        $saveArray = [];
        $updateArray = [];
        $values = [];
        //projdu data, z pole id odstranim id ktere se nebudou mazat a naplnim pole ukladanymi hodnotami
        foreach ($data as $id => $values){           
            if(in_array($id, $ids)){                
                $idKey = array_search($id, $ids);
                unset($ids[$idKey]);                
            }          
          $values[self::COLUMN_ID] = $id;      
          $saveArray[] = $values;          
        }
        // vyberu klice a udelam z nich vyrazy kterymi se bude updatovat radek
        $keys = array_keys($values);
        foreach($keys as $key){            
         $updateArray[$key] = new Nette\Database\SqlLiteral("VALUES($key)");
        }
        // smazu sekce ktere jse nedostla v datech (nebyly v editoru)
        if(!empty($ids)){
           $this->database->table(self::TABLE_NAME)
                ->where(self::COLUMN_ID,$ids)
                ->delete();  
        }
        
        \Tracy\Debugger::barDump($saveArray,'saveArray');
        \Tracy\Debugger::barDump($updateArray,'updateArray');
        
      // vlozim zaznamy, pokud zaznam existuje upravuje se zaznam pomoci vyrazu vytvorenych vyse
        if(!empty($saveArray)){
            $this->database->query('INSERT INTO '.self::TABLE_NAME,$saveArray, 'ON DUPLICATE KEY UPDATE ', $updateArray);
        }
        
        
       
        
    }  
    
}
