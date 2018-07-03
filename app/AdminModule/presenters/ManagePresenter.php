<?php
namespace AdminModule;

class ManagePresenter extends BasePresenter{   
    
   /** @persistent */
    public $type = 'ASC'; 
    
    /** @persistent */
    public $filter = [];   
         
    protected function filtre($manager,$id=false){
        
        if($id){
           return $this->_filtre($manager,$id);  
        }
        else{
          return $this->_filtre($manager);   
        }   
    }
    
    protected function sort($manager,$orderColumn, $orderType,$id=false){  
        $this->filter['ordercolumn'] = $orderColumn;
        $this->filter['ordertype'] = $orderType;
        
        if($id){
           $items =  $this->_filtre($manager,$id);  
        }
        else{
          $items =  $this->_filtre($manager);   
        }
        $this->type = ($orderType == 'ASC') ? 'DESC' : 'ASC';
        $this->template->type = $this->type;
        $this->template->sort = $orderColumn;
        unset($this->filter['ordercolumn'],$this->filter['ordertype']); 
        
        return $items;       
    }    
        
    protected function removeFilter($manager,$id=false){
        $this->filter = [];
        $this->template->sort = '';
        if($id){
             return $this->_filtre($manager,$id);
        }
        else{
             return $this->_filtre($manager);
        }
    
    }
        
    private function _filtre($manager,$id = false){
        $paginator = &$this['paginator']->getPaginator();
        
        if($id){           
            $items = $manager->getFiltreItems($this->filter,$id);       
        }
        else{
            $items = $manager->getFiltreItems($this->filter);   
        }              
       
        $paginator->setItemCount(count($items));        
        $paginator->setPage($this->getParameter('page', 1));
        
        $items->limit($paginator->getLength(),$paginator->getOffset()); 
        
        return  $items->fetchAll();
    }
    
    public function filterSucceeded($form, $values){        
        $deleted = $form->getHttpData($form::DATA_TEXT, 'deleted[]'); 
        
        if($deleted){
            $this->multipleDelete($deleted);
        }
        else{
            $this->filter = array_filter((array) $values, function ($s) {return ($s === "" || $s === NULL || $s === [] ? FALSE : TRUE);});
            $this->redirect("this");    
        }
         
    }
    
    protected function createComponentPaginator(){
       return $this->paginationControlFactory->create('page');
    }
}
