<?php

namespace App\Model;

use App\Model\BaseManager;
use HTMLPurifier_Config;
use HTMLPurifier;


class CommentManager extends BaseManager{
    
    const TABLE_NAME = 'comments',
          COLUMN_ID = 'comments_id',
          COLUMN_USER = 'users_id',
          COLUMN_TUTORIAL = 'tutorial_id',
          COLUMN_CONTENT = 'content',
          COLUMN_CREATED = 'created_at',
          COLUMUN_CHANGED = 'changed_at';
    
    public function saveComment($data,$user_id){
        $dirty_html = $data[self::COLUMN_CONTENT];
        $config = HTMLPurifier_Config::createDefault();
        $config->set('HTML.Allowed', 'p,span[class],strong,pre[class],code,em,a[href|title|target],code[class],ul,ol,li,img[src]');
        $config->set('AutoFormat.RemoveEmpty', true);
        $config->set('URI.DisableExternalResources',true);
        $purifier = new HTMLPurifier($config);
        $clean_html = $purifier->purify($dirty_html);
        $data[self::COLUMN_CONTENT] = $clean_html;
        $data[self::COLUMN_USER] = $user_id;
        $data[self::COLUMN_CREATED] = date('Y-m-d-G-i-s');
        $data[self::COLUMUN_CHANGED] = date('Y-m-d-G-i-s');
        
        if($data['comments_id']){
            unset($data[self::COLUMN_TUTORIAL]);
            $this->database->table(self::TABLE_NAME)
                    ->where(self::COLUMN_ID,$data[self::COLUMN_ID])
                    ->update($data);
        }
        else{
        $this->database->table(self::TABLE_NAME)
                       ->insert($data);
        }
    }
    
    public function getComments($tutorialId){
       $comments = $this->database->table(self::TABLE_NAME)
                       ->where(self::COLUMN_TUTORIAL,$tutorialId)
                       ->order(self::COLUMN_CREATED)
                       ->fetchAll();
            
       return $comments;
    }
    
    public function deleteComment($commentId){
        $this->database->table(self::TABLE_NAME)
                ->where(self::COLUMN_ID,$commentId)
                ->delete();
    }
    
    public function deleteComments($deletedIds){
        $this->database->table(self::TABLE_NAME)
                ->where(self::COLUMN_ID . ' IN ',$deletedIds)
                ->delete();
    }
    
    public function getComment($commentId){
        return $this->database->table(self::TABLE_NAME)
                ->where(self::COLUMN_ID,$commentId)
                ->fetch();
    }
        
    public function getFiltreItems($parameters,$tutorialId){
      $comments = $this->database->table(self::TABLE_NAME)->where(self::COLUMN_TUTORIAL,$tutorialId);
      
      if(empty($parameters)){
          return $comments;
      }
       if(!empty($parameters['authorsearch'])){
                
            $comments->where('users.username' . ' LIKE','%'.$parameters['authorsearch'].'%');
       }
       if(!empty($parameters['contentsearch'])){
                
            $comments->where('content' . ' LIKE','%'.$parameters['contentsearch'].'%');
       }
       
       $orderComments = parent::order($comments, self::TABLE_NAME, $parameters);
       
       return $orderComments;
    }
    
          
}