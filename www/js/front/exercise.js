/* funkce zobrazi nahled v editoru */    
function view()
{      
     var editors = document.querySelectorAll('.CodeMirror');
     var length = editors.length;
     
     for(var i =0; i<length; i++){
         editors[i].CodeMirror.save();    
     }

    var html_area = document.getElementById('html');
    var html = html_area.value;

    var css_area = document.getElementById('css');
    var css = "<style>" + css_area.value + "</style>";

    var js_area = document.getElementById('js');
    var js = '<script>' + js_area.value + '<'  + "/script>" ;

    var iframe = document.getElementById('frame');
    iframe.contentWindow.document.open();          
    iframe.contentWindow.document.write(css + html + js);           
    iframe.contentWindow.document.close();

}

 function itemHasClass(selector,value,message,frameDocument){
       var resultArray = [];
       var items = frameDocument.querySelectorAll(selector);

       var length = items.length;
       if(items.length > 0){
           for(var i=0; i<length; i++){
              var obj = items[i];
              if(!obj.classList.contains(value)){
                resultArray.push(message);
              }
            }               
       }
       else
       {
           resultArray.push('Prvek: '+ selector + ' není zadán.');

       }

      return resultArray; 
}

   function itemHasAttribute(selector,value,message,frameDocument){           
       var resultArray = [];
       var items = frameDocument.querySelectorAll(selector);

       var length = items.length;
       if(length > 0){
            for(var i=0; i<length; i++){
                var obj = items[i];
                if(!obj.hasAttribute(value)){
                  resultArray.push(message);  
                }

            }                
       }
       else
       {
           resultArray.push('Prvek: '+ selector + ' není zadán.');

       }

      return resultArray; 
}

   function propertyIs(selector,property,value,message,frameDocument){           
       var resultArray = [];
       var items = frameDocument.querySelectorAll(selector);                    

       var length = items.length;
       if(length > 0){
            for(var i = 0; i<length; i++){
              var obj = items[i];
              var returnedProperty = window.getComputedStyle(obj,null).getPropertyValue(property);                 
             if(returnedProperty != value){
                 resultArray.push(message); 
             }
            }
       }
       else
       {
           resultArray.push('Prvek: '+ selector + ' není zadán.');

       }

      return resultArray; 
}

    function attributeIs(selector,attribute,value,message,frameDocument){           
        var resultArray = [];
        var items = frameDocument.querySelectorAll(selector);

        var length = items.length;
        if(items.length > 0){
            for(var i=0; i<length; i++){
                var obj = items[i];
                if(obj.getAttribute(attribute) != value){
                   resultArray.push(message); 
                }
             }                
        }
        else
        {
            resultArray.push('Prvek: '+ selector + ' není zadán.');             
        }

       return resultArray; 
}

function inHtmlIs(selector,value,message,frameDocument){           
    var resultArray = [];
    var items = frameDocument.querySelectorAll(selector);

    var length = items.length;
    if(items.length > 0){
        for(var i = 0; i< length; i++){
            var obj = items[i];

            var valueSpaces = value.replace(/\s+/g,'').trim();
            var htmlSpaces = obj.innerHTML.replace(/\s+/g,'').trim();
            //alert(valueSpaces +' : ' + htmlSpaces);
            if(htmlSpaces != valueSpaces){
              resultArray.push(message);  
            }
        }                                  
    }
    else
    {
        resultArray.push('Prvek: '+ selector + ' není zadán.');
    }

    return resultArray; 
}

   function inTextIs(selector,value,message,frameDocument){           
       var resultArray = [];
       var items = frameDocument.querySelectorAll(selector);                  

        if(items.length > 0){
              for(var i = 0; i< length; i++){
                  var obj = items[i];

                  var valueSpaces = value.replace(/\s/g,' ').trim();
                  var textSpaces = obj.innerText.replace(/\s/g,' ').trim();                 
                  if(textSpaces != valueSpaces){
                    resultArray.push(message);  
                  }
              }                                  
          }
          else
          {
              resultArray.push('Prvek: '+ selector + ' není zadán.');

          }

      return resultArray; 
}

   var functionArray = [];
   functionArray.push(itemHasClass,itemHasAttribute,propertyIs,attributeIs,inHtmlIs,inTextIs);


$(function(){
    
    view();       
    insertCheckCode();       

    $('#chck').on('click',function(){
        view();
        try{
            var result = check();
            alert(result);
            if(result == 'Správně.'){
                saveResult();
            }
        }
        catch(err){
            alert(err);
        }                    
    });   

function insertCheckCode(){

     var check_area = document.getElementById('check-code');

     if(check_area){
        var check_code = check_area.value;
     }
     else{
         var check_code = '';
     }

     var body = document.getElementsByTagName('body')[0];
     //vytvoření elementu script a přidání check function z databaze
     var skript = document.createElement('script');          
     skript.innerHTML = check_code;
     body.appendChild(skript);       
   
 }


try{
    document.getElementById('btn').onclick = view;
}
catch(err){
  alert(err);  
}




$('.editor-choice').on('click',function(){
   var choices = $('.editor-choice');      
   choices.removeClass('active');
   $(this).addClass('active');      
});


$('.html-ico').on('click',function(){
    $('#html-wrapper').show();
    $('#css-wrapper').hide();
    $('#js-wrapper').hide();
    $('.CodeMirror').each(function(i, el){
    el.CodeMirror.refresh();
    });
});

 $('.css-ico').on('click',function(){
    $('#html-wrapper').hide();
    $('#css-wrapper').show();
    $('#js-wrapper').hide();
    $('.CodeMirror').each(function(i, el){
    el.CodeMirror.refresh();
    });
});    

 $('.js-ico').on('click',function(){
    $('#html-wrapper').hide();
    $('#css-wrapper').hide();
    $('#js-wrapper').show();
    $('.CodeMirror').each(function(i, el){
    el.CodeMirror.refresh();
    });
});

  
   
}); 

