<?php
namespace App\Components;

use Nette\Application\UI\Control;
use App\Model\CategoryManager;


class MenuControl extends Control{
    
    
    const TEMPLATE = '/templates/menu.latte';
    private $categoryManager;
    private $menuArray = [
       'editor' => ':Front:Tutorial:test',
       'forum' => ':Front:Forum:categories'
    ];
    
    
    public function __construct(CategoryManager $categoryManager) {
        parent::__construct();
        $this->categoryManager = $categoryManager;
    }
    
    public function render(){
        
        $this->template->setFile(dirname(__FILE__) . self::TEMPLATE); // Nastaví šablonu komponenty.
        $categories = $this->categoryManager->getCategories();
        //dump($categories);
        $this->template->categories = $categories;
        $this->template->menuArray = $this->menuArray;
        
        $this->template->render();
    }
    
}

interface IMenuControlFactory
{
        /**
         * Vrací novou komponentu pro správu a vykreslování stránkování s automaticky inejectovanými závislostmi.
         * @return MenuControl komponenta pro správu a vykreslování stránkování
         */
        public function create();
}
