$(function(){
    
    $('.add-level').on('click',function(){ addLevel($(this));});
   $('.remove-level').on('click',function(){ removeLevel($(this));});
    
    function addLevel(button){
        var levels = $('.user-level');
        var ids = [];
        
         levels.each(function(){
            ids.push($(this).attr('id'));
        });        
        
        var biggestId = Math.max.apply(null,ids);
        var lastId = biggestId + 1;
        
        var div = $('<div class="user-level"></div>');
            div.attr('id',lastId);
            
        var name = $('<input type="text">');
            name.attr('name','level['+lastId + '][name]');
            name.attr('data-nette-rules','[{"op":":filled","msg":"Musíte vyplnit název úrovně."}]');
        var nameLabel = $('<label>Název:</label>');
        
        var points = $('<input type="number">');
            points.attr('name','level['+lastId + '][max_points]');
            points.attr('data-nette-rules','[{"op":":filled","msg":"Musíte vyplnit maximální počet bodů úrovně"},{"op":":integer","msg":"Zadejte platné celé číslo."},{"op":":min","msg":"Musí být větší než 0","arg":1}]');
        var pointsLabel = $('<label>Limit bodů:</label>');
        
        var removeButton = $('<button class="ico-button" type="button"><span class="fa fa-trash-o"></span></button>');
            removeButton.on('click',function(){removeLevel($(this));});
        
        nameLabel.appendTo(div);
        name.appendTo(div);
        pointsLabel.appendTo(div);
        points.appendTo(div);
        removeButton.appendTo(div);
        
        
        div.insertBefore(button);
        
    }
    
    function removeLevel(btn){
        var levels = $('.user-level');
        if(levels.length < 2){
            alert('Musí být zadána alespoň jedna úroveň.');
            return ;
        }
        if(choice()){
            btn.parent().remove();
        }
    }
});


