/* zobrazeni nahledu brazku */

function showThumbnail(upload){  
    
    var parent = upload.parent();
    var file = upload.prop('files')[0];           
    if(file.type.match('image-*'))
    {
        var url =  URL.createObjectURL(file);


        var oldImg = parent.find('.view');

        if(typeof(oldImg) !== 'undefined')
        {               
          oldImg.remove();                
        }

         var view = $('<div class="view"></div>');
         var remove = $('<div class="viewremove"><span class="fa fa-trash-o" title="Odebrat"></span></div>');
         remove.on('click',function(){
           $(this).parent().remove();
           upload.val('');
         });
         remove.appendTo(view);
         var img = $("<img class='viewimg'>");                
         img.attr('src',url);
         img.appendTo(view);
         view.insertAfter(upload);

    }       
}

function choice(){
    var choice = confirm('Opravdu si přejete tuto položku odstranit?');
    return choice;
}

function setDoctype(value,js){    
    var trim = value.trim();  
    var withoutDoc = trim.replace(/<!doctype.*>/gi,'');
    var withoutHtml = withoutDoc.replace(/<html.*>/gi,'');
    var clear = withoutHtml.replace(/<\/html.*>/gi,''); 
    var html;
    if(js){
        html = '<html>\n' +'<script>\n'+ clear +'\n</script>'+ '\n</html>'
    }
    else{
        html = '<html>\n' + clear + '\n</html>';
    }
    
    var doctype = '<!DOCTYPE html>\n' + html;  
    var result = doctype.replace(/\n\s*\n/g, '\n');
 
    return result;
}

function setJs(){
    
}

function toEditor(obj){
    var url = obj.closest('.code-wrapper').attr('data-url');    
    var html = obj.children(['code']).text(); 
    var doctype;    
    if(obj.hasClass('language-javascript')){
        doctype = setDoctype(html,true);
    }
    else{
        doctype = setDoctype(html,false);
    }
    var form = $('<form>')
            .attr({'method':'get','action':url,'target':'_blank'});
    var hidd = $('<input>')
            .attr({'type':'hidden','name':'hidd','value':doctype});
    var sub = $('<input>')
            .attr({'type':'submit','value':'Vyzkoušet', 'class':'button'});   

    form.append(hidd);
    form.append(sub);    
    obj.after(form);
}

    
$(function(){
$.nette.init();

if(typeof tinymce !== 'undefined'){
    $('.re').on('click',function(){  
           var name = $(this).data('re');   
           tinyMCE.activeEditor.focus();
           tinyMCE.activeEditor.selection.setContent('<p><strong><span>' + name + ':&nbsp' +'</span></b>');
           tinyMCE.activeEditor.execCommand('Bold',false);    
    });
}
/* vložení formuláře k ukázce kódu pro přesměrování na editor */
/*
$('.toEditor.language-markup').each(function(){
    var url = $(this).closest('.code-wrapper').attr('data-url');    
    var html = $(this).children(['code']).text(); 
    var doctype = setDoctype(html);
    var form = $('<form>')
            .attr({'method':'post','action':url,'target':'_blank'});
    var hidd = $('<input>')
            .attr({'type':'hidden','name':'hidd','value':doctype});
    var sub = $('<input>')
            .attr({'type':'submit','value':'Vyzkoušet', 'class':'button'});   

    form.append(hidd);
    form.append(sub);    
    $(this).after(form);
});
*
*/

$('.toEditor').each(function(){toEditor($(this));});
//$('.toEditor.language-javascript').each(function(){toEditor($(this));});

/* menu */

$('.category').on('click',function(event){
    var subcat = $('.subcategories');
    var parentCount= $(this).parents('.category').length;
    
    if(parentCount === 0){  
     var mySub = $(this).find('.subcategories');      
     subcat.not(mySub).hide();     
    } 
    
    $(this).children('.subcategories').toggle();    
 
    event.stopPropagation();
});

/* nápověda */
$('.helpIco').on('click',function(){
    var parent = $(this).parent();
    parent.children('.help-text').toggle();
});

/* Přidání náhledu všem uploadům */
function addCheckUpload(){ 
    var uploads = $('input[type=file]');         
    uploads.each(function(){        
        $(this).on('change', function()
        {
           showThumbnail($(this)); 
        });
    });       
};
   
addCheckUpload();    

/* inicializace code mirroru */
var editors = document.querySelectorAll('.editor');
var delka = editors.length;
for(var i =0; i<delka;i++){
    var item = editors[i];
    var mode = item.dataset.mode ? item.dataset.mode : 'htmlmixed';    
    var myCodeMirror = CodeMirror.fromTextArea(item,
    { value: item.value, mode: mode,  lineNumbers: true, theme: '3024-day'});
}

/* potvrzeni smazani */
$('.confirm').on('click', function(e){ 
  var choice = confirm('Opravdu si přejete tuto položku odstranit?');
 
    if(!choice){
        e.preventDefault();
    }
});

/* automaticke skryvani flash zprav */
setTimeout(function(){ $(".flash").hide(); }, 8000);


});
