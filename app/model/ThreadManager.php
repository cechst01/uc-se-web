<?php
namespace App\Model;

use App\Model\BaseManager;

class ThreadManager extends BaseManager{
    const   TABLE_NAME = 'threads',
            COLUMN_ID = 'threads_id',
            COLUMN_NAME = 'name',
            COLUMN_USER_ID = 'users_id',
            COLUMN_FORUM_CATEGORY_ID = 'f_category_id',            
            COLUMN_LOCKED = 'locked';
    
    
    public function saveThread($data){
        if($data[self::COLUMN_ID])
        {
            $this->editThread($data);
            $id = $data[self::COLUMN_ID];
        }
       else{
            $row = $this->database->table(self::TABLE_NAME)
                     ->insert($data);
            $id = $row->getPrimary();
        }
        return $id;
    }
    
    public function getThreads($categoryId){
        
        return $this->database->table(self::TABLE_NAME)
                ->where(self::COLUMN_FORUM_CATEGORY_ID,$categoryId)
                ->order(self::COLUMN_ID);
                //->fetchAll();
    }
    
    public function deleteThread($threadId){
        
        $this->database->table(self::TABLE_NAME)
                ->where(self::COLUMN_ID,$threadId)
                ->delete();
    }
    
    public function toogleLock($threadId){
        
        $thread = $this->getThread($threadId);
        
        if($thread[self::COLUMN_LOCKED] == 0){
            $this->database->table(self::TABLE_NAME)
                    ->where(self::COLUMN_ID,$threadId)
                    ->update([self::COLUMN_LOCKED => 1]);          
        }
        else{
            
            $this->database->table(self::TABLE_NAME)
                    ->where(self::COLUMN_ID,$threadId)
                    ->update([self::COLUMN_LOCKED => 0]);        
        }
    }
    
    public function getThread($threadId){
        return $this->database->table(self::TABLE_NAME)
                ->where(self::COLUMN_ID,$threadId)
                ->fetch();
    }
    
    public function editThread($data){
        $id = $data[self::COLUMN_ID];
        
        $this->database->table(self::TABLE_NAME)
                ->where(self::COLUMN_ID,$id)
                ->update([self::COLUMN_NAME =>$data[self::COLUMN_NAME]]);
    }
    
    public function getFiltreItems($parameters,$categoryId){
        
        $threads = $this->database->table(self::TABLE_NAME)
                        ->where(self::COLUMN_FORUM_CATEGORY_ID,$categoryId);
        
            if(empty($parameters)){
                return $threads;
            }
                        
            if(!empty($parameters['namesearch'])){
                
               $threads->where(self::COLUMN_NAME . ' LIKE','%'.$parameters['namesearch'].'%');
            }
            
            if(!empty($parameters['authorsearch'])){
                
               $threads->where('users.username' . ' LIKE','%'.$parameters['descriptsearch'].'%');
            }
            
            if(isset($parameters['lockedSelect']) && $parameters['lockedSelect'] != 3){                
                
                $threads->where(self::COLUMN_LOCKED . ' = ' . $parameters['lockedSelect']);
            }
            
            if(isset($parameters['ordercolumn']) && $parameters['ordercolumn'] == 'posts_count'){
         
                $threads->order('(SELECT COUNT(*) FROM posts WHERE threads_id = threads.threads_id ) '. $parameters['ordertype']);
             
            }
            
            if(isset($parameters['ordercolumn']) && $parameters['ordercolumn'] == 'last_post'){
         
                $threads->order('(SELECT MAX(created_at) FROM posts WHERE threads_id = threads.threads_id ) '. $parameters['ordertype']);
             
            }
            
           $orderThreads = $this->order($threads, self::TABLE_NAME, $parameters);
              
        
        return $orderThreads;
    }
   
}
