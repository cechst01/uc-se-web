<?php
namespace App\Model;

use App\Model\BaseManager;
use HTMLPurifier_Config;
use HTMLPurifier;

class PostManager extends BaseManager{
    
    const   TABLE_NAME = 'posts',
            COLUMN_ID = 'post_id',
            COLUMN_CONTENT = 'content',
            COLUMN_USER_ID = 'users_id',
            COLUMN_THREAD_ID = 'threads_id',
            COLUMN_CREATED_AT = 'created_at',
            COLUMN_CHANGED_AT = 'changed_at';
    
    public function savePost($data){
        
        $dirty_html = $data[self::COLUMN_CONTENT];
        $config = HTMLPurifier_Config::createDefault();
        $config->set('HTML.Allowed', 'p,span[class],strong,pre[class],code,em,a[href|title|target],code[class],ul,ol,li,img[src]');
        $config->set('AutoFormat.RemoveEmpty', true);
        $purifier = new HTMLPurifier($config);
        $clean_html = $purifier->purify($dirty_html);
        $data[self::COLUMN_CONTENT] = $clean_html;
        
        if(isset($data[self::COLUMN_ID]) && $data[self::COLUMN_ID] !=""){
            
           $this->editPost($data);
           $id = $data[self::COLUMN_ID];
        }
        else{
           unset($data[self::COLUMN_ID]); 
          $row= $this->database->table(self::TABLE_NAME)
                               ->insert($data); 
          $id= $row->getPrimary();
        }
       return $id; 
    }
    
    public function getPosts($threadId){
        
        return $this->database->table(self::TABLE_NAME)
                ->where(self::COLUMN_THREAD_ID,$threadId)
                ->order(self::COLUMN_CREATED_AT)
                ->fetchAll();
    }
    
    public function deletePost($postId){
        
        $this->database->table(self::TABLE_NAME)
                ->where(self::COLUMN_ID,$postId)
                ->delete();
    }
    
    public function getPost($postId){
        
        return $this->database->table(self::TABLE_NAME)
                ->where(self::COLUMN_ID,$postId)
                ->fetch();
    }
    
    protected function editPost($data){
        $id = $data[self::COLUMN_ID];
        
        $this->database->table(self::TABLE_NAME)
                ->where(self::COLUMN_ID,$id)
                ->update([self::COLUMN_CONTENT =>$data[self::COLUMN_CONTENT],
                          self::COLUMN_CHANGED_AT => $data[self::COLUMN_CHANGED_AT]]);
    }
    
    public function getFiltreItems($parameters,$threadId){
        $posts = $this->database->table(self::TABLE_NAME)
                        ->where(self::COLUMN_THREAD_ID,$threadId);
        
            if(empty($parameters)){
                return $posts;
            }           
                        
            if(!empty($parameters['contentsearch'])){
                
               $posts->where(self::COLUMN_CONTENT . ' LIKE','%'.$parameters['contentsearch'].'%');
            }
            
            if(!empty($parameters['authorsearch'])){
                
               $posts->where('users.username' . ' LIKE','%'.$parameters['authorsearch'].'%');
            }
            
           $orderPosts = parent::order($posts, self::TABLE_NAME, $parameters);
              
        
        return $orderPosts;
    }
}

