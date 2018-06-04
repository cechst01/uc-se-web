<?php
// source: D:\WWW\web-portal-slozeny\app\AdminModule\presenters/templates/Level/manage.latte

use Latte\Runtime as LR;

class Template5ec7fe6fd9 extends Latte\Runtime\Template
{
	public $blocks = [
		'myScripts' => 'blockMyScripts',
		'content' => 'blockContent',
	];

	public $blockTypes = [
		'myScripts' => 'html',
		'content' => 'html',
	];


	function main()
	{
		extract($this->params);
		if ($this->getParentName()) return get_defined_vars();
		$this->renderBlock('myScripts', get_defined_vars());
?>

<?php
		$this->renderBlock('content', get_defined_vars());
		return get_defined_vars();
	}


	function prepare()
	{
		extract($this->params);
		if (isset($this->params['error'])) trigger_error('Variable $error overwritten in foreach on line 8');
		if (isset($this->params['level'])) trigger_error('Variable $level overwritten in foreach on line 10');
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}


	function blockMyScripts($_args)
	{
		extract($_args);
		?>    <script src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 2 */ ?>/js/admin/level.js"></script>
<?php
	}


	function blockContent($_args)
	{
		extract($_args);
		/* line 6 */
		echo Nette\Bridges\FormsLatte\Runtime::renderFormBegin($form = $_form = $this->global->formsStack[] = $this->global->uiControl["levelForm"], []);
?>

<?php
		if ($form->hasErrors()) {
?>    <ul class="form-error">
<?php
			$iterations = 0;
			foreach ($form->errors as $error) {
				?>        <li><?php echo LR\Filters::escapeHtmlText($error) /* line 8 */ ?></li>
<?php
				$iterations++;
			}
?>
    </ul>
<?php
		}
		$iterations = 0;
		foreach ($levels as $level) {
			?>    <div id="<?php echo LR\Filters::escapeHtmlAttr($level->user_level_id) /* line 10 */ ?>" class="user-level">
        <?php
			$id = $level->user_level_id;
?>

        <label>Název:</label
        ><input type="text" value="<?php echo LR\Filters::escapeHtmlAttr($level->name) /* line 13 */ ?>" name="level[<?php
			echo LR\Filters::escapeHtmlAttr($id) /* line 13 */ ?>][name]"
                data-nette-rules='[{"op":":filled","msg":"Musíte vyplnit název úrovně."}]'
       ><label>Limit bodů:</label
        ><input type="number" value="<?php echo LR\Filters::escapeHtmlAttr($level->max_points) /* line 16 */ ?>" name="level[<?php
			echo LR\Filters::escapeHtmlAttr($id) /* line 16 */ ?>][max_points]"
                data-nette-rules='[{"op":":filled","msg":"Vypln to"},{"op":":integer","msg":"Please enter a valid integer."},
                {"op":":min","msg":"Musí být větší než 0","arg":1}]'
       ><button class="ico-button remove-level" type="button"><span class="fa fa-trash-o"></span></button>
    </div>   
<?php
			$iterations++;
		}
?>
    <div>
        <button class="add-level" type="button">Přidat</button>
    </div>
    <?php echo end($this->global->formsStack)["send"]->getControl() /* line 24 */ ?>

<?php
		echo Nette\Bridges\FormsLatte\Runtime::renderFormEnd(array_pop($this->global->formsStack));
?>

<?php
	}

}
