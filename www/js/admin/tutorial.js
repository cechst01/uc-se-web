$(function(){
    
  tinymce.init({       
        selector: '.my',
        plugins: 'preview textcolor codesample link image table media fullscreen wordcount',
        toolbar: "codesample | forecolor backcolor sizeselect | preview insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media table | fullscreen",        
        image_caption: true,
        fontsize_formats: "8pt 10pt 12pt 14pt 18pt 24pt 36pt",
        language: 'cs',
        codesample_languages: [
        { text: 'HTML/XML', value: 'markup'},
        { text: 'JavaScript', value: 'javascript'},
        { text: 'CSS', value: 'css'}        
         ],     
        // vybírání obrázků
  file_picker_types: 'image', 
  // callbac vybírání obrázků
  file_picker_callback: function(cb, value, meta) {
    var input = document.createElement('input');
    input.setAttribute('type', 'file');
    input.setAttribute('accept', 'image/*');
   

    input.onchange = function() {
    var file = this.files[0];
    var dataURL;
      
    var reader = new FileReader();
    
      reader.onload = function(){        
      dataURL = reader.result;     
      cb(dataURL, { title: file.name });
    };
    reader.readAsDataURL(file);
    
    };
    
    input.click();
  }
});
    
    
  $('[name=send]').on('click',function(){   
    tinyMCE.activeEditor.dom.addClass(tinyMCE.activeEditor.dom.select('pre'), 'toEditor line-numbers');
    tinyMCE.triggerSave();
});     
});



