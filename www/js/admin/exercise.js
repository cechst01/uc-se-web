$(function(){
    
    var lastCondition = $(".condition").last();

    // tlačítko pro přidávání podmínek
    var addButton = $("<div><button type='button' id='addButton'class='smallButton'>"+
                       "<span class='fa fa-plus'> Přidat podmínku</span>"+
                      "</button></div>");

    addButton.on('click',function(){ addCondition($(this)); });        
    addButton.insertAfter(lastCondition);
   
    $(document).on('change','.type',function(){
        toogleDisable($(this));
        changeLabels($(this));
    });
    changeNames();
    $('.remove').on('click',function(){ removeCondition($(this)); });
    //$('.property').on('keyup',checkCalculate);
    
    function getMaxId(){
      
       var conditions = $(".condition");
       var ids =[];
        
        conditions.each(function(){
            var name = $(this).find('.selector').attr('name');            
            var length = name.length;            
            var index = name.indexOf('[');            
            var sliced = name.slice(index+1,length);            
            var id = parseInt(sliced);            
            ids.push(id);
        });
        
        var biggestId =  Math.max.apply(null,ids);
        return biggestId;
    }
    
    
    function createCondition(selectorVal,typeVal,propertyVal,valueVal,messageVal,notDisabled,id){
        var labels = $('.label');
        var selectorLabel = labels.eq(0).clone();
        var typeLabel = labels.eq(1).clone();
        var propertyLabel = labels.eq(2).clone();
        var valueLabel = labels.eq(3).clone();
        var messageLabel =labels.eq(3).clone();

        var length;
        if(id !== false){
          length = id; 
        }
        else{
           length = getMaxId() + 1;
        }

        var name = 'conditions['+length+']';

        var selectorTd = $('<td></td>');
        var selektor = $("<input type='text' name='"+name+"[selector]' class='selector'>");
        selektor.val(selectorVal);
        selectorLabel.appendTo(selectorTd);
        selektor.appendTo(selectorTd);

        var typeTd = $("<td></td>");
        var type = $('.type:first').clone();         
            type.attr('name',name+"[type]");
            type.removeAttr('id');
            type.on('change',function(){ toogleDisable($(this)); });
            type.val(typeVal);
            typeLabel.appendTo(typeTd);
            type.appendTo(typeTd);

        var propertyTd = $('<td></td>');
        var property = $("<input type='text' name='"+name+"[property]' disabled='' class='property'>");
        //property.on('keyup',checkCalculate);
        property.val(propertyVal);
        if(notDisabled){
            property.removeAttr('disabled');
        }
        propertyLabel.appendTo(propertyTd);
        property.appendTo(propertyTd);

        var valueTd = $('<td></td>');
        var value = $("<textarea name='"+name+"[value]' class='value'></textarea>");
        value.val(valueVal);
        valueLabel.appendTo(valueTd);
        value.appendTo(valueTd);
        
        var messageTd = $('<td></td>');
        var message = $("<textarea name='"+name+"[message]' class='message'></textarea>");
        message.val(messageVal);
        messageLabel.appendTo(messageTd);
        message.appendTo(messageTd);

        var buttonTd = $("<td></td>");
        var removeButton = $('<button name="remove" class="remove ico-button" title="Odebrat podmínku" type="button">'+
                            '<span class="fa fa-trash-o"></span>'+
                            '</button>');
        removeButton.on('click',function(){ removeCondition($(this)); });
        removeButton.appendTo(buttonTd);

        var tr = $("<tr class='condition'></tr>");

        typeTd.appendTo(tr);
        selectorTd.appendTo(tr);        
        propertyTd.appendTo(tr);
        valueTd.appendTo(tr);
        messageTd.appendTo(tr);
        buttonTd.appendTo(tr);

        return tr;
        
    }
       
    function addCondition(){
        var conditions = $(".condition");
        var lastCondition = conditions.last();

        var tr = createCondition('','','','','',false,false);
        tr.insertAfter(lastCondition);        
    }
    
    function removeCondition(removeButton){
        var conditions = $('.condition');
        var length = conditions.length;
        if(length > 1){
            if(choice()){                
                var parent = removeButton.parent().parent();       
                parent.remove();
            }
        }
        else{            
            alert('Poslední podmínku nelze smazat.');
        }
        
    }
    
    function changeNames(){
        var selector = $("#selector");
        var type = $("#type");            
        var property = $("#property");
        var relation = $("#relation");
        var value = $("#value");
        var message = $("#message");
        
        selector.attr('name','conditions[0][selector]');
        type.attr('name','conditions[0][type]');
        relation.attr('name','conditions[0][relation]');
        property.attr('name','conditions[0][property]');
        value.attr('name','conditions[0][value]');
        message.attr('name','conditions[0][message]');
    }
    
    function toogleDisable(select){       
      
        var value = select.val();
        var name = select.attr('name').replace('type','property');  
        var property = $("input[name='" + name + "']");
        var enabledTypes = ['2','3','7'];
        
        if(enabledTypes.indexOf(value) != -1){
           property.removeAttr('disabled'); 
        }
        else{
           property.val('');
           property.attr('disabled','disabled');   
        }     
    }
    
    function changeLabels(select){
        
        var val = select.val();
        var selectors = ['th-check-type','th-selector','th-property','th-value','th-error-message'];
        var labels = [
            ['Zkontroluj jestli:','Selektor:','Jaký atribut/vlastnost:','Požadovaná třída:','Chybová zpráva:'],
            ['Zkontroluj jestli:','Selektor:','Jaký atribut/vlastnost:','Požadovaný atribut:','Chybová zpráva:'],
            ['Zkontroluj jestli:','Selektor:','Jaká vlastnost:','Požadovaná hodnota vlastnosti:','Chybová zpráva:'],
            ['Zkontroluj jestli:','Selektor:','Jaký atribut:','Požadovaná hodnota atributu:','Chybová zpráva:'],
            ['Zkontroluj jestli:','Selektor:','Jaký atribut/vlastnost:','Požadované HTML:','Chybová zpráva:'],
            ['Zkontroluj jestli:','Selektor:','Jaký atribut/vlastnost:','Požadovaný text:','Chybová zpráva:'],
            ['Zkontroluj jestli:','Selektor:','Jaký atribut/vlastnost:','Požadovaný prvek (selektor):','Chybová zpráva:'],
            ['Zkontroluj jestli:','Jméno funkce:','Argumenty funkce:','Požadovaná vrácená hodnota:','Chybová zpráva:'],
        ];
        
        var values = labels[val];
        var len = selectors.length;
        
        for(var i = 0; i < len; i++ ){            
            var elem = $('#'+selectors[i]);
            console.log(elem);
            elem.html(values[i]);
        }
                
    }
    
    /*
    function checkCalculate(){
        
        var calculateArray = ['border-width','border-style','border-color','margin','padding'];
        var text = $( this ).val().toLowerCase();       
        var isIn = calculateArray.indexOf(text);
        var parent = $(this).closest('.condition');
        
        if(isIn !== -1){
            var button = $("<button type='button' class='smallButton cal'>Rozšířit</button>");
            var delButton = parent.find('.ico-button');            
            button.on('click',calculate);
            button.insertBefore(delButton);           
        }
        else{
           var button = parent.find('.cal');
           button.remove();
        }        
    }
    
    function calculate(){
        var parent = $(this).closest('.condition');
        var property = parent.find('.property');        
        var text = property.val().toLowerCase();
        
        
        
        
        var borderArray = ['border-width','border-style','border-color'];
        var marginPaddingArray = ['margin','padding'];
        
        var isInBorder = borderArray.indexOf(text);
        var isInMarginPadding = marginPaddingArray.indexOf(text);
        
        if(isInBorder !== -1){
            border($(this));
        }
        else if(isInMarginPadding !== -1){
            marginPadding($(this));
        }
        
    }
    
    function border(calculateBut){       
        var length = getMaxId() + 1;     
   
        var parent = calculateBut.closest('.condition');
        var selector = parent.find('.selector').val().toLowerCase();
        var type = parent.find('.type').val().toLowerCase();
        var property = parent.find('.property').val().toLowerCase();
        var value = parent.find('.value').val().toLowerCase();
        var message = parent.find('.message').val().toLowerCase();
       
        
        var top = property.replace('-','-top-');
        var right = property.replace('-','-right-');
        var bottom = property.replace('-','-bottom-');
        var left = property.replace('-','-left-');
        
        var topCondition = createCondition(selector,type,top,value,message,true,length);
        var rightCondition = createCondition(selector,type,right,value,message,true,length+1);
        var bottomCondition = createCondition(selector,type,bottom,value,message,true,length+2);
        var leftCondition = createCondition(selector,type,left,value,message,true,length+3);
        
        leftCondition.insertAfter(parent);
        bottomCondition.insertAfter(parent);
        rightCondition.insertAfter(parent);
        topCondition.insertAfter(parent);
        parent.remove();
    }
    
    function marginPadding(calculateBut){        
        var length = getMaxId() + 1;  
        var parent = calculateBut.closest('.condition');
        var selector = parent.find('.selector').val().toLowerCase();
        var type = parent.find('.type').val().toLowerCase();
        var property = parent.find('.property').val().toLowerCase();
        var value = parent.find('.value').val().toLowerCase();
        var message = parent.find('.message').val().toLowerCase();
      
        
        var top = property + '-top';
        var right = property + '-right';
        var bottom = property + '-bottom';
        var left = property + '-left';
        
        var topCondition = createCondition(selector,type,top,value,message,true,length);
        var rightCondition = createCondition(selector,type,right,value,message,true,length+1);
        var bottomCondition = createCondition(selector,type,bottom,value,message,true,length+2);
        var leftCondition = createCondition(selector,type,left,value,message,true,length+3);
        
        leftCondition.insertAfter(parent);
        bottomCondition.insertAfter(parent);
        rightCondition.insertAfter(parent);
        topCondition.insertAfter(parent);
        parent.remove();
    }
    */
   
    function addCheckUpload()
    {    
       
        var uploads = $('input[type=file]');         
        uploads.each(function()
         {                          
             $(this).on('change', function()
             {
                showThumbnail($(this)); 
             });
             
         });         
    };
   
    
    $('[name=send]').on('click',function(){
        var editors = document.querySelectorAll('.CodeMirror');
           editors.forEach(function(editor){               
              editor.CodeMirror.save();          
            
           });
    });
    
    addCheckUpload();
     
});


