<?php

namespace FrontModule;

class HomepagePresenter extends BasePresenter
{   
    public function renderDefault(){
        $this->template->intro = $this->textManager->getText('intro');        
    }
}
