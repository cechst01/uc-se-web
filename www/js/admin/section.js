$(function(){
  
    var categories = [];
    
    var cat = JSON.parse($('#categories').val());    
    
    for(var index in cat){      
       var arr = [index,cat[index]];
       categories.push(arr);       
    }


    $('.add-section').on('click',function(){ addSection($(this)); });
    $('.remove-section').on('click',function(){ removeSection($(this)); });
     
    function addSection(btn){  

        var sections = $('.admin-section');
        var ids = [];

        sections.each(function(){
           var id = $(this).attr('id');
           ids.push(id); 
        });

        var lastId;
        var maxId = Math.max.apply(null, ids);
        
        if(maxId == '-Infinity'){
            lastId = 1;
        }
        else{
            lastId = maxId + 1;
        }

        var div = $('<div class="admin-section" id="'+lastId+'"></div>');
        var table = $('<table></table>');
        var row1 = $('<tr></tr>');
        var row2 = $('<tr></tr>');
        var row3 = $('<tr></tr>');
        var row4 = $('<tr></tr>'); 
        var labelName = $('<label>Název:</label>');
        var labelDescription = $('<label>Popis:</label>');
        var labelCategory = $('<label>Kategorie:</label>');
        var name = $('<input type="text" name="sections['+lastId+'][name]" class="input">');
        name.attr('data-nette-rules','[{"op":":filled","msg":"Musíte vyplnit název sekce"}]');
        var description = $('<textarea name="sections['+lastId+'][description]" class="input"></textarea>'); 
        description.attr('data-nette-rules','[{"op":":filled","msg":"Musíte vyplnit popis sekce"}]');
        var select = $('<select name="sections['+lastId+'][category_id]" class="input"></select>');
        var removeBtn = $('<button type="button"class="ico-button remove-section"></button>');
        removeBtn.attr('title','Odebrat');
        removeBtn.on('click',function(){ removeSection($(this)); }); 
        removeBtn.append('<span class="fa fa-trash-o"></span>');

        labelName.appendTo(row1);
        name.appendTo(row1);
        labelCategory.appendTo(row2);
        select.appendTo(row2);
        labelDescription.appendTo(row3);
        description.appendTo(row3);
        removeBtn.appendTo(row4);
        row4.append('<td></td>');

        row1.appendTo(table);
        row2.appendTo(table);
        row3.appendTo(table);
        row4.appendTo(table);

       table.appendTo(div);

        for(var i =0; i < categories.length; i++ )
        {
            var arr = categories[i];
            var option = $('<option value="'+arr[0]+'">'+arr[1]+'</option>');
            option.appendTo(select);
        }

        div.insertAfter(btn);

        labelName.wrap("<td></td>");
        name.wrap("<td></td>");
        labelCategory.wrap("<td></td>");
        select.wrap("<td></td>");
        labelDescription.wrap("<td></td>");
        description.wrap("<td></td>");
        removeBtn.wrap("<td></td>");
    }
     
    function removeSection(btn){
        if(choice()){
           btn.closest('.admin-section').remove(); 
        }
        
    }
        
});


