/* funkce zobrazi nahled v editoru */    
function view(){
    
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
    var js = '<script id="skript">' + js_area.value + '<'  + "/script>" ;

    var iframe = document.getElementById('frame');
    iframe.contentWindow.document.open();          
    iframe.contentWindow.document.write(css + html + js);
    iframe.contentWindow.document.close();    
    
}


// odebere všechny style elementy a elementy se style atributem
function disableCSS(){
  
    var iframe = document.getElementById('frame');
    var frameDocument = iframe.contentWindow.document;  

    var styles = frameDocument.querySelectorAll('style');
    var len = styles.length;   
    for(var i = 0; i < len; i++){
        styles[i].parentNode.removeChild(styles[i]);
    }
   
    var  styleAttributes = frameDocument.querySelectorAll('[style]');   
    var len = styleAttributes.length;
    for(var i = 0; i < len; i++){
          styleAttributes[i].removeAttribute('style');
    }
   
    var script = frameDocument.querySelector('#skript');
    script.parentNode.removeChild(script);
    
    var js_area = document.getElementById('js');  
    var js = document.createElement("script");
    
    var textnode = document.createTextNode(js_area.value);
    js.appendChild(textnode);
   
    var body = frameDocument.querySelector('body');
    body.appendChild(js);
   
   
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
          resultArray.push(message);

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
        resultArray.push(message);

    }

   return resultArray; 
}

function propertyIs(selector,property,value,message,frameDocument){
        
    console.log('value');
    console.log(value);
    var resultArray = [];    
    var newProperties = getExpandedProperties(property);
    var newValues = parseValue(value);    
    console.log('newValues');
    console.log(newValues);
    var items = frameDocument.querySelectorAll(selector);                    

    var length = items.length;
    if(length > 0){
         for(var i = 0; i<length; i++){
           var obj = items[i];
           var len2 = newProperties.length;
           
           for(var  j = 0; j < len2; j++ ){               
               var computedPropertyValue= frameDocument.defaultView.getComputedStyle(obj,null).getPropertyValue(newProperties[j]);
               var trimComputedValue = computedPropertyValue.replace(/\s+/g,'').trim();
               console.log('vracena hodnota');
               console.log(trimComputedValue);
               console.log('pozadovana hodnota');
               console.log(newValues[j]);
               //console.log(value);
               if( (trimComputedValue != newValues[j]) && (trimComputedValue != newValues[j]+'px') && (trimComputedValue != '"'+newValues[j]+'"')  ) {
                    resultArray.push(message);
                    //break;
               }
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
        resultArray.push(message);            
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
              var withoutBody = htmlSpaces.replace('<tbody>','');
              var withoutBodyFull = withoutBody.replace('</tbody>','');
              
              if(withoutBodyFull != valueSpaces){
                   resultArray.push(message);  
              }
             
            }
        }                                  
    }
    else
    {
        resultArray.push(message);
    }

    return resultArray; 
}

function containsChild(selector,value,message,frameDocument){  
    var parent = frameDocument.querySelector(selector);
    var child = frameDocument.querySelector(value);
    var resultArray = [];
     var contains = false;
     
    if(parent && child){
       contains = parent.contains(child);  
    }
    else{
        resultArray.push(message);
    }   
    
    if(!contains){
       resultArray.push(message); 
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
           resultArray.push(message);

       }

   return resultArray; 
}
//selector, property, value, errorMessage, frameDocument
function returnFunctionValue(functionName,args,value,errorMessage,frameDocument){
    var resultArray = [];    
    var frame = $('#frame');
    
    var argsWithoutSpaces = args.replace(/\s+/g,'').trim();
    var argsArray = argsWithoutSpaces.split(',');
    var argsArray = parseStringIntFloat(argsArray);
    
    
    var valueWithoutSpaces = value.replace(/\s+/g,'').trim();
    if(valueWithoutSpaces.indexOf(',') != - 1){
        var valuesArray = valueWithoutSpaces.split(','); 
        var values = parseStringIntFloat(valuesArray);
    }
    else{
       var values = [value.replace(/'/g, '')];
    }
   
    var frameWindow = frame[0].contentWindow;   
    var fn = frameWindow[functionName];   
    // is object a function?
    if (typeof fn === "function"){
        var results = fn.apply(null,argsArray);
        if(typeof(results != 'array')){
            results = [results];
        }
        var resultLength = results.length;
        var len = values.length;
        
        if(resultLength == len){
            for(var i = 0; i< len; i++){
                
                console.log(results[i]);
                console.log(values[i]);

                if(results[i] != values[i]){
                    resultArray.push(errorMessage);
                    break;
                }
            }
        }
    }
    else{
       resultArray.push(errorMessage);
    }      
    
    return resultArray;
}

function parseStringIntFloat(array){
    
    var newArray = array.map(function(arg){
        if(arg.indexOf("'") != - 1 ){                 
            var replaced = arg.replace(/'/g, '');
            return replaced;
        }
        else{
            if(arg.indexOf('.') == - 1){
                return parseInt(arg);
            }
            else{
                return parseFloat(arg);
            }
        }
    });
    
    return newArray;
}

   var functionArray = [];
   functionArray.push(itemHasClass,itemHasAttribute,propertyIs,attributeIs,inHtmlIs,inTextIs,containsChild,returnFunctionValue);

function merge_array(array1, array2) {
    var result_array = [];
    var arr = array1.concat(array2);
    var len = arr.length;
    var assoc = {};
    while(len--) {
        var item = arr[len];
        if(!assoc[item]) 
        { 
            result_array.unshift(item);
            assoc[item] = true;
        }
    }
    return result_array;
}

/* funkce přijimá název vlastnosti, zjistí jestli se tato vlasnost má rozšířit
 * pokud ano, zjistím kterým způsobem se bude rozšiřovat a zavolá danou rozšiřovací funkci
 * vrátí pole vlastností - v případě že se vlasnost rozšiřuje nebo jen původní vlastnost v poli
 * v případě že se vlastnost nerozšiřuje.
 * např. pro border-color vrátí [border-top-color, border-right-color, ...] */ 
function getExpandedProperties(property){
    // vlastnosti pro rozšíření typ 1 
    var expandPropertiesWayOne = ['border-color','border-style','border-radius','border-width'];
    // vlastnosti pro rozšíření typ 1 
    var expandPropertiesWayTwo = ['margin','padding'];
    var sides =  ['top','right','bottom','left'];
    var expandedProperties;
    
    if(expandPropertiesWayOne.indexOf(property) != -1){
        expandedProperties = expandWayOne(property,sides);
    }
    else if(expandPropertiesWayTwo.indexOf(property) != -1){
        expandedProperties = expandWayTwo(property,sides);
    }
    else{
       expandedProperties = [property]; 
    }
    
    return expandedProperties;
}

function expandWayOne(property,sides){
    var newProperties = [];
    var len = sides.length;
    for(var i = 0; i < len; i++){
        var newProperty = property.replace('-','-'+sides[i]+'-');
        newProperties.push(newProperty);
    }
    return newProperties;
}

function expandWayTwo(property,sides){
    var newProperties = [];
    var len = sides.length;
    for(var i = 0; i < len; i++){
        var newProperty = property + '-' + sides[i];
        newProperties.push(newProperty);
    }
    return newProperties;
}

function parseValue(value){
    var values = value.split(" ");
    var len = values.length;
    var top, right, bottom, left;    
    switch(len){
        case 1:
            top = right = bottom = left = values[0];
            break;
        case 2:
            top = bottom = values[0];
            right = left = values[1];
            break;
        case 3:
            top = values[0];
            right = left = values[1];
            bottom = values[2];
            break;
        case 4:
            top = values[0];
            right = values[1];
            bottom = values[2];
            left = values[3];
            break;
    }
    var ret = [top,right,bottom,left];
    
    return ret;
    
}

/*
function checkPseudoClasses(selector){
    var result = [];
    if(selector.indexOf(':') != -1){
       var len = selector.length;
       var pos = selector.indexOf(':');
       var newSelector = selector.substring(0,pos);
       var pseudoClass = selector.substring(pos,len);
       result.push(newSelector,pseudoClass);
    }else{
        result.push(selector,null);
    }
    console.log(result);
    return result;
}
*/


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

