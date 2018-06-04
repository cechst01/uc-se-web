<?php
// source: D:\WWW\web-portal-slozeny\app\AdminModule\presenters/templates/Test/manage.latte

use Latte\Runtime as LR;

class Templateb812a7ed3b extends Latte\Runtime\Template
{
	public $blocks = [
		'myScripts' => 'blockMyScripts',
		'title' => 'blockTitle',
		'content' => 'blockContent',
		'_wrapper' => 'blockWrapper',
		'_section' => 'blockSection',
		'jsCallback' => 'blockJsCallback',
	];

	public $blockTypes = [
		'myScripts' => 'html',
		'title' => 'html',
		'content' => 'html',
		'_wrapper' => 'html',
		'_section' => 'html',
		'jsCallback' => 'html',
	];


	function main()
	{
		extract($this->params);
		if ($this->getParentName()) return get_defined_vars();
		$this->renderBlock('myScripts', get_defined_vars());
?>

<?php
		$this->renderBlock('title', get_defined_vars());
?>

<?php
		$this->renderBlock('content', get_defined_vars());
		return get_defined_vars();
	}


	function prepare()
	{
		extract($this->params);
		if (isset($this->params['error'])) trigger_error('Variable $error overwritten in foreach on line 20');
		if (isset($this->params['answer'])) trigger_error('Variable $answer overwritten in foreach on line 94');
		if (isset($this->params['question'])) trigger_error('Variable $question overwritten in foreach on line 62');
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}


	function blockMyScripts($_args)
	{
		extract($_args);
		?>    <script src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 2 */ ?>/js/admin/test.js"></script>
<?php
	}


	function blockTitle($_args)
	{
?>    Editace testu
<?php
	}


	function blockContent($_args)
	{
		extract($_args);
		/* line 10 */ $_tmp = $this->global->uiControl->getComponent("breadcrumb");
		if ($_tmp instanceof Nette\Application\UI\IRenderable) $_tmp->redrawControl(NULL, FALSE);
		$_tmp->render();
		/* line 11 */ $_tmp = $this->global->uiControl->getComponent("helpControl");
		if ($_tmp instanceof Nette\Application\UI\IRenderable) $_tmp->redrawControl(NULL, FALSE);
		$_tmp->render();
		if (isset($name)) {
			?>    <h2>Úprava testu: <?php echo LR\Filters::escapeHtmlText($name) /* line 13 */ ?></h2>
<?php
		}
		else {
?>
    <h2>Vložení testu</h2>
<?php
		}
		$this->renderBlock('_wrapper', $this->params);
?>

<?php
		$this->renderBlock('jsCallback', ['input' => 'category', 'link' => 'categoryChange'] + $this->params, 'html');
?>



<?php
	}


	function blockWrapper($_args)
	{
		extract($_args);
		$this->global->snippetDriver->enter("wrapper", "area");
		/* line 18 */
		echo Nette\Bridges\FormsLatte\Runtime::renderFormBegin($form = $_form = $this->global->formsStack[] = $this->global->uiControl["testForm"], []);
?>

<?php
		if ($form->hasErrors()) {
?>    <ul class="form-error">
<?php
			$iterations = 0;
			foreach ($form->errors as $error) {
				?>        <li><?php echo LR\Filters::escapeHtmlText($error) /* line 20 */ ?></li>
<?php
				$iterations++;
			}
?>
    </ul>
<?php
		}
		?> <div class="itemInfosection" data-question-img-size="<?php echo LR\Filters::escapeHtmlAttr($questionMaxFileSize) /* line 22 */ ?>">
     <table>
         <tr>
             <td><?php if ($_label = end($this->global->formsStack)["category"]->getLabel()) echo $_label ?></td>
             <td><?php echo end($this->global->formsStack)["category"]->getControl() /* line 26 */ ?></td>             
         </tr>
          <tr>
             <td><?php if ($_label = end($this->global->formsStack)["sections_id"]->getLabel()) echo $_label ?></td>
             <td><div id="<?php echo htmlSpecialChars($this->global->snippetDriver->getHtmlId('section')) ?>"><?php
		$this->renderBlock('_section', $this->params) ?></div></td>             
         </tr>
          <tr>
             <td><?php if ($_label = end($this->global->formsStack)["name"]->getLabel()) echo $_label ?></td>
             <td><?php echo end($this->global->formsStack)["name"]->getControl() /* line 34 */ ?></td>             
         </tr>
          <tr>
             <td><?php if ($_label = end($this->global->formsStack)["hidden"]->getLabel()) echo $_label ?></td>
             <td><?php echo end($this->global->formsStack)["hidden"]->getControl() /* line 38 */ ?></td>             
         </tr>
          <tr>
             <td><?php if ($_label = end($this->global->formsStack)["points"]->getLabel()) echo $_label ?></td>
             <td><?php echo end($this->global->formsStack)["points"]->getControl() /* line 42 */ ?></td>             
         </tr>
         <tr>
             <td>Aktuální obrázek:</td>
             <td><?php
		/* line 46 */ $_tmp = $this->global->uiControl->getComponent("picture");
		if ($_tmp instanceof Nette\Application\UI\IRenderable) $_tmp->redrawControl(NULL, FALSE);
		$_tmp->render();
?></td>             
         </tr>
          <tr>
             <td><?php if ($_label = end($this->global->formsStack)["file"]->getLabel()) echo $_label ?></td>
             <td><?php echo end($this->global->formsStack)["file"]->getControl() /* line 50 */ ?></td>             
         </tr>
          <tr>
             <td><?php if ($_label = end($this->global->formsStack)["description"]->getLabel()) echo $_label ?></td>
             <td><?php echo end($this->global->formsStack)["description"]->getControl() /* line 54 */ ?></td>             
         </tr>
     </table>
 </div>  
  <div class="questionWrapper">
    
<?php
		if (isset($questions)) {
?>
       
<?php
			$iterations = 0;
			foreach ($iterator = $this->global->its[] = new LR\CachingIterator($questions) as $question) {
				$questionCounter = $iterator->counter -1;
				;
				$questionBoxId = $questionCounter .'-question';
?>
            
            <div id="<?php echo LR\Filters::escapeHtmlAttr($questionBoxId) /* line 66 */ ?>" class="question">
                <h2 class="questionheading"><?php echo LR\Filters::escapeHtmlText($questionCounter + 1) /* line 67 */ ?>. otázka: </h2>
                
                <label for=frm-testForm-questions-<?php echo LR\Filters::escapeHtmlAttrUnquoted($questionCounter) /* line 69 */ ?>-question">Zadání: </label>
                <textarea name="questions[<?php echo LR\Filters::escapeHtmlAttr($questionCounter) /* line 70 */ ?>][question]"
                        id="frm-testForm-questions-<?php echo LR\Filters::escapeHtmlAttr($questionCounter) /* line 71 */ ?>-question" 
                        data-nette-rule='[{"op":":blank","rules":[{"op":":filled","msg":"Pokud neoznačíte test jako rozpracovaný, otázka nesmí být prázdná."}],"control":"hidden"}]'
                        title='Text otázky' class='questionText'
                        ><?php echo LR\Filters::escapeHtmlText($question['question']) /* line 74 */ ?></textarea>
                        
                <button type="button" class="addRemoveQuestionEvent ico-button remove-question" data-questionid="<?php
				echo LR\Filters::escapeHtmlAttr($questionBoxId) /* line 76 */ ?>"
                        title='Odebrat otázku'>
                    <span class='fa fa-trash-o'></span>
                </button>  
                <input type="hidden" name="questions[<?php echo LR\Filters::escapeHtmlAttr($questionCounter) /* line 80 */ ?>][oldimage]" value="<?php
				echo LR\Filters::escapeHtmlAttr($question['picture']['pictures_id']) /* line 80 */ ?>">
                <div>
                    <label>Obrázek k otázce: </label>
                    <input type="file" name="questions[<?php echo LR\Filters::escapeHtmlAttr($questionCounter) /* line 83 */ ?>][image]" id="frm-testForm-questions-<?php
				echo LR\Filters::escapeHtmlAttr($questionCounter) /* line 83 */ ?>-image"
                       data-nette-rules='[{"op":"optional"},{"op":":image","msg":"Jsou povolené pouze obrázky ve formátecj JPEG, PNG nebo GIF."},{"op":":fileSize","msg":"Maximální velikost souboru je 256 kB.","arg":262144}]'
                       class="questionFile">
<?php
				if ($question['picture']) {
?>
                    <div class="question-picture view">
                        <img src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 88 */ ?>/<?php
					echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($question['picture']['url'])) /* line 88 */ ?>" alt="<?php
					echo LR\Filters::escapeHtmlAttr($question['picture']['alt']) /* line 88 */ ?>">
                    </div>
<?php
				}
?>
                </div>
                <div class="answers">
                    <h3>Odpovědi:</h3>
<?php
				$iterations = 0;
				foreach ($iterator = $this->global->its[] = new LR\CachingIterator($question['answers']) as $answer) {
					$answerBoxId = $questionCounter.'-'.($iterator->counter -1) .'-answer';
					?>                        <div id="<?php echo LR\Filters::escapeHtmlAttr($answerBoxId) /* line 96 */ ?>" class="answer">
<?php
					$name = 'questions[' . $questionCounter .']'.'[answers]['.($iterator->counter - 1).']';
					;
					$id = 'frm-testForm-questionns-' . $questionCounter . '-answers-' . ($iterator->counter - 1) . '-';
					?>                            <label class="answerlabel" for="<?php echo LR\Filters::escapeHtmlAttr($id) /* line 99 */ ?>text"><?php
					echo LR\Filters::escapeHtmlText($letters[$iterator->counter - 1]) /* line 99 */ ?>: </label>
                            <textarea type="text" name="<?php echo LR\Filters::escapeHtmlAttr($name) /* line 100 */ ?>[text]" id="<?php
					echo LR\Filters::escapeHtmlAttr($id) /* line 100 */ ?>text" title="Text odpovědi" class="answerText"
                                      ><?php echo LR\Filters::escapeHtmlText($answer[1].' ' .$answer[0]['text']) /* line 101 */ ?></textarea>
                            <input type="checkbox" name="<?php echo LR\Filters::escapeHtmlAttr($name) /* line 102 */ ?>[is_right]"<?php
					if ($answer[0]['is_right']==1) {
						?>checked="true"<?php
					}
?>

                                   id="<?php echo LR\Filters::escapeHtmlAttr($id) /* line 103 */ ?>is_right" title="Označit odpověď jako správnou">
                            <label> Správná odpověď </label>
                            <button type="button" data-answerid="<?php echo LR\Filters::escapeHtmlAttr($answerBoxId) /* line 105 */ ?>"
                                   class="addRemoveAnswerEvent ico-button" title="Odebrat odpověď"> 
                                <span class='fa fa-trash-o'<<?php ?>/span>
                            </button>
                        </div>
<?php
					$iterations++;
				}
				array_pop($this->global->its);
				$iterator = end($this->global->its);
				?>                    <button type="button" class="addAnswerEvent ico-button ico-button-small" data-partname="questions[<?php
				echo LR\Filters::escapeHtmlAttr($questionCounter) /* line 111 */ ?>]"
                           data-idname="frm-testForm-questions-<?php echo LR\Filters::escapeHtmlAttr($questionCounter) /* line 112 */ ?>" title="Přidat odpověď">
                        <span class='fa fa-plus'></span>
                    </button>
                </div>
                <input type="hidden" name="questions[<?php echo LR\Filters::escapeHtmlAttr($questionCounter) /* line 116 */ ?>][questions_id]" value="<?php
				echo LR\Filters::escapeHtmlAttr($question['questions_id']) /* line 116 */ ?>">
            </div> 
<?php
				$iterations++;
			}
			array_pop($this->global->its);
			$iterator = end($this->global->its);
		}
?>
    
    <button type="button" id="btn" class='smallButton'><span class='fa fa-plus'> Přidat otázku</span></button>
    
  </div>  
    <?php echo end($this->global->formsStack)["send"]->getControl() /* line 124 */ ?>

<?php
		echo Nette\Bridges\FormsLatte\Runtime::renderFormEnd(array_pop($this->global->formsStack));
?>

<?php
		$this->global->snippetDriver->leave();
		
	}


	function blockSection($_args)
	{
		extract($_args);
		$this->global->snippetDriver->enter("section", "static");
		echo end($this->global->formsStack)["sections_id"]->getControl() /* line 30 */;
		$this->global->snippetDriver->leave();
		
	}


	function blockJsCallback($_args)
	{
		extract($_args);
?>
<script>
    
$('#' + <?php echo LR\Filters::escapeJs($control["testForm"][$input]->htmlId) /* line 133 */ ?>).on('change', function() {
    $.nette.ajax({
        type: 'GET',
        url: <?php echo LR\Filters::escapeJs($this->global->uiControl->link("{$link}!")) ?>,
        data: {
            'value': $(this).val(),
        }
    });
});

</script>
<?php
	}

}
