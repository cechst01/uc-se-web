<?php
namespace App\Model;

use Nette;
use App\Model\BaseManager;

class CategoryManager extends BaseManager
{
    const 
            TABLE_NAME = 'categories',
            COLUMN_ID = 'categories_id',
            COLUMN_NAME = 'name',           
            COLUMN_URL = 'url',          
            COLUMN_PARENT_ID = 'parent_id';
    
    public function getCategoryLeafs()
    {
        $leafs =  $this->database->table(self::TABLE_NAME)
                ->select(self::COLUMN_ID . ', ' . self::COLUMN_NAME)
                ->where(self::COLUMN_ID . ' NOT',
                        // Vnořený SELECT.
                        $this->database->table(self::TABLE_NAME)
                                ->select(self::COLUMN_PARENT_ID . ' AS ' . self::COLUMN_ID)
                                ->where(self::COLUMN_PARENT_ID . '!=' . 0)
                                
                )->where(self::COLUMN_URL,'')               
                ->order(self::COLUMN_ID)
                ->fetchAll();
          
           $editLeafs = [];
           
           foreach($leafs as $leaf){           
            $editLeafs[$leaf[self::COLUMN_ID]] = $this->getName($leaf[self::COLUMN_ID],'');
           }  
        
        
        return $editLeafs;
    }
    
    public function getCategoryFullLeafs(){
        
        $categoriesWithSections = $this->database->table('sections')
                ->select('DISTINCT category_id')
                ->fetchPairs(null,'category_id');     
                    
        $leafs =  $this->database->table(self::TABLE_NAME)
               ->select(self::COLUMN_ID . ', ' . self::COLUMN_NAME )
               ->where(self::COLUMN_ID . ' NOT',
                       // Vnořený SELECT.
                       $this->database->table(self::TABLE_NAME)
                               ->select(self::COLUMN_PARENT_ID . ' AS ' . self::COLUMN_ID)
                               ->where(self::COLUMN_PARENT_ID . '!=' . 0)

               )->where(self::COLUMN_URL,'')
               ->where(self::COLUMN_ID, $categoriesWithSections)
               ->order(self::COLUMN_ID)               
                ->fetchAll();
        
        $fullLeafs = [];
    
        foreach($leafs as $leaf){
           
            $fullLeafs[$leaf[self::COLUMN_ID]] = $this->getName($leaf[self::COLUMN_ID],'');
          
        }  
      
        return $fullLeafs;
        
    }
    
    public function getName($id,$name,$separator = false){
      
        $sep = $separator ? $separator : ' -> ';
        $leaf = $this->database->table(self::TABLE_NAME)
                        ->where(self::COLUMN_ID,$id)
                        ->fetch();        
        
        if($leaf[self::COLUMN_PARENT_ID] == 0){
            if(empty($name)){
                
                $name = $leaf[self::COLUMN_NAME];
            }
            else{
               $name = $leaf[self::COLUMN_NAME] . $sep . $name;  
            }
                   
            
        }
        else{
           if(empty($name)){
               $name = $leaf[self::COLUMN_NAME];
           }
           else{
              $name = $leaf[self::COLUMN_NAME] . $sep . $name;    
           }                 
           $name = $this->getName($leaf[self::COLUMN_PARENT_ID], $name,$sep);
        }
        return $name;
    }
    
    public function makeTree($categories, $parentId)
    {              
        $tree = array();       
        
        foreach($categories as $category)
        {
             $id = $category->categories_id;
             $cat = $categories;
            if($category->parent_id == $parentId)
            {
                $tree[$category->categories_id] = [
                    'category' => $category,
                    'subcategories' => $this->makeTree($categories,$category->categories_id)
                ];
              
            }
           
        }
        
        return $tree;
    }
    
    public function getCategories()
    {
        $categ = $this->database->table(self::TABLE_NAME)
                ->order(self::COLUMN_ID)
                ->fetchAll();
        $categories = $this->makeTree($categ,0);
        return $categories;
    }
    
    public function getCategoriesCount($ids){
       return $this->database->table(self::TABLE_NAME)
                ->where(self::COLUMN_ID,$ids)                
                ->count('*');
    }
    
    public function getCategory($categoryId){
        if($this->isParent($categoryId)){
            return false;
        }
        return $this->database->table(self::TABLE_NAME)
                ->where(self::COLUMN_ID,$categoryId)               
                ->fetch();                              
    }
    
    private function isParent($categoryId){
        $child = $this->database->table(self::TABLE_NAME)
                ->where(self::COLUMN_PARENT_ID,$categoryId)
                ->fetch();
        if(!$child){
            return false;
        }
        return true;
    }
       
    
    public function saveCategories($data){
       
       $oldCategories = $this->database->table(self::TABLE_NAME)
                              ->fetchAll();
       $ids = [];
        foreach ($oldCategories as $category){
           $ids[] = $category[self::COLUMN_ID];
        }
        $saveArray = [];
        $updateArray = [];
      
        foreach ($data as $id => $values){
            $item = [self::COLUMN_ID => $id];
            if(in_array($id, $ids)){                
                $idKey = array_search($id, $ids);
                unset($ids[$idKey]);
                
            }            
            foreach ($values as $parentId => $value){
              $item[self::COLUMN_NAME] = $value[self::COLUMN_NAME];             
              $item[self::COLUMN_URL] = $value[self::COLUMN_URL];
              $item[self::COLUMN_PARENT_ID] = $parentId;              
            }            
          $saveArray[] = $item;
          
        }
        $keys = array_keys($item);
        foreach($keys as $key){
            
         $updateArray[$key] = new Nette\Database\SqlLiteral("VALUES($key)");
        }
        if(!empty($ids)){
           $this->database->table(self::TABLE_NAME)
                ->where(self::COLUMN_ID,$ids)
                ->delete();  
        }
      
       $this->database->query('INSERT INTO '.self::TABLE_NAME,$saveArray, 'ON DUPLICATE KEY UPDATE ', $updateArray);
      
     }
       
    
}