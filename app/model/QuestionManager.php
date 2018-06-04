<?php
namespace App\Model;

use App\Model\BaseManager;
use App\Model\AnswerManager;

class QuestionManager extends BaseManager{
      const TABLE_NAME = 'questions',
            COLUMN_ID = 'questions_id',
            COLUMN_QUESTION = 'question',
            COLUMN_ORDER = 'order_key',           
            COLUMN_TEST_ID = 'tests_id',
            COLUMN_PICTURE_ID = 'pictures_id';
      
      private $answerManager;
      
      public function __construct(\Nette\Database\Context $database, PictureManager $picMan, AnswerManager $answer) {
          parent::__construct($database, $picMan);
          $this->answerManager = $answer;
      }
      
    public function saveQuestion($data){        
      $this->database->query('INSERT INTO ' . self::TABLE_NAME, $data);
    }    

    public function getQuestion($id){
        return $this->database->table(self::TABLE_NAME)
                ->where(self::COLUMN_ID,$id)
                ->fetch();
    }
    
    public function saveQuestions($questions,$questionData){
        $i = 1; 
        $this->deleteQuestions($questionData[self::COLUMN_TEST_ID],$questions);
        
        foreach($questions as $question){             
            $questionData[self::COLUMN_QUESTION] = $question['question'];
            $questionData[self::COLUMN_ORDER] = $i;            
            
            /// uprava otazky
            if(isset($question[self::COLUMN_ID])){
                
               $questionData[self::COLUMN_ID] = $question[self::COLUMN_ID];               
                if($question['image']){                   
                    $oldQuestion = $this->getQuestion($question[self::COLUMN_ID]);                
                    $this->pictureManager->deletePicture($oldQuestion[self::COLUMN_PICTURE_ID]);
                    $pictureId = $this->pictureManager->saveQuestionPicture($question['image']);
                    $questionData[self::COLUMN_PICTURE_ID] =  $pictureId;                                 
                }
                else{
                    if(!empty($question['oldimage'])){
                       $questionData[self::COLUMN_PICTURE_ID] =  $question['oldimage']; 
                    }
                    else{
                      unset($questionData[self::COLUMN_PICTURE_ID]);  
                    }                    
                }
               
                $id = $question[self::COLUMN_ID];               
                $this->saveQuestion($questionData); 
                
            }
            ///ulozeni nove otazky
           else{
               
                if($question['image']){
                    
                     $pictureId = $this->pictureManager->saveQuestionPicture($question['image']);
                     $questionData[self::COLUMN_PICTURE_ID] =  $pictureId;
                }
                else{
                    unset($questionData[self::COLUMN_PICTURE_ID]);
                }
               unset($questionData[self::COLUMN_ID]);
               $this->saveQuestion($questionData); 
               $id = $this->database->getInsertId(self::TABLE_NAME);
               }
            
             $i++;  
            
             //nastaveni zbylych dat pro tabulku questions
             
           
             //castecne nastaveni dat pro tabulku answers
             $answerData = [self::COLUMN_ID => $id,
                            self::COLUMN_TEST_ID => $questionData[self::COLUMN_TEST_ID]];
                      
             $answers = $question['answers'];
             
             $this->answerManager->saveAnswers($answers, $answerData);
        }
    }
    
    public function deleteQuestions($testId,$questions=[]){
        $row = $this->database->table(self::TABLE_NAME)
                    ->where(self::COLUMN_TEST_ID,$testId);
        
        $oldQuestions = $row->fetchAll();        
        
        $stayPictures = [];
        $questionPictures = [];   
        
        foreach($questions as $question){
            if(!empty($question['oldimage'])){
                $stayPictures[] = $question['oldimage'];
            }                       
        }
        foreach($oldQuestions as $oldQuestion){
            if($oldQuestion[self::COLUMN_PICTURE_ID]){
              
              $questionPictures[] = $oldQuestion[self::COLUMN_PICTURE_ID];
              
            } 
        }
        
        $deletePicture = array_diff($questionPictures,$stayPictures);        
        
        $row->delete();
        $this->pictureManager->deletePicture($deletePicture);
                
    }
    
    public function getQuestions($testId){
        
       return $this->database->table(self::TABLE_NAME)
                       ->where(self::COLUMN_TEST_ID,$testId)
                       ->order(self::COLUMN_ORDER)
                       ->fetchAll();
    }
}