<?php
namespace App\Components;

use Nette\Application\UI\Control;

class HelpControl extends Control{
    
    const TEMPLATE = '/templates/help.latte';
    
     private $help;
    
    public function render(){
        $this->template->setFile(dirname(__FILE__) . self::TEMPLATE);
        $this->template->help = $this->help;
        $this->template->render();
    }
       
    
    public function setText($text){
        
       $this->help = $text;
    }
        
    
}
