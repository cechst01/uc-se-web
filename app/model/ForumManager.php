<?php
namespace App\Model;
use App\Model\BaseManager;

class ForumManager extends BaseManager{
    const   TABLE_NAME = 'forum_categories',
            COLUMN_ID = 'forum_categories_id',
            COLUMN_NAME = 'name',
            COLUMN_DESCRIPTION = 'description';               
   
    public function getCategories()
    {
        return $this->database->table(self::TABLE_NAME)
                    ->order(self::COLUMN_ID)
                    ->fetchAll();
    }   
    
    public function saveCategory($data){
        if($data[self::COLUMN_ID]){
            $this->editCategory($data);
        }
        else{
            
            $this->database->table(self::TABLE_NAME)
                ->insert($data);
    }
        }
        
    
    public function deleteCategory($categoryId){
        $this->database->table(self::TABLE_NAME)
                ->where(self::COLUMN_ID,$categoryId)
                ->delete();
    }
    
    public function deleteCategories($deletedIds){
        $this->database->table(self::TABLE_NAME)
                ->where(self::COLUMN_ID . ' IN ', $deletedIds)
                ->delete();
    }
    
    public function getCategory($categoryId){        
        
        $category =  $this->database->table(self::TABLE_NAME)
                            ->where(self::COLUMN_ID,$categoryId)
                            ->fetch();       
     
        return $category;
    }
    
    private function editCategory($data){        
        $id = $data[self::COLUMN_ID];
        unset($data[self::COLUMN_ID]);
        
        $this->database->table(self::TABLE_NAME)
                ->where(self::COLUMN_ID,$id)
                ->update($data);
    }
    
    public function getFiltreItems($parameters){
        
        $categories = $this->database->table(self::TABLE_NAME);
        
            if(empty($parameters)){
                return $categories;
            }
                        
            if(!empty($parameters['namesearch'])){
                
               $categories->where(self::COLUMN_NAME . ' LIKE','%'.$parameters['namesearch'].'%');
            }
            
            if(!empty($parameters['descriptsearch'])){
                
               $categories->where(self::COLUMN_DESCRIPTION . ' LIKE','%'.$parameters['descriptsearch'].'%');
            }
            
            if(isset($parameters['ordercolumn']) && $parameters['ordercolumn'] =='threads_count'){
                $categories->order('(SELECT COUNT(*) FROM threads WHERE f_category_id = forum_categories_id)'.$parameters['ordertype']);
            }
            
            if(isset($parameters['ordercolumn']) && $parameters['ordercolumn'] =='posts_count'){
                $categories->order
                ('(SELECT COUNT(*) FROM posts WHERE threads_id IN (SELECT threads_id FROM threads WHERE f_category_id = forum_categories_id))'.$parameters['ordertype']);
            }
            
            if(isset($parameters['ordercolumn']) && $parameters['ordercolumn'] =='last_post'){
                $categories->order
                ('(SELECT MAX(created_at) FROM posts WHERE threads_id IN (SELECT threads_id FROM threads WHERE f_category_id = forum_categories_id))'.$parameters['ordertype']);
            }
            
            $orderCategories = parent::order($categories, self::TABLE_NAME, $parameters);
              
        
        return $orderCategories;
    }   
}

