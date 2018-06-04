$(function(){
    
    tinymce.init({       
       selector: '.postArea',        
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
        //auto_focus: 'postArea'

    });
    $('[name=send]').on('click',function(){
       tinyMCE.activeEditor.dom.addClass(tinyMCE.activeEditor.dom.select('pre'), 'toEditor');
       tinyMCE.triggerSave();
    });

      
        var value =  $('#postArea').val();    
        if(value){        
           $("html, body").animate({ scrollTop: $(document).height()},0); 
        }  
   
});
       