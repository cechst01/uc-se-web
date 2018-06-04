<?php

namespace App\Model;

use App\Model\BaseManager;
use Nette\Utils\DateTime;
use App\Model\UserManager;
use Nette\Database\Context;

class ResultManager extends BaseManager{
    const   TABLE_NAME = 'test_results',
            COLUMN_TEST_ID = 'tests_id',
            COLUMN_USER_ID = 'users_id',
            COLUMN_MARKED_ANSWER = 'marked_answers',
            COLUMN_RIGHT_COUNT = 'right_count',
            COLUMN_WRONG_COUNT = 'wrong_count',
            COLUMN_POINTS = 'points',
            COLUMN_DATE ='date';
    
    private $testRewrite;
    private $userManager;
    public function __construct($testRewrite,Context $database, PictureManager $picMan, UserManager $usrMan) {
        parent::__construct($database, $picMan);
        $this->testRewrite = $testRewrite;
        $this->userManager = $usrMan;
    }
    
    public function saveResult($testId,$userId,$markedAnswers,$points,$right,$wrong){
        
        $data = array(self::COLUMN_TEST_ID => $testId,
                      self::COLUMN_USER_ID => $userId,
                      self::COLUMN_MARKED_ANSWER => $markedAnswers,                  
                      self::COLUMN_RIGHT_COUNT => $right,
                      self::COLUMN_WRONG_COUNT =>$wrong,
                      self::COLUMN_DATE => date('Y-m-d'));

        $percent = $right / ($right + $wrong);
        $percentPoints = floor($percent * $points);        
               
        $data[self::COLUMN_POINTS] = $percentPoints;
     
        $result = $this->getResult($testId, $userId,false);
        if($result){ 
            if($percentPoints > $result[self::COLUMN_POINTS]){               
               $this->updateUserPoints($testId, $userId, $percentPoints);
               $this->update($data);
            }            
        }
        else{          
          $this->updateUserPoints($testId, $userId, $percentPoints);
          $this->save($data);
        }
       
    }
    
    private function save($data){
        $this->database->table(self::TABLE_NAME)
                       ->insert($data);
    }
    
    private function update($data){
        $this->database->table(self::TABLE_NAME)
                       ->where(self::COLUMN_TEST_ID,$data[self::COLUMN_TEST_ID])
                       ->where(self::COLUMN_USER_ID,$data[self::COLUMN_USER_ID])
                       ->update($data);
    }
    
    private function updateUserPoints($testId,$userId,$percentPoints){
        $oldResult = $this->getResult($testId, $userId, false);
        
        if($oldResult){
            $oldPoints = $oldResult[self::COLUMN_POINTS];
            if($oldPoints != $percentPoints){
                $newPoints = $percentPoints - $oldPoints;
                $points = $newPoints > 0 ? $newPoints : 0;
                $this->userManager->changePoints($userId, $points);
            }
        }
        else{
            \Tracy\Debugger::barDump($percentPoints);
            $this->userManager->changePoints($userId, $percentPoints);
        }    
    }
    
    public function getResult($testId,$userId,$rightAnswers){
        
        $result = $this->database->table(self::TABLE_NAME)
                              ->where(self::COLUMN_TEST_ID,$testId)
                              ->where(self::COLUMN_USER_ID,$userId)
                              ->fetch();
        
       if($result){            
         $resultArray = ['markedAnswers'=> unserialize($result[self::COLUMN_MARKED_ANSWER]),
                        'rightAnswers' => $rightAnswers,
                        'points' => $result[self::COLUMN_POINTS],
                        'rightCount' => $result[self::COLUMN_RIGHT_COUNT],
                        'wrongCount' =>$result[self::COLUMN_WRONG_COUNT ],
                         self::COLUMN_DATE => $result[self::COLUMN_DATE]
                     ];
      
        return $resultArray;
            
        }
        else
        {
            return false;
        }        
    }
    
    public function nextDate($result){
        $date = $result[self::COLUMN_DATE];           
        $next = $date->modifyClone('+ '.$this->testRewrite . ' days');
        $today = DateTime::from(date('Y-m-d'));
        $nextDate = date_format($next,'d. m. Y');
        
        return $today < $next ? $nextDate : false;
        
    }
    
    public function getResults($userId){
       return $this->database->table(self::TABLE_NAME)
                     ->where(self::COLUMN_USER_ID,$userId)
                     ->fetchAll();
    }
    
}