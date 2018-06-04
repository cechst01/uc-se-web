<?php

namespace App\Model;

use App\Model\BaseManager;
use App\Model\QuestionManager;
use App\Model\AnswerManager;
use App\Model\ResultManager;

class TestManager extends BaseManager
{
    const 
            TABLE_TEST = 'tests',
            COLUMN_ID = 'tests_id',
            COLUMN_NAME = 'name',
            COLUMN_DESCRIPTION = 'description',
            COLUMN_QUESTION_COUNT = 'question_count',
            COLUMN_PICTURE_ID = 'pictures_id',
            COLUMN_RIGHT_ANSWERS = 'right_answers',
            COLUMN_USER_ID = 'users_id',
            COLUMN_SECTION = 'sections_id',
            COLUMN_POINTS = 'points',
            COLUMN_CREATED = 'created_at',
            COLUMN_CHANGED = 'changed_at',
            COLUMN_HIDDEN = 'hidden';                    

    const DELETE_PICTURE = 0;
    
    private $questionManager;
    private $answerManager;
    private $resultManager;    
    
    public function __construct(\Nette\Database\Context $database, PictureManager $picMan, QuestionManager $question,
                                AnswerManager $answer, ResultManager $result) {
        parent::__construct($database, $picMan);
        $this->questionManager = $question;
        $this->answerManager = $answer;
        $this->resultManager = $result;
        
    }
    
  
    // upravit
    public function saveTest($test,$usersId){       
               
          $questions = $test['questions'];
          $count = count($questions);
          $hidden = isset($test[self::COLUMN_HIDDEN]) ? 1 : 0;
          //nastaveni dat do tabulky tests
          $testData = [self::COLUMN_NAME => $test['name'],
                       self::COLUMN_DESCRIPTION => $test[self::COLUMN_DESCRIPTION],
                       self::COLUMN_QUESTION_COUNT => $count,                       
                       self::COLUMN_USER_ID => $usersId,
                       self::COLUMN_HIDDEN => $hidden,
                       self::COLUMN_POINTS => $test[self::COLUMN_POINTS]];
          if($test[self::COLUMN_SECTION]){
              $testData[self::COLUMN_SECTION] = $test[self::COLUMN_SECTION];
          }
          
          //zahajeni transakce pro ukladani dat do tabulek
          $this->database->beginTransaction();
           try{
               // pokud je vyplneno ID test se edituje jinak vklada novy
               if($test[self::COLUMN_ID]){    
                   
                   $testData[self::COLUMN_CHANGED] = date('Y-m-d');
                   unset($testData[self::COLUMN_USER_ID]);
                   
                   if($test['file']){
                    $oldTest =  $this->getTest($test[self::COLUMN_ID]);
                    $this->pictureManager->deletePicture($oldTest[self::COLUMN_PICTURE_ID]);
                    $pictureId = $this->pictureManager->saveTestPicture($test['file']);
                    $testData[self::COLUMN_PICTURE_ID] = $pictureId;
                   }
                   
                    $testId = $test['tests_id'];             
                    $this->updateTest($testId, $testData);                  
                    $this->answerManager->deleteAnswers($testId);  
                    
               }
               else{
                  $testData[self::COLUMN_CREATED] = date('Y-m-d');
                  $testData[self::COLUMN_CHANGED] = date('Y-m-d');
                  if($test['file']){
                    $pictureId = $this->pictureManager->saveTestPicture($test['file']);
                    $testData[self::COLUMN_PICTURE_ID] = $pictureId; 
                   }
                
                 //pokud predelam savetest na table->insert muze vracet ID
                 //odpadne zjistovani poslendiho ID
                 $this->saveTestPart($testData);
                 //zjisteni id posledniho 
                 $testId = $this->database->getInsertId(self::TABLE_TEST);                   
               }
                 
                  //castecne nastaveni dat pro tabulku questions
                 $questionData = [self::COLUMN_ID => $testId];
                 
                 $this->questionManager->saveQuestions($questions, $questionData);
                
                 //pokud vse porbehlo v poradku potvrzeni ulozeni dat
                $this->database->Commit();
                
                $rightAnswers = $this->rightAnswers($testId);
                $rightAnswersText = serialize($rightAnswers);
                
                $this->updateTest($testId,[self::COLUMN_RIGHT_ANSWERS=>$rightAnswersText]);
                
                return $testId;
           }
           catch(PDOException $e)
           {
               // pri jakekoliv chybe zruseni ulozeni
               $this->database->rollBack();
           }       
        }
   
    private function saveTestPart($data){
        
      $row = $this->database->query('INSERT INTO '. self::TABLE_TEST,$data);
      //return $row->getPrimary();                
        
    }
   
    private function updateTest($testId,$testData){
        $this->database->query('UPDATE ' . self::TABLE_TEST .
                               ' SET ? WHERE '. self::COLUMN_ID .'=?',
                               $testData,$testId);
    }
    
    public function deleteTest($testId){
         $row = $this->database->table(self::TABLE_TEST)
                       ->where(self::COLUMN_ID,$testId);
         $test = $row->fetch();
         $pictureId = $test[self::COLUMN_PICTURE_ID];
         $row->delete();                      
         $this->pictureManager->deletePicture($pictureId);
         $this->questionManager->deleteQuestions($testId);
         $this->answerManager->deleteAnswers($testId);
    }
       
    
    public function getTests($sectionId){
        
       return $this->database->table(self::TABLE_TEST)
               ->where(self::COLUMN_SECTION,$sectionId)
               ->where(self::COLUMN_HIDDEN,0)
               ->order(self::COLUMN_CREATED);
    }    
   
    public function getTest($testId){
       
        $test = $this->database->table(self::TABLE_TEST)
                        ->where(self::COLUMN_ID,$testId)
                        ->fetch();
        if(!$test){
            return false;
        }
       
        $totalTest = $test->toArray();
        $totalQuestions = [];   
        
        $questions = $this->questionManager->getQuestions($testId);
        $allAnswers = $this->answerManager->getAnswers($testId)->fetchAll();
      
        foreach($questions as $question){
            
            $questionId = $question['questions_id'];
          
            $answers = [];
            
            foreach($allAnswers as $allAnswer)
            {
                if($allAnswer['questions_id'] == $questionId){
                    $answers[] = $allAnswer;
                }
            }
           
            $oneQuestion = $question->toArray();
            $pictureId = $oneQuestion[self::COLUMN_PICTURE_ID];
            if($pictureId){
               $picture = $this->pictureManager->getPicture($pictureId)->toArray();   
            }
            else{
                $picture = false;
            }
            
            
            $oneQuestion['picture'] = $picture;
            
            $totalAnswers = [];
            
           
           
            foreach($answers as $answer){
                
              $totalAnswers[] = $answer->toArray();
            
            }
            
            $oneQuestion['answers'] =  $totalAnswers;
            $totalQuestions[] = $oneQuestion;
           
        }
        
        
           $totalTest['questions'] = $totalQuestions;
         
         
      return $totalTest;
    }   
  
    public function evaluateTest($data){
        
        $id = $data[self::COLUMN_ID];
        $test = $this->getTest($id);       
        $totalCount = $test[self::COLUMN_QUESTION_COUNT];
        $rightAnswers = $test[self::COLUMN_RIGHT_ANSWERS] ? unserialize($test[self::COLUMN_RIGHT_ANSWERS]) : $this->rightAnswers($id);
        
        $markedCount = count($data)-4;
        $markedAnswers = $rightAnswers;        
        $keys = array_keys($data);       
        $length = count($markedAnswers);
       
        // pripraveni pole stejne velikosti jako spravne odpovedi naplnene 0
        for($i = 0; $i < $length; $i++){
            
            $length2 = count($markedAnswers[$i]);
            
            for($j=0; $j<$length2;$j++){
                $markedAnswers[$i][$j] = 0;
            }
        }
        
   
        // naplneni pole jednickami kde je 
        for($i =0; $i< $markedCount; $i++){
            
            $name = $keys[$i];
            $nameLength = strlen($name);            
            $dashIndex = strpos($name,'-');
            $questionIndex = substr($name,0,$dashIndex);
            $answerIndex = substr($name,-1,$nameLength-$dashIndex);
            
            $markedAnswers[$questionIndex][$answerIndex-1] = 1;         
        }
             
      $right = 0;
      
      
    
      for($i = 0; $i < $length; $i++){
          
          $error = false;
          $length2 = count($markedAnswers[$i]);
          
          for($j = 0; $j<$length2; $j++){
             if($markedAnswers[$i][$j] !== $rightAnswers[$i][$j]){
                 $error = true;
                 break;
             }
          }
          
           if(!$error){
                 $right++;
             }
          
      } 
             
      $wrongCount = $totalCount - $right;
      $markedAnswersText = serialize($markedAnswers);
      $points = $test[self::COLUMN_POINTS];
      
      if($data[self::COLUMN_USER_ID]!= -1){         
         $this->resultManager->saveResult($id,$data[self::COLUMN_USER_ID],$markedAnswersText,$points,$right,$wrongCount);      
      }
      $percent = $right / ($right + $wrongCount);
      $points = floor($points * $percent);
      $resultArray = ['markedAnswers'=>$markedAnswers,
                      'rightAnswers'=> $rightAnswers,
                      'points'=>$points,
                      'rightCount' => $right,
                      'wrongCount' => $wrongCount];
      
      return $resultArray;
      
    }  
      
    public function rightAnswers($testId){
        
        $rigthAswers = [];        
        $questions = $this->questionManager->getQuestions($testId); 
        $allAnswers = $this->answerManager->getAnswers($testId)->fetchAll();
        $i = 0;
        foreach($questions as $question){
            
            $j=0;
            $questionId = $question['questions_id'];
            
            $answers = [];
            
            foreach($allAnswers as $allAnswer){
                if($allAnswer['questions_id'] == $questionId){
                    $answers[] = $allAnswer;
                }
            }         
            
            foreach($answers as $answer){
                
               $rigthAswers[$i][$j] = $answer['is_right'];
               $j++;
            }
            
            $i++;
            
        }
        
        return $rigthAswers;
        
    }    
    public function getResult($testId,$userId){
       
        $rightAnswers = $this->rightAnswers($testId);
        return $this->resultManager->getResult($testId,$userId,$rightAnswers);
        
    }
      
    public function deletePicture($testId){
        
        $this->database->table(self::TABLE_TEST)
                        ->where(self::COLUMN_ID,$testId)
                        ->update([self::COLUMN_PICTURE_ID => self::DELETE_PICTURE]);
    }
    
    
    public function getFiltreItems($parameters,$userId=false){
        
        $tests = $this->database->table(self::TABLE_TEST);
        
        if($userId){
                $tests->where(self::COLUMN_USER_ID,$userId);
            }
        
        if(empty($parameters)){
            return $tests;
        }
        if(isset($parameters['categorySelect']) && $parameters['categorySelect'] != 0){                
                
                $tests->where('sections.category_id = '. $parameters['categorySelect']);
        }
            
        if(isset($parameters['sectionSelect']) && $parameters['sectionSelect'] != 0){                

            $tests->where(self::COLUMN_SECTION . ' = '. $parameters['sectionSelect']);
        } 
        
        if(!empty($parameters['namesearch'])){
            $tests->where(self::COLUMN_NAME . ' LIKE', '%' .$parameters['namesearch'].'%' );
        }
        
        if(!empty($parameters['authorsearch'])){
            $tests->where('users.username' . ' LIKE', '%' .$parameters['authorsearch'].'%' );
        }
        
        if(!empty($parameters['descriptsearch'])){
            $tests->where(self::COLUMN_DESCRIPTION . ' LIKE', '%' .$parameters['descriptsearch'].'%' );
        }
        
        if(isset($parameters['hiddenselect']) && $parameters['hiddenselect'] != 3){
            $tests->where(self::COLUMN_HIDDEN,$parameters['hiddenselect']);
        }
        
        $orderTests = $this->order($tests, self::TABLE_TEST, $parameters);
        
        return $orderTests;        
    }
    
    public function getTestsSections(){
        return  $this->database->table(self::TABLE_TEST)
                ->select('DISTINCT tests.'.self::COLUMN_SECTION.' AS idecko' . ', sections.name AS name')
                ->order('idecko')
                ->fetchPairs('idecko','name');
    }
     
    public function getDeletePicture(){
        return self::DELETE_PICTURE;
    }
    
    public function nextDate($result){
        return $this->resultManager->nextDate($result);
    }
    
    
}
