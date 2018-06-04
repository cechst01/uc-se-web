$(function(){
/*############### Zobrazení ###############*/

if(typeof tinymce !== 'undefined'){
 
    tinymce.init({       
       selector: '#commentArea',        
       plugins: 'codesample link emoticons',
       menubar: false,
       statusbar: false,       
       toolbar: "| codesample | bold | italic | bullist | numlist | link | emoticons",
       valid_elements: 'p,span[class],strong,pre[class|data|contenteditable],code,em,a[href|title|target],ul,ol,li,img[src]',
       language: 'cs', 
       codesample_languages: [
       { text: 'HTML/XML', value: 'markup'},
       { text: 'JavaScript', value: 'javascript'},
       { text: 'CSS', value: 'css'}        
        ],        
       //auto_focus: 'commentArea',
    });

    $('[name=send]').on('click',function(){
       tinyMCE.activeEditor.dom.addClass(tinyMCE.activeEditor.dom.select('pre'), 'toEditor');
       tinyMCE.triggerSave();
    });

    /*
    $('.re').on('click',function(){  
       var name = $(this).data('re');   
       tinyMCE.activeEditor.focus();
       tinyMCE.activeEditor.selection.setContent('<p><strong><span>' + name + ':&nbsp' +'</span></b>');
       tinyMCE.activeEditor.execCommand('Bold',false);    
    });
    */
}

$('.toggle-comments').on('click',function(){
    $('.comments').toggle(); 
    var toggleText = $(this).children('.toggle-comments-text');
    if(toggleText.text() === 'Zobrazit komentáře'){
       toggleText.text('Skrýt komentáře');
    }
    else{
      toggleText.text('Zobrazit komentáře');  
    }
    
});

var commentText = $('#commentArea');
if(commentText.text() !== ''){  
   $("html, body").animate({ scrollTop: $(document).height()},0); 
}   

/*############### Editor ###############*/

function writteToFrame(value){
    var iframe = $('#frame');
    
    iframe[0].contentWindow.document.open();
    iframe[0].contentWindow.document.write(value);
    iframe[0].contentWindow.document.close(); 

}

var editor = document.querySelector('.CodeMirror').CodeMirror;
if(editor){
    var value = editor.getValue();    

    if(value){
       writteToFrame(value);
    }  
}

$('.run').on('click',function(){            
    var editor = document.querySelector('.CodeMirror').CodeMirror;      
    var html = editor.getValue();
    var doctype = setDoctype(html);
    editor.setValue(doctype);
    writteToFrame(doctype);

});



    


    
});

