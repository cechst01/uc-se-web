$(function(){
        
    $('.removeCategory').on('click',function(){ removeCategory($(this));});
     
        
    $('#addCategory').on('click',addParentCategory);
    $('.addCategory').on('click',function(){ addSubcategory($(this));});
    
    function addParentCategory(){
        var addCategoryBtn = $('#addCategory');
        
        var parents = $('.parent');
        var ids = [];
        
        parents.each(function(){
            ids.push($(this).attr('id'));
        });
        
        var biggestId = Math.max.apply(null,ids);
        var lastParentId = biggestId;       
        if(lastParentId == '-Infinity'){                
                lastParentId = 1;
            }
            else{
               lastParentId++; 
            }        
        var counter = lastParentId;

        
      
        var div = $('<div id="'+counter+'"class="parent top-parent"></div>');
        var name = $('<input type="text" name="id['+counter+'][0][name]">');
        name.attr('data-nette-rules','[{"op":":filled","msg":"Musíte vyplnit název kategorie."}]');
        name.attr('title','Název položky menu');
        name.attr('placeholder','Název');
        /*
        var unique = $('<input type="text" name="id['+counter+'][0][unique]">');
        unique.attr('data-nette-rules','[{"op":":filled","msg":"Musíte vyplnit editační název kategorie."}]');
        */
        var url = $('<input type="text" name="id['+counter+'][0][url]">');
        url.attr('title','Je možné zadat url a vytvořit tak externí odkaz');
        url.attr('placeholder','URL');
        var addSubcatBtn = $('<button type="button" class="smallButton"></button>');
        var removeCatBtn = $('<button type="button" class="ico-button"></button>');
        addSubcatBtn.append('<span class="fa fa-plus"> Přidat podkategorii</span>');
        removeCatBtn.append('<span class="fa fa-trash-o"></span>');
        removeCatBtn.attr('title','Odebrat');
        addSubcatBtn.on('click',function(){ addSubcategory($(this)); });
        removeCatBtn.on('click',function(){ removeCategory($(this)); });        
        name.appendTo(div);      
        url.appendTo(div);
        removeCatBtn.appendTo(div);
        addSubcatBtn.appendTo(div);
        div.insertBefore(addCategoryBtn);
      
    }
    
    function addSubcategory(btn){
        
        var parent = btn.parent();
        var idecko = parent.attr('id');
        var parents = $('.parent');
        var ids = [];
        
        parents.each(function(){
            ids.push($(this).attr('id'));
        });
        
        var biggestId = Math.max.apply(null,ids);
        var lastParentId = biggestId;
        
        if(lastParentId == '-Infinity'){
                lastParentId = 1;
            }
            else{
               lastParentId++; 
            }
        var counter = lastParentId;
        
        var div = $('<div id="'+counter+'"class="parent"></div>');
        var name = $('<input type="text" name="id['+counter+']['+idecko+'][name]">');
        name.attr('data-nette-rules','[{"op":":filled","msg":"Musíte vyplnit název kategorie."}]');        
        var url = $('<input type="text" name="id['+counter+']['+idecko+'][url]">');
        var addSubcatBtn = $('<button type="button" class="smallButton"></button>');
        var removeCatBtn = $('<button type="button" class="ico-button"></button>');
        addSubcatBtn.append('<span class="fa fa-plus"> Přidat podkategorii</span>');
        removeCatBtn.append('<span class="fa fa-trash-o"></span>');      
        
        
        addSubcatBtn.on('click',function(){ addSubcategory($(this)); });
        removeCatBtn.on('click',function(){ removeCategory($(this)); });        
        name.appendTo(div);     
        url.appendTo(div);
        removeCatBtn.appendTo(div);
        addSubcatBtn.appendTo(div);              
        div.appendTo(parent);             
    }
    
    function removeCategory(btn){
        if(choice()){
            btn.parent().remove();
        }
       
    }
     
});
    
