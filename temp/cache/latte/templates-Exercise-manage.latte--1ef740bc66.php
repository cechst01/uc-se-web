<?php
// source: D:\WWW\web-portal-slozeny\app\AdminModule\presenters/templates/Exercise/manage.latte

use Latte\Runtime as LR;

class Template1ef740bc66 extends Latte\Runtime\Template
{
	public $blocks = [
		'myScripts' => 'blockMyScripts',
		'myCss' => 'blockMyCss',
		'title' => 'blockTitle',
		'content' => 'blockContent',
		'_wrapper' => 'blockWrapper',
		'_form' => 'blockForm',
		'jsCallback' => 'blockJsCallback',
	];

	public $blockTypes = [
		'myScripts' => 'html',
		'myCss' => 'html',
		'title' => 'html',
		'content' => 'html',
		'_wrapper' => 'html',
		'_form' => 'html',
		'jsCallback' => 'html',
	];


	function main()
	{
		extract($this->params);
?>

<?php
		if ($this->getParentName()) return get_defined_vars();
		$this->renderBlock('myScripts', get_defined_vars());
?>

<?php
		$this->renderBlock('myCss', get_defined_vars());
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
		if (isset($this->params['error'])) trigger_error('Variable $error overwritten in foreach on line 31');
		if (isset($this->params['type'])) trigger_error('Variable $type overwritten in foreach on line 119');
		if (isset($this->params['condition'])) trigger_error('Variable $condition overwritten in foreach on line 113');
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}


	function blockMyScripts($_args)
	{
		extract($_args);
		?>    <script src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 3 */ ?>/codemirror/lib/codemirror.js"></script>
    <script src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 4 */ ?>/codemirror/mode/javascript/javascript.js"></script>
    <script src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 5 */ ?>/codemirror/mode/xml/xml.js"></script>
    <script src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 6 */ ?>/codemirror/mode/css/css.js"></script>
    <script src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 7 */ ?>/codemirror/mode/htmlmixed/htmlmixed.js"></script>
    <script src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 8 */ ?>/js/admin/exercise.js"></script>
<?php
	}


	function blockMyCss($_args)
	{
		extract($_args);
		?>    <link rel="stylesheet" href="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 12 */ ?>/codemirror/lib/codemirror.css">
    <link rel="stylesheet" href="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 13 */ ?>/codemirror/theme/3024-day.css">
<?php
	}


	function blockTitle($_args)
	{
?>    Editace cvičení
<?php
	}


	function blockContent($_args)
	{
		extract($_args);
		/* line 21 */ $_tmp = $this->global->uiControl->getComponent("breadcrumb");
		if ($_tmp instanceof Nette\Application\UI\IRenderable) $_tmp->redrawControl(NULL, FALSE);
		$_tmp->render();
		/* line 22 */ $_tmp = $this->global->uiControl->getComponent("helpControl");
		if ($_tmp instanceof Nette\Application\UI\IRenderable) $_tmp->redrawControl(NULL, FALSE);
		$_tmp->render();
		if (isset($name)) {
			?>    <h2>Úprava cvičení: <?php echo LR\Filters::escapeHtmlText($name) /* line 24 */ ?></h2>
<?php
		}
		else {
?>
    <h2>Vložení cvičení</h2>
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
		/* line 29 */
		echo Nette\Bridges\FormsLatte\Runtime::renderFormBegin($form = $_form = $this->global->formsStack[] = $this->global->uiControl["exerciseForm"], []);
?>

<?php
		if ($form->hasErrors()) {
?>     <ul class="form-error">
<?php
			$iterations = 0;
			foreach ($form->errors as $error) {
				?>        <li><?php echo LR\Filters::escapeHtmlText($error) /* line 31 */ ?></li>
<?php
				$iterations++;
			}
?>
    </ul>
<?php
		}
?>
    <div class="itemInfosection">
        <table>
            <tr>
                <td><?php if ($_label = end($this->global->formsStack)["category"]->getLabel()) echo $_label ?></td>
                <td><?php echo end($this->global->formsStack)["category"]->getControl() /* line 37 */ ?></td>
            </tr>
            <tr>
                <td><?php if ($_label = end($this->global->formsStack)["sections_id"]->getLabel()) echo $_label ?></td>
                <td><div id="<?php echo htmlSpecialChars($this->global->snippetDriver->getHtmlId('form')) ?>"><?php
		$this->renderBlock('_form', $this->params) ?></div></td>
            </tr>
            <tr>
                <td><?php if ($_label = end($this->global->formsStack)["name"]->getLabel()) echo $_label ?></td>
                <td><?php echo end($this->global->formsStack)["name"]->getControl() /* line 45 */ ?></td>
            </tr>
            <tr>
                <td><?php if ($_label = end($this->global->formsStack)["hidden"]->getLabel()) echo $_label ?></td>
                <td><?php echo end($this->global->formsStack)["hidden"]->getControl() /* line 49 */ ?></td>
            </tr>
            <tr>
                <td><?php if ($_label = end($this->global->formsStack)["description"]->getLabel()) echo $_label ?></td>
                <td><?php echo end($this->global->formsStack)["description"]->getControl() /* line 53 */ ?></td>
            </tr>
            <tr>
                <td><?php if ($_label = end($this->global->formsStack)["task"]->getLabel()) echo $_label ?></td>
                <td><?php echo end($this->global->formsStack)["task"]->getControl() /* line 57 */ ?></td>
            </tr>
            <tr>
                <td><?php if ($_label = end($this->global->formsStack)["points"]->getLabel()) echo $_label ?></td>
                <td><?php echo end($this->global->formsStack)["points"]->getControl() /* line 61 */ ?></td>
            </tr>
            <tr>
                <td>Aktuální obrázek:</td>
                <td><?php
		/* line 65 */ $_tmp = $this->global->uiControl->getComponent("picture");
		if ($_tmp instanceof Nette\Application\UI\IRenderable) $_tmp->redrawControl(NULL, FALSE);
		$_tmp->render();
?></td>
            </tr>
            
            <tr>
                <td><?php if ($_label = end($this->global->formsStack)["file"]->getLabel()) echo $_label ?> </td>
                <td><?php echo end($this->global->formsStack)["file"]->getControl() /* line 70 */ ?></td>
            </tr>
        </table>
    </div>       
      <div class="editorWrapper">
      <?php if ($_label = end($this->global->formsStack)["html_code"]->getLabel()) echo $_label ?>

      <br>
      <?php echo end($this->global->formsStack)["html_code"]->getControl() /* line 77 */ ?>

      </div>
      <div class="editorWrapper">
      <?php if ($_label = end($this->global->formsStack)["css_code"]->getLabel()) echo $_label ?>

      <br>
      <?php echo end($this->global->formsStack)["css_code"]->getControl() /* line 82 */ ?>

      </div>
      <div class="editorWrapper">
      <?php if ($_label = end($this->global->formsStack)["js_code"]->getLabel()) echo $_label ?>

      <br>
      <?php echo end($this->global->formsStack)["js_code"]->getControl() /* line 87 */ ?>

      </div>    
     <div class="conditionsWrapper clear">      
        <table class='tableConditions'>              
             <tr>              
                <th> Selektor: </th>
                <th> Zkontroluj jestli: </th>
                <th> Jaký atribut/vlastnost: </th>   
                <th> Kontrolovaná hodnota: </th>
                <th> Chybová zpráva: </th>
             </tr>

             <tr id="firstCondition" class="condition">

                 <td><div class="label"> <?php if ($_label = end($this->global->formsStack)["selector"]->getLabel()) echo $_label ?></div><?php
		echo end($this->global->formsStack)["selector"]->getControl() /* line 101 */ ?></td>
                <td><div class="label"><?php if ($_label = end($this->global->formsStack)["type"]->getLabel()) echo $_label ?></div><?php
		echo end($this->global->formsStack)["type"]->getControl() /* line 102 */ ?></td>  
                <td><div class="label"><?php if ($_label = end($this->global->formsStack)["property"]->getLabel()) echo $_label ?></div><?php
		echo end($this->global->formsStack)["property"]->getControl() /* line 103 */ ?></td>             
                <td><div class="label"><?php if ($_label = end($this->global->formsStack)["value"]->getLabel()) echo $_label ?></div><?php
		echo end($this->global->formsStack)["value"]->getControl() /* line 104 */ ?></td>
                <td><div class="label"><?php if ($_label = end($this->global->formsStack)["message"]->getLabel()) echo $_label ?></div><?php
		echo end($this->global->formsStack)["message"]->getControl() /* line 105 */ ?></td>
                <td>
                    <button name="remove" class="remove ico-button" title="Odebrat podmínku" type="button">
                        <span class="fa fa-trash-o"></span>
                    </button>
                </td> 
             </tr>
<?php
		if (isset($conditions)) {
			$iterations = 0;
			foreach ($iterator = $this->global->its[] = new LR\CachingIterator($conditions) as $condition) {
				$i = $iterator->counter;
				$name = 'conditions['.$i.']';
?>
                 <tr class='condition'>
                     <td><input type="textbox" name='<?php echo LR\Filters::escapeHtmlAttr($name.'[selector]') /* line 117 */ ?>' value='<?php
				echo LR\Filters::escapeHtmlAttr($condition['selector']) /* line 117 */ ?>' class="selector"></td> 
                     <td><select name='<?php echo LR\Filters::escapeHtmlAttr($name.'[type]') /* line 118 */ ?>' class="type">
<?php
				$iterations = 0;
				foreach ($iterator = $this->global->its[] = new LR\CachingIterator($types) as $type) {
					?>                           <option value="<?php echo LR\Filters::escapeHtmlAttr($iterator->counter-1) /* line 120 */ ?>"<?php
					if ($condition['type'] == $iterator->counter-1) {
?>

                                 selected 
                               <?php
					}
?>>
                               <?php echo LR\Filters::escapeHtmlText($types[$iterator->counter -1]) /* line 123 */ ?>

                           </option>
<?php
					$iterations++;
				}
				array_pop($this->global->its);
				$iterator = end($this->global->its);
?>
                         </select>
                     </td> 
                     <td><input type="textbox" name='<?php echo LR\Filters::escapeHtmlAttr($name.'[property]') /* line 128 */ ?>' 
<?php
				if ($condition['property']) {
					?>                                    value='<?php echo LR\Filters::escapeHtmlAttr($condition['property']) /* line 130 */ ?>'
<?php
				}
				else {
?>
                                    disabled=''
<?php
				}
?>
                                class="property"> </td> 
                     <td><textarea name='<?php echo LR\Filters::escapeHtmlAttr($name.'[value]') /* line 135 */ ?>' class="value"><?php
				echo LR\Filters::escapeHtmlText($condition['value']) /* line 135 */ ?></textarea></td>
                     <td><textarea name='<?php echo LR\Filters::escapeHtmlAttr($name.'[message]') /* line 136 */ ?>' class="message"><?php
				echo LR\Filters::escapeHtmlText($condition['message']) /* line 136 */ ?></textarea></td> 
                     <td>
                          <button name="remove" class="remove ico-button" title="Odebrat podmínku" type="button">
                            <span class="fa fa-trash-o"></span>
                          </button>
                     </td>
                 </tr>
<?php
				$iterations++;
			}
			array_pop($this->global->its);
			$iterator = end($this->global->its);
		}
?>
             
          </table>
        </div>  
        <?php echo end($this->global->formsStack)["send"]->getControl() /* line 148 */ ?>


<?php
		echo Nette\Bridges\FormsLatte\Runtime::renderFormEnd(array_pop($this->global->formsStack));
?>

  
<?php
		$this->global->snippetDriver->leave();
		
	}


	function blockForm($_args)
	{
		extract($_args);
		$this->global->snippetDriver->enter("form", "static");
		echo end($this->global->formsStack)["sections_id"]->getControl() /* line 41 */;
		$this->global->snippetDriver->leave();
		
	}


	function blockJsCallback($_args)
	{
		extract($_args);
?>

<script>

$('#' + <?php echo LR\Filters::escapeJs($control["exerciseForm"][$input]->htmlId) /* line 160 */ ?>).on('change', function() {
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
