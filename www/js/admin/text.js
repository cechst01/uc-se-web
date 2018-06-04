$(function(){
    
    tinymce.init({       
        selector: '.my',
        plugins: 'preview textcolor codesample  table charmap',
        toolbar: "forecolor backcolor preview undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link table charmap",        
        image_caption: true,
        language: 'cs',
        resize: 'both',
        entity_encoding : "raw"
    });
    
$('[name=send]').on('click',function(){    
    tinyMCE.triggerSave();
});
    
});


