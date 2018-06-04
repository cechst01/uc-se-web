<?php
namespace App\Components;

use Nette\Application\UI\Control;
use Nette\Http\Request;
use Nette\Http\UrlScript;
use Nette\Utils\Paginator;

class PaginationControl extends  Control {
    
   const TEMPLATE = '/templates/pagination.latte';
   
   private $radius = 5;
    
   private $paginator;
    
   private $url;
   
   private $type;
   
   public function __construct($type, Request $request)
   {
        parent::__construct();
        $this->paginator = new Paginator();
        $this->url = $request->getUrl();
        $this->type = $type;
   }
   
   public function setRadius($radius)
    {
        if (is_numeric($radius)) $this->radius = (int)$radius;
    }
    
    public function &getPaginator()
    {
        return $this->paginator;
    }
    
    public function setItemsPerPage($itemsPerPage)
    {
        $this->paginator->setItemsPerPage($itemsPerPage);
    }
    
        
    public function render()
    {
        $this->template->setFile(dirname(__FILE__) . self::TEMPLATE); // Nastaví šablonu komponenty.

        // Deklarace pomocných proměných.
        $page = $this->paginator->getPage();
        $pages = $this->paginator->getPageCount();

        // Předává parametry do šablony.
        $this->template->type = $this->type;
        $this->template->page = $page;
        $this->template->pages = $pages;
        $this->template->left = $page - $this->radius >= 1 ? $page - $this->radius : 1;
        $this->template->right = $page + $this->radius <= $pages ? $page + $this->radius : $pages;
        $this->template->url = $this->url;
        $this->template->render(); // Vykreslí komponentu.
    }
   
}

interface IPaginationControlFactory
{
        /**
         * Vrací novou komponentu pro správu a vykreslování stránkování s automaticky inejectovanými závislostmi.
         * @return PaginationControl komponenta pro správu a vykreslování stránkování
         */
        public function create($type);
}
