<?php
namespace App\Model;

use App\Model\BaseManager;
use App\Model\ConditionManager;

class ExerciseManager extends BaseManager
{
    const
            TABLE_NAME = 'exercises',
            COLUMN_ID = 'exercises_id',
            COLUMN_NAME = 'name',
            COLUMN_DESCRIPTION = 'description',
            COLUMN_TAKS = 'task',
            COLUMN_HTML = 'html_code',
            COLUMN_CSS = 'css_code',
            COLUM_JS = 'js_code',
            COLUMN_CHECK = 'check_code',
            COLUMN_SECTION = 'sections_id',
            COLUMN_PICTURE = 'pictures_id',
            COLUMN_CREATED = 'created_at',
            COLUMN_CHANGED = 'changed_at',
            COLUMN_HIDDEN = 'hidden',
            COLUMN_AUTHOR = 'users_id',          
            COLUMN_POINTS = 'points';
    
    const DELETE_PICTURE = -5; 
    
    public $types = [  0 => 'Má prvek danou třídu?',
                       1 => 'Má prvek zadaný atribut?',
                       2 => 'Má zadaná Css vlastnost danou hodnotu?',
                       3 => 'Má zadaný atribut danou hodnotu?',
                       4 => 'Je vnitřní HTML rovno zadanému?',
                       5 => 'Obsahuje prvek daný text?'];
    
    public $allowedProperties = ['background-color','border-bottom-color','border-bottom-style',
                                 'border-bottom-width','border-left-color','border-left-style',
                                 'border-left-width','border-right-color','border-right-style',
                                 'border-right-width','border-top-color','border-top-style',
                                 'border-top-width','border-bottom-left-radius','border-bottom-right-radius',
                                 'border-top-left-radius','border-top-right-radius','bottom',
                                 'color','cursor','display','float','font-family','font-size',
                                 'font-weight','height','left','line-height','list-style-type',
                                 'margin-bottom','margin-left','margin-right','margin-top',
                                 'max-height','max-width','min-height','min-width','opacity',
                                 'overflow','padding-bottom','padding-left','padding-right',
                                 'padding-top','position','right','text-align','text-decoration',
                                 'top','visibility','width','z-index'                                 
                                 ];
    private $conditionManager;
    private $resultManager;
    public function __construct(\Nette\Database\Context $database, PictureManager $picMan, ConditionManager $condMan) {
        parent::__construct($database, $picMan);
        $this->conditionManager = $condMan;
    }
    
    public function getExercises($sectionId)
    {
        return $this->database->table(self::TABLE_NAME)                
                ->select(self::COLUMN_ID . ', ' . self::COLUMN_NAME . ', '
                        . self::COLUMN_PICTURE . ', ' . self::COLUMN_DESCRIPTION)
                ->where(self::COLUMN_SECTION,$sectionId)
                ->where(self::COLUMN_HIDDEN,0)
                ->order(self::COLUMN_CREATED);
     
    }
    
    public function getExercise($exerciseId)
    {
        $exercise = $this->database->table(self::TABLE_NAME)
                    ->where(self::COLUMN_ID,$exerciseId)
                    ->fetch();
        $conditions = $this->conditionManager->getConditions($exerciseId);
        
        $fromZero = [];

        foreach($conditions as $condition){
           
            array_push($fromZero,$condition);
        }      
        return [$exercise, $fromZero];
    }
    
    public function saveExercise($data,$usersId)
    {  
       $data[self::COLUMN_AUTHOR] = $usersId;
       $data[self::COLUMN_HIDDEN] = isset($data[self::COLUMN_HIDDEN]);
       //vytazeni podminek z prijatych dat
       $conditions =  $this->conditionManager->filtreConditions($data['conditions']);       
       unset($data['conditions']);
       // naplneni sloupce check kontrolni funkci
       $data[self::COLUMN_CHECK] = $this->createCheckFunction($conditions);
       
       //pokud prijde v datech id cviceni, upravuju, jinak upravuju
        if($data['exercises_id']){
           $exerciseId = $this->addExercise($data);          
        }
        else{                    
           $exerciseId = $this->updateExercise($data);
        }
        //ulozeni podminek do DB
        $this->conditionManager->saveConditions($conditions, $exerciseId);
        
        return $exerciseId;
    }   
    
    private function addExercise($data){
        $exerciseId = $data[self::COLUMN_ID];
        $data[self::COLUMN_CHANGED] = date('Y-m-d');
        unset($data[self::COLUMN_AUTHOR]);
        
        //pokud menim obrazek
        if($data['file']){
            $oldExercise = $this->getExercise($exerciseId)[0];
            $this->pictureManager->deletePicture($oldExercise[self::COLUMN_PICTURE]);
            $pictureId = $this->pictureManager->saveExercisePicture($data['file']);            
            $data[self::COLUMN_PICTURE] = $pictureId;
        }
        unset($data['file']);
        $this->database->table(self::TABLE_NAME)
                ->where(self::COLUMN_ID,$data['exercises_id'])
                ->update($data);
        //vymazani starych podminek
        $this->conditionManager->deleteConditions($data[self::COLUMN_ID]);
        
        return $exerciseId;
    }
    
    private function updateExercise($data){
        $data[self::COLUMN_CHANGED] = date('Y-m-d');
        $data[self::COLUMN_CREATED] = date('Y-m-d');
        if($data['file']){
            $pictureId = $this->pictureManager->saveExercisePicture($data['file']);            
            $data[self::COLUMN_PICTURE] = $pictureId;
        }
        unset($data['file']);
        $row = $this->database->table(self::TABLE_NAME)->insert($data);
        
        return $row->getPrimary();
    }
       
    public function createCheckFunction($conditions){
        if(!empty($conditions)){
            define('FUNCTION_HEAD', "function check()");
            define('FUNCTION_BODY',"{var frame = document.querySelector('#frame');"
                  . "var frameDocument = frame.contentWindow.document;"
                  . "var resultArray = [];"
                  . "var result = '';");
            define('FUNCTION_BODY_END',"for(var i=0; i<resultArray.length; i++)"
                    ."{result = result + resultArray[i] + '\\n';}".
                    "if(result == ''){result = 'Správně.'}"
                    . "return result;}");

            $completeCode = '';
            $code = '';
            $cond = "frameDocument.querySelectorAll('mySelector').forEach(function(obj){"
                    . "if(window.getComputedStyle(obj,null).getPropertyValue('myProperty')"
                    . " myRelation myValue)"
                    . " {resultArray.push(true);}"
                    . "else"
                    . "{resultArray.push(false);}"
                    . "}); ";


            foreach ($conditions as $condition){
              $selector = str_replace('"','',$condition['selector']);             
              $value = trim(preg_replace('/\s\s+/', '', $condition['value']));
              $value =  str_replace('"',"'", $value);
              $message = str_replace('"', "'", $condition['message']);
              
              
                if(isset($condition['property'])){
                    $containsColor = strpos($condition['property'],'color');                    
                    if($condition['type'] == 2 && ($containsColor || $containsColor === 0)){
                      $value  = $this->convertColor($condition['value']); 
                      
                    }                    
                }                   
                    
                    
                if(isset($condition['property'])){ 
                  $property = str_replace('"','',$condition['property']);
                  $argumentString = '('.'"'. $selector.'"' . ',' .'"'. $property
                          .'"'. ',' .'"'. $value .'"'.','.'"'.$message.'"'.','.'frameDocument' .')';                   
                }
                else{
                  
                  $argumentString ='('.'"'. $selector.'"' . ',' .'"'. $value.'"'.','.'"'.$message.'"'
                          .','.'frameDocument'.')';
                }

                $code .= 'resultArray = resultArray.concat(functionArray['.$condition['type'].']'.$argumentString .')'. ';';


            }

            return FUNCTION_HEAD . FUNCTION_BODY . $code . FUNCTION_BODY_END;        
        }else{
            return '';
        }
    }
    
    private function convertColor($colorValue){
        if(strpos($colorValue,'#') === 0){
           return $this->convertColorHex($colorValue);         
        }elseif(strpos($colorValue,'rgb')=== 0){
           return $this->convertColorRgb($colorValue);
        }
    }
    
    private function convertColorHex($colorValue){        
        if(strlen($colorValue) == 4){
         $r = hexdec(substr($colorValue,1,1).substr($colorValue,1,1));
         $g = hexdec(substr($colorValue,2,1).substr($colorValue,2,1));
         $b = hexdec(substr($colorValue,3,1).substr($colorValue,3,1));
         $color="rgb($r, $g, $b)";  
        }
        else{
         $r = hexdec(substr($colorValue,1,2));
         $g = hexdec(substr($colorValue,3,2));
         $b = hexdec(substr($colorValue,5,2));
         $color="rgb($r, $g, $b)";
     
        }
       
        return $color;
    }
    
    private function convertColorRgb($colorValue){
        $trim = str_replace(' ', '',$colorValue);
        $color = str_replace(',',', ',$trim);               
        return $color;
        
    }
    
    public function getFiltreItems($parameters,$userId = false){
        $exercises = $this->database->table(self::TABLE_NAME);
        
        if($userId){
                $exercises->where(self::COLUMN_AUTHOR,$userId);
            }
        
        if(empty($parameters)){
            return $exercises;
        }
        
        if(isset($parameters['categorySelect']) && $parameters['categorySelect'] != 0){                
                
                $exercises->where('sections.category_id = '. $parameters['categorySelect']);
        }
            
        if(isset($parameters['sectionSelect']) && $parameters['sectionSelect'] != 0){                

            $exercises->where(self::COLUMN_SECTION . ' = '. $parameters['sectionSelect']);
        } 
        
        if(!empty($parameters['namesearch'])){
            
            $exercises->where(self::COLUMN_NAME . ' LIKE', '%'.$parameters['namesearch'].'%');
        }
        
        if(!empty($parameters['authorsearch'])){
            
            $exercises->where('users.username' . ' LIKE', '%'.$parameters['authorsearch'].'%');
        }
        
        if(isset($parameters['hiddenselect']) && $parameters['hiddenselect'] != 3){
            
            $exercises->where(self::COLUMN_HIDDEN, $parameters['hiddenselect']);
        }
        
        $orderExercises = parent::order($exercises, self::TABLE_NAME, $parameters);
        
        return $orderExercises;
    }
    
    public function deleteExercise($exerciseId){
        $row = $this->database->table(self::TABLE_NAME)
                ->where(self::COLUMN_ID,$exerciseId);
        $exercise = $row->fetch();
        $pictureId = $exercise[self::COLUMN_PICTURE];
        $row->delete();
        $this->pictureManager->deletePicture($pictureId);          
    }
    
    public function deletePicture($exerciseId){
        $this->database->table(self::TABLE_NAME)
                ->where(self::COLUMN_ID,$exerciseId)
                ->update([self::COLUMN_PICTURE => self::DELETE_PICTURE]);
    }
    
    public function getExercisesSections(){
        return  $this->database->table(self::TABLE_NAME)
                ->select('DISTINCT exercises.'.self::COLUMN_SECTION.' AS idecko' . ', sections.name AS name')
                ->order('idecko')
                ->fetchPairs('idecko','name');
    }    
    
    public function getDeletePicture(){
        return self::DELETE_PICTURE;
    }   
   
}

