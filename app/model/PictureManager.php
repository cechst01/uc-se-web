<?php
namespace App\Model;

use Nette\Database\Context;
use Nette\Utils\Image;
use Nette\Utils\Finder;

class PictureManager{
    
    protected $database;
    public $maxFileSize;
    public $imageSize;
    public $questionImageSize;
    public $questionMaxFileSize;
    
    public function __construct($maxFile, $imgSize,$questionImgSize,$questionMax, Context $database) {
        $this->database = $database;
        $this->maxFileSize = $maxFile;
        $this->imageSize = $imgSize; 
        $this->questionImageSize = $questionImgSize;   
        $this->questionMaxFileSize = $questionMax;
    }
    
    const TABLE_NAME = 'pictures',
          COLUMN_ID = 'pictures_id',
          COLUMN_URL = 'url',
          COLUMN_WIDTH = 'width',
          COLUMN_HEIGHT = 'height';
    
    const PATH = 'images/',
          PROFILE_PATH = self::PATH . 'profile',
          TUTORIAL_PATH = self::PATH . 'tutorial',
          EXERCISE_PATH = self::PATH . 'exercise',
          TEST_PATH = self::PATH . 'test',
          QUESTION_PATH = self::PATH . 'question',
          PROFILE_ALT = 'Profilový obrázek.',
          TUTORIAL_ALT = 'Obrázek k tutorialu.',
          EXERCISE_ALT = 'Obrázek ke cvičení.',
          TEST_ALT = 'Obrázek k testu.',
          QUESTION_ALT = 'Obrázek k otázce.';
          
    
         
    
    public function getPicture($pictureId){      
      return $this->database->table(self::TABLE_NAME)
                       ->where(self::COLUMN_ID,$pictureId)
                       ->fetch();
      
    }    
     
    
    public function deletePicture($picturesId){        
        if(!is_array($picturesId)){
            $picturesId = [$picturesId];
        }
        foreach($picturesId as $pictureId){
            $picture = $this->getPicture($pictureId);
            $url = $picture[self::COLUMN_URL];
            $noDefault = $picture[self::COLUMN_ID] > 0;
           
            if($url && $noDefault){               
               $this->database->table(self::TABLE_NAME)
                    ->where(self::COLUMN_ID,$pictureId)
                    ->delete();
               unlink($url);
            } 
        }         
    }
    
    private function checkImg($file){
        if($file){
          if($file->isImage() && $file->isOk()) {
              return true;
          }  
        }
        return false;
    }
    
    private function getName($file){
        // oddělení přípony pro účel změnit název souboru na co chceš se zachováním přípony
        $fileExt=strtolower(mb_substr($file->getSanitizedName(), strrpos($file->getSanitizedName(), ".")));
        // vygenerování náhodného řetězce znaků, můžeš použít i \Nette\Strings::random()
        $fileName = uniqid(rand(0,20), TRUE).$fileExt;
        // přesunutí souboru z temp složky někam, kam nahráváš soubory
        return $fileName;
    }
    
    public function saveProfilePicture($file){ 
        if($this->checkImg($file)){
           $this->deleteUnusedPicture(self::PROFILE_PATH);
           return $this->save($file,self::PROFILE_PATH,self::PROFILE_ALT);
        }
    }
    
    public function saveTutorialPicture($file){
        if($this->checkImg($file)){
           $this->deleteUnusedPicture(self::TUTORIAL_PATH);
           return $this->save($file,self::TUTORIAL_PATH,self::TUTORIAL_ALT);
        }
    }
    public function saveExercisePicture($file){
        if($this->checkImg($file)){
           $this->deleteUnusedPicture(self::EXERCISE_PATH);
           return $this->save($file,self::EXERCISE_PATH,self::EXERCISE_ALT);
        }
    }
    public function saveTestPicture($file){
      if($this->checkImg($file)){
          $this->deleteUnusedPicture(self::TEST_PATH);
           return $this->save($file,self::TEST_PATH,self::TEST_ALT);
        }  
    }
    public function saveQuestionPicture($file){
        \Tracy\Debugger::barDump('saveQuestionPicture');
        \Tracy\Debugger::barDump($file);
        if($this->checkImg($file)){
           $this->deleteUnusedPicture(self::QUESTION_PATH);
           $width = $this->questionImageSize[0];
           $height = $this->questionImageSize[1];
           return $this->save($file,self::QUESTION_PATH,self::QUESTION_ALT,$width,$height);            
        }
    }    
   
    
    private function save($file,$path,$alt,$width = false, $height = false){
        \Tracy\Debugger::barDump('save');
        $name = $this->getName($file);        
        $url = $path.'/'.$name;
        $file->move($url);
        $image = Image::fromFile($url);
        $width = $width ? $width : $this->imageSize[0];
        $height = $height ? $height : $this->imageSize[1];
        $image->resize($width, $height,Image::SHRINK_ONLY);
        $image->save($url);
       
        
        $id = $this->saveToDB($file, $url, $alt);
        
        return $id;
    }
            
    private function saveToDB($file,$url,$alt){        
        $imgSize = $file->getImageSize();
        $width = $imgSize[0];
        $height = $imgSize[1];       

        $pictureData['url'] = $url;
        $pictureData['width'] = $width;
        $pictureData['height'] = $height;
        $pictureData['alt'] = $alt;

        $id = $this->database->table(self::TABLE_NAME)
                       ->insert($pictureData)->getPrimary();   

        return $id;
        
    }
    
    private function deleteUnusedPicture($folder){        
        $activePictures = $this->database->table(self::TABLE_NAME)
                                ->select(self::COLUMN_URL)
                                ->where(self::COLUMN_ID . '> 0')
                                ->fetchPairs(null,self::COLUMN_URL);
        $folderPictures = [];
        
        foreach (Finder::findFiles('*.jpg','*.gif','*.png','*.jpeg')->from($folder) as $file) {  
            $path = str_replace("\\","/",$file->getPathname());
            $folderPictures[] = $path;           
        } 
        
        $delete = array_diff($folderPictures,$activePictures);
        \Tracy\Debugger::barDump($folderPictures);
        \Tracy\Debugger::barDump($activePictures);
        foreach($delete as $item){
            unlink($item);
        }       
    }
   
    
}
