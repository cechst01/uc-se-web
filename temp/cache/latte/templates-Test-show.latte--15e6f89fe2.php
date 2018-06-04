<?php
// source: D:\WWW\web-portal-slozeny\app\FrontModule\presenters/templates/Test/show.latte

use Latte\Runtime as LR;

class Template15e6f89fe2 extends Latte\Runtime\Template
{
	public $blocks = [
		'myCss' => 'blockMyCss',
		'title' => 'blockTitle',
		'content' => 'blockContent',
	];

	public $blockTypes = [
		'myCss' => 'html',
		'title' => 'html',
		'content' => 'html',
	];


	function main()
	{
		extract($this->params);
		if ($this->getParentName()) return get_defined_vars();
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
		if (isset($this->params['answer'])) trigger_error('Variable $answer overwritten in foreach on line 25');
		if (isset($this->params['question'])) trigger_error('Variable $question overwritten in foreach on line 15');
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}


	function blockMyCss($_args)
	{
		extract($_args);
		?>    <link rel="stylesheet" href="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 2 */ ?>/css/content.css">	
<?php
	}


	function blockTitle($_args)
	{
		extract($_args);
		?>    Test - <?php echo LR\Filters::escapeHtmlText($test['name']) /* line 6 */ ?>

<?php
	}


	function blockContent($_args)
	{
		extract($_args);
		$letters = ['A','B','C','D','E','F','G','H'];
		;
		/* line 11 */ $_tmp = $this->global->uiControl->getComponent("breadcrumb");
		if ($_tmp instanceof Nette\Application\UI\IRenderable) $_tmp->redrawControl(NULL, FALSE);
		$_tmp->render();
		/* line 12 */ $_tmp = $this->global->uiControl->getComponent("helpControl");
		if ($_tmp instanceof Nette\Application\UI\IRenderable) $_tmp->redrawControl(NULL, FALSE);
		$_tmp->render();
		?><h1><?php echo LR\Filters::escapeHtmlText($test['name']) /* line 13 */ ?></h1>
<?php
		/* line 14 */
		echo Nette\Bridges\FormsLatte\Runtime::renderFormBegin($form = $_form = $this->global->formsStack[] = $this->global->uiControl["resultForm"], []);
?>

<?php
		$iterations = 0;
		foreach ($iterator = $this->global->its[] = new LR\CachingIterator($test['questions']) as $question) {
			$upper = $iterator->counter;
?>
        <div class="question">
            <strong class="question-text"><?php echo LR\Filters::escapeHtmlText($iterator->counter .'. '.$question['question']) /* line 18 */ ?></strong>

<?php
			if ($question['picture']) {
?>
                <div>
                <img src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 22 */ ?>/<?php
				echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($question['picture']['url'])) /* line 22 */ ?>" alt="<?php
				echo LR\Filters::escapeHtmlAttr($question['picture']['alt']) /* line 22 */ ?>">
                </div>
<?php
			}
			$iterations = 0;
			foreach ($iterator = $this->global->its[] = new LR\CachingIterator($question['answers']) as $answer) {
?>
                <div class="answer">
                    <?php echo LR\Filters::escapeHtmlText($letters[$iterator->counter-1].') ') /* line 27 */ ?>

                    <input type='checkbox' name="<?php echo LR\Filters::escapeHtmlAttr($upper-1) /* line 28 */ ?>-<?php
				echo LR\Filters::escapeHtmlAttr($iterator->counter) /* line 28 */ ?>">
<?php
				Tracy\Debugger::barDump(($answer), '$answer');
				if ($answer[1]) {
					?>                        <pre><?php echo LR\Filters::escapeHtmlText($answer[0]['text']) /* line 31 */ ?></pre>   
<?php
				}
				else {
					?>                        <?php echo LR\Filters::escapeHtmlText($answer[0]['text']) /* line 33 */ ?>

<?php
				}
?>
                    
                </div>   
<?php
				$iterations++;
			}
			array_pop($this->global->its);
			$iterator = end($this->global->its);
?>
        </div>

<?php
			$iterations++;
		}
		array_pop($this->global->its);
		$iterator = end($this->global->its);
?>

        <input type="hidden" name='tests_id' value="<?php echo LR\Filters::escapeHtmlAttr($test['tests_id']) /* line 42 */ ?>">
    <div class="button-wrapper">
    <?php echo end($this->global->formsStack)["send"]->getControl() /* line 44 */ ?>

    </div>
<?php
		echo Nette\Bridges\FormsLatte\Runtime::renderFormEnd(array_pop($this->global->formsStack));
		
	}

}
