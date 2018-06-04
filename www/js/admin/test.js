 
$(function(){
    
    upgradeAnswersLabel();      
    $('.addRemoveAnswerEvent').each(function(index){           
       $(this).on('click',function(){ deleteAnswer($(this));});        
    });
    $('.addRemoveQuestionEvent').each(function(index){
       $(this).on('click',function(){ deleteQuestion($(this));});
    });
    $('.addAnswerEvent').each(function(index){
       var partName = $(this).data('partname');
       var idName = $(this).data('idname');
       $(this).on('click',function(){ createAnswer($(this),partName,idName);});
    });



    var questionCounter = 0;  
    var answerCounter = 0;

    function getQuestionCount(){

        var lastQuestionId = $('.question').last().attr('id');
        if( typeof(lastQuestionId) == 'undefined'){               
            return 0;
        }
        var count = parseInt(lastQuestionId.substr(0,2));     

        return count + 1;
    }

    function getAnswerCount(butt){

        var answerBox = butt.parents('.answers');                 
        var lastAnswerId = answerBox.children('.answer').last().attr('id');

        if( typeof(lastAnswerId) === 'undefined'){
            return 0;
        }
        var answerCount = lastAnswerId.substr((lastAnswerId.length - 8),1);

        return parseInt(answerCount) + 1;

    }

    function upgradeQuestionsHeading(){
        $('.questionheading').each(function(index){
            $(this).text((index + 1) +'. otázka:');
        });
    }

    function upgradeAnswersLabel(){        
        var letters = ['A','B','C','D','E','F','G','H','I','J'];

        var answers = $('.answers');

        var x = 0;
        answers.each(function(){            
            x = 0;
            $(this).children('.answer').each(function(){               
                $(this).children('.answerlabel').each(function(){
                    $(this).text((letters[x] + ': '));
                    x++;
                });
            });
        });
    }




    var add = $('#btn');

    ////// OTAZKA ////////
    // jmeno formulare
    var formName = 'frm-testForm-';
    //pojmenovani kontejneru s otazkami
    var containerQuestion = 'questions-';
    // pojmenovani textboxu otazky
    var questionTextName = '-question'; 


    ///// ODPOVED //////
    // pojmenovani kontejneru odpovedi
    var containerAnswer = '-answers-';

    // id textboxu pro odpoved
    var answerTextName = '-text';



    $('#btn').click(function(){
       var question = createQuestion();
       question.insertBefore(add);
       upgradeQuestionsHeading();
       upgradeAnswersLabel();
    });
    

    function deleteQuestion(butt){
        var count = $('.question').length;      
        if(/*count > 1*/ true){
            if(choice()){                
                var box = butt.parent();
                box.remove();
                upgradeQuestionsHeading();
                questionCounter--;
            }
        }
        else{
            alert('Test musí obsahovat alespoň jednu otázku');   
        }
    }

    function createQuestion(){

        questionCounter = getQuestionCount();
        answerCounter = 0;

        // div obsahujici vsechny prvky jedne otazky
        var questionBox = $('<div id="'+questionCounter+'-question" class="question"></div>');

        // vytvoření textBoxu
        var partName = 'questions['+ questionCounter +']';
        var textBoxName = partName + '[question]';

         // id textboxu otazky
        var idName = formName + containerQuestion + questionCounter;
        var textBoxId = idName + questionTextName; 
        var textLabel = $('<label>Zadání: </label>');
        var textBox = $('<textarea id="'+ textBoxId +'" name="'+textBoxName+'" class="questionText"></textarea>');
          textBox.attr('data-nette-rules',
           '[{"op":":blank","rules":[{"op":":filled","msg":"Pokud neoznačíte test jako rozpracovaný, otázka nesmí být prázdná."}],"control":"hidden"}]'); 
           textBox.attr('title','Text otázky');
        //label 
        var heading = $('<h2 class="questionheading">'+(questionCounter + 1)+'. otázka: </h2>');

        //vytvoření uploadu     
        var uploadName = partName + '[image]';
        var uploadDiv = $('<div></div>');
        var uploadLabel = $('<label>Obrázek k otázce: </label>')
        var upload =  $('<input type="file" name="'+uploadName+'" class="questionFile">');
        var fileSize = $('[data-question-img-size]').attr('data-question-img-size');        
        var uploadRule = '[{"op":"optional"},{"op":":image","msg":"Jsou povolené pouze obrázky ve formátecj JPEG, PNG nebo GIF."},{"op":":fileSize","msg":"Maximální velikost souboru je ' + fileSize +' kB","arg":'+ fileSize * 1024 +'}]';
           upload.attr('data-nette-rules',uploadRule);
           upload.attr('accept','(accept, .jpg, .png, .gif, .jpeg)');
           upload.on('change',function(){
                   showThumbnail(upload);           
           });       
        uploadLabel.appendTo(uploadDiv);
        upload.appendTo(uploadDiv);

        // vytvoření mazacího tlačítka
        var deleteButton = $('<button type="button" title="Odebrat otázku" name="'+ partName +
                            '[remove]" class="ico-button remove-question">' +
                            '<span class="fa fa-trash-o"></span>');
        deleteButton.data("questionid", questionCounter + '-question');
        deleteButton.on('click',function(){ deleteQuestion($(this)); });

        // vytvoření tlačítka pro přidání další odpovědi      
        var addAnswerButton = $('<button type="button" title="Přidat odpověď" name="'+ partName +
                            '[pridat]" class="ico-button ico-button-small">'+
                             '<span class="fa fa-plus"></span></button>');
        addAnswerButton.on('click', function() { createAnswer($(this),partName,idName); });      


        // box pro odpovědi
        var answerBox = $('<div class="answers"><h3>Odpovědi:</h3></div>');

        answerBox.append(addAnswerButton);


        questionBox.append(heading);
        questionBox.append(textLabel);
        questionBox.append(textBox);
        questionBox.append(deleteButton);      
        questionBox.append(uploadDiv);      
        questionBox.append(answerBox);     

        questionCounter++;

        for(var i = 0; i< 3; i++){
            addAnswerButton.click();
        }      
        return questionBox;
    }

    function createAnswer(createButton,partName,idName){      
    var answerCounter = getAnswerCount(createButton);
    if(answerCounter > 9){
       alert('Maximální počet otázek u jednoho testu je 10'); 
    }
    else{       
        var box = $('<div class="answer"></div>');
            box.attr('id',questionCounter+ '-' + answerCounter+'-answer');

        var answerPartname = partName + '[answers]' + '[' + answerCounter + ']';
        var answTextName = answerPartname + '[text]';

        var answerIdName = idName + containerAnswer + answerCounter;   
        var answerId = answerIdName + answerTextName;

        var label = $('<label class="answerlabel" for="'+answerId+'">A: </label>');
            label.data('order',answerCounter);
        var rightLabel = $('<label> Správná odpověď </label>');
        var isRight = $('<input type="checkbox" name="'+ answerPartname + '[is_right]">');
            isRight.attr('title','Označit odpověď jako správnou');
        var answerText  = $('<textarea name="'+answTextName+'" id="'+answerId+'" class="answerText"></textarea>');          
           answerText.attr('data-nette-rules',
            '[{"op":":blank","rules":[{"op":":filled","msg":"Pokud neoznačíte test jako rozpracovaný, odpověď nesmí být prázdná."}],"control":"hidden"}]');
            answerText.attr('title','Text odpovědi');

        var deleteAnswerButton = $('<button class="ad ico-button" type="button" title="Odebrat odpověď" name="'+ partName +
                                   '[odebrat]">'+
                                   '<span class="fa fa-trash-o"></span></button>');
        deleteAnswerButton.data('answerid',(questionCounter + '-' + answerCounter + '-answer'));
        deleteAnswerButton.on('click',function(){ deleteAnswer($(this)) ;});

        box.append(label);
        box.append(answerText);        
        box.append(isRight);
        box.append(rightLabel);
        box.append(deleteAnswerButton);
        box.insertBefore(createButton);

        upgradeAnswersLabel();
        answerCounter++;
    }

    }

    function deleteAnswer(butt){
        var count = getAnswerCount(butt);      
        if(count > 2){ 
            if(choice()){
              var box = butt.parent();          
              box.remove();
              upgradeAnswersLabel();      
              answerCounter--;
            }
        }
        else{
          alert('Na otázku musí být alespoň dvě odpovědi.');
        }
    }
 

    if(getQuestionCount() === 0)
    { $('#btn').click(); }
    
 
});   
  

