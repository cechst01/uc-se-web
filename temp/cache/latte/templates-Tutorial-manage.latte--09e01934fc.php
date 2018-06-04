<?php
// source: D:\WWW\web-portal-slozeny\app\AdminModule\presenters/templates/Tutorial/manage.latte

use Latte\Runtime as LR;

class Template09e01934fc extends Latte\Runtime\Template
{
	public $blocks = [
		'myScripts' => 'blockMyScripts',
		'title' => 'blockTitle',
		'content' => 'blockContent',
		'_wrapper' => 'blockWrapper',
		'_form' => 'blockForm',
		'jsCallback' => 'blockJsCallback',
	];

	public $blockTypes = [
		'myScripts' => 'html',
		'title' => 'html',
		'content' => 'html',
		'_wrapper' => 'html',
		'_form' => 'html',
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
		if (isset($this->params['error'])) trigger_error('Variable $error overwritten in foreach on line 21');
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}


	function blockMyScripts($_args)
	{
		extract($_args);
		?>    <script src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 2 */ ?>/tinymce/js/tinymce/tinymce.min.js"></script>
    <script src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 3 */ ?>/js/admin/tutorial.js"></script>
<?php
	}


	function blockTitle($_args)
	{
?>    Editace tutorialu
<?php
	}


	function blockContent($_args)
	{
		extract($_args);
		/* line 11 */ $_tmp = $this->global->uiControl->getComponent("breadcrumb");
		if ($_tmp instanceof Nette\Application\UI\IRenderable) $_tmp->redrawControl(NULL, FALSE);
		$_tmp->render();
		/* line 12 */ $_tmp = $this->global->uiControl->getComponent("helpControl");
		if ($_tmp instanceof Nette\Application\UI\IRenderable) $_tmp->redrawControl(NULL, FALSE);
		$_tmp->render();
		if (isset($name)) {
			?>    <h2>Úprava tutorialu: <?php echo LR\Filters::escapeHtmlText($name) /* line 14 */ ?></h2>
<?php
		}
		else {
?>
    <h2>Vložení tutorialu</h2>
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
		/* line 19 */
		echo Nette\Bridges\FormsLatte\Runtime::renderFormBegin($form = $_form = $this->global->formsStack[] = $this->global->uiControl["tutorialForm"], []);
?>

<?php
		if ($form->hasErrors()) {
?>    <ul class="form-error">
<?php
			$iterations = 0;
			foreach ($form->errors as $error) {
				?>        <li><?php echo LR\Filters::escapeHtmlText($error) /* line 21 */ ?></li>
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
                <th><th>
             </tr>
             <tr>
                 <td><?php if ($_label = end($this->global->formsStack)["category"]->getLabel()) echo $_label ?></td>
                 <td><?php echo end($this->global->formsStack)["category"]->getControl() /* line 30 */ ?> </td>
             </tr>             
                
            <tr>
                <td><?php if ($_label = end($this->global->formsStack)["sections_id"]->getLabel()) echo $_label ?></td>
                <td><div id="<?php echo htmlSpecialChars($this->global->snippetDriver->getHtmlId('form')) ?>"><?php
		$this->renderBlock('_form', $this->params) ?></div> </td>
            </tr>
            
            <tr>
                <td><?php if ($_label = end($this->global->formsStack)["name"]->getLabel()) echo $_label ?></td>
                <td><?php echo end($this->global->formsStack)["name"]->getControl() /* line 40 */ ?></td>
            </tr>
            
            <tr>
                <td><?php if ($_label = end($this->global->formsStack)["hidden"]->getLabel()) echo $_label ?></td>
                <td><?php echo end($this->global->formsStack)["hidden"]->getControl() /* line 45 */ ?></td>
            </tr>
            
             <tr>
                <td><?php if ($_label = end($this->global->formsStack)["description"]->getLabel()) echo $_label ?></td>
                <td><?php echo end($this->global->formsStack)["description"]->getControl() /* line 50 */ ?></td>
            </tr>            
            
            <tr>
                <td>Aktuální obrázek:</td>
                <td><?php
		/* line 55 */ $_tmp = $this->global->uiControl->getComponent("picture");
		if ($_tmp instanceof Nette\Application\UI\IRenderable) $_tmp->redrawControl(NULL, FALSE);
		$_tmp->render();
?></td>
            </tr>
            
            <tr>
                <td><?php if ($_label = end($this->global->formsStack)["file"]->getLabel()) echo $_label ?></td>
                <td><?php echo end($this->global->formsStack)["file"]->getControl() /* line 60 */ ?></td>
            </tr>
     
         </table>
      </div>

    <div class="tutorial-mce">
      <?php echo end($this->global->formsStack)["content"]->getControl() /* line 67 */ ?>

      <?php echo end($this->global->formsStack)["send"]->getControl() /* line 68 */ ?>

    </div>

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
		echo end($this->global->formsStack)["sections_id"]->getControl() /* line 35 */;
		$this->global->snippetDriver->leave();
		
	}


	function blockJsCallback($_args)
	{
		extract($_args);
?>
<script>
$('#' + <?php echo LR\Filters::escapeJs($control["tutorialForm"][$input]->htmlId) /* line 80 */ ?>).on('change', function() {
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
