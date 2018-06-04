<?php
namespace App\Model;

use App\Model\BaseManager;
use Tracy\Debugger;
use Nette\Utils\Strings;

class AnswerManager extends BaseManager{
    const   TABLE_NAME = 'answers',
            COLUMN_ID = 'answers_id',
            COLUMN_TEXT = 'text',          
            COLUMN_RIGHT = 'is_right',
            COLUMN_QUESTION_ID = 'questions_id',
            COLUMN_TEST_ID = 'tests_id';
    
    public function saveAnswer($data){
        
        $this->database->query('INSERT INTO '. self::TABLE_NAME, $data);
    }
    
   
    public function saveAnswers($answers, $answerData){
        foreach($answers as $answer){
           //nastaveni zbylych dat pro tabulku answers
           $answerData[self::COLUMN_TEXT] = $answer['text']; 
                          
           if(isset($answer['is_right'])){
           $answerData[self::COLUMN_RIGHT] = true; 
           }
           else{
           $answerData[self::COLUMN_RIGHT] = false; 
           }
           //ulozeni dat do tabulky answers
           $this->saveAnswer($answerData);
        }
    }
    
    
    
    
    public function deleteAnswers($testId){
         $this->database->table(self::TABLE_NAME)
                       ->where(self::COLUMN_TEST_ID,$testId)
                       ->delete();
    }    
        
    public function getAnswers($testId){
        return $this->database->table(self::TABLE_NAME)
                    ->where(self::COLUMN_TEST_ID,$testId)
                    ->order(self::COLUMN_ID);
                    //->fetchAll();
    }
   
    
}