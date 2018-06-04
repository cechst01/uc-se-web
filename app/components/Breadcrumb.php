<?php
namespace App\Components;

use Nette\Application\UI\Control;

class Breadcrumb extends Control{
    
    const TEMPLATE = '/templates/breadcrumb.latte';
    
    private $links = [];
    
    public function render(){
        $this->template->setFile(dirname(__FILE__) . self::TEMPLATE);
        $this->template->links = $this->links;
        $this->template->render();
    }
    
    public function addLink($text, $link, $title){
        
       $this->links[] = [$text,$link,$title];
    }
    
    public function AddLinks($array)
    {
        $this->links = array_merge($this->links,$array);
    }
    
}

