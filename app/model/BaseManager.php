<?php
namespace App\Model;

use Nette\Object;
use Nette\Database\Context;
use App\Model\PictureManager;


abstract class BaseManager extends Object
{
        
    protected $database;
    protected $pictureManager;
    
    public function __construct(Context $database, PictureManager $picMan) 
    {
        $this->database = $database;
        $this->pictureManager = $picMan;
    }
    /*
     * @param 
     * @param string
     * @param array
     */
    protected function order($colection,$table,$parameters){
        if(!empty($parameters['ordercolumn'])){
                
                $item = $this->database->table($table)
                                    ->fetch();
                if($item && (isset($item[$parameters['ordercolumn']]) || $parameters['ordercolumn'] == 'users.username' )
                         && ($parameters['ordertype'] == 'ASC' || $parameters['ordertype'] == 'DESC' ))
                {
                    $colection->order($parameters['ordercolumn'] . ' ' . $parameters['ordertype']);
                    
                }
            }
        return $colection;    
    }
   
}
