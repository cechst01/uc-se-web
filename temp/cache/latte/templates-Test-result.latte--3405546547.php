<?php
// source: D:\WWW\web-portal-slozeny\app\FrontModule\presenters/templates/Test/result.latte

use Latte\Runtime as LR;

class Template3405546547 extends Latte\Runtime\Template
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
		if (isset($this->params['answer'])) trigger_error('Variable $answer overwritten in foreach on line 38');
		if (isset($this->params['question'])) trigger_error('Variable $question overwritten in foreach on line 26');
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
		?>    Výsledek testu - <?php echo LR\Filters::escapeHtmlText($test['name']) /* line 6 */ ?>

<?php
	}


	function blockContent($_args)
	{
		extract($_args);
		/* line 10 */ $_tmp = $this->global->uiControl->getComponent("breadcrumb");
		if ($_tmp instanceof Nette\Application\UI\IRenderable) $_tmp->redrawControl(NULL, FALSE);
		$_tmp->render();
		$letters = ['A','B','C','D','E','F','G','H'];
		;
		?><h1><?php echo LR\Filters::escapeHtmlText($test['name']) /* line 12 */ ?></h1>

<?php
		if (isset($resultArray)) {
			$markedAnswers = $resultArray['markedAnswers'];
			$rightAnswers = $resultArray['rightAnswers'];
			$points = $resultArray['points'];
			$rightCount = $resultArray['rightCount'];
			$wrongCount = $resultArray['wrongCount'];
			$totalCount = $rightCount + $wrongCount;
?>
    
<?php
		}
?>

<h2 class="result"> Tvoje úspěšnost v tomto testu je: <?php echo LR\Filters::escapeHtmlText(floor($rightCount / $totalCount * 100)) /* line 24 */ ?>%, získáváš <?php
		echo LR\Filters::escapeHtmlText($resultArray['points']) /* line 24 */ ?> bodů.</h2>

<?php
		$iterations = 0;
		foreach ($iterator = $this->global->its[] = new LR\CachingIterator($test['questions']) as $question) {
			$upper = $iterator->counter;
?>
    
    <div class="question">
        <strong class="question-text"><?php echo LR\Filters::escapeHtmlText($iterator->counter .'. '.$question['question']) /* line 30 */ ?></strong> 
        
<?php
			if ($question['picture']) {
?>
            <div>
            <img src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 34 */ ?>/<?php
				echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($question['picture']['url'])) /* line 34 */ ?>" alt="<?php
				echo LR\Filters::escapeHtmlAttr($question['picture']['alt']) /* line 34 */ ?>">
            </div>
<?php
			}
?>

<?php
			$iterations = 0;
			foreach ($iterator = $this->global->its[] = new LR\CachingIterator($question['answers']) as $answer) {
?>
            <div class="answer">
<?php
				if ($markedAnswers[$upper-1][$iterator->counter -1]) {
					?>                <?php echo LR\Filters::escapeHtmlText($letters[$iterator->counter-1].') ') /* line 41 */ ?>

                <input type='checkbox' name="<?php echo LR\Filters::escapeHtmlAttr($upper-1) /* line 42 */ ?>-<?php
					echo LR\Filters::escapeHtmlAttr($iterator->counter) /* line 42 */ ?>" checked='true'>
<?php
					if ($rightAnswers[$upper-1][$iterator->counter -1]) {
						?>                    <b class="green"><?php echo LR\Filters::escapeHtmlText($answer['text']) /* line 44 */ ?>  (tvoje správná odpověď)</b>   
<?php
					}
					else {
						?>                    <b class="red"><?php echo LR\Filters::escapeHtmlText($answer['text']) /* line 46 */ ?>  (tvoje  špatná odpověď)</b>  
<?php
					}
				}
				else {
					?>                <?php echo LR\Filters::escapeHtmlText($letters[$iterator->counter-1].') ') /* line 49 */ ?>

                <input type='checkbox' name="<?php echo LR\Filters::escapeHtmlAttr($upper-1) /* line 50 */ ?>-<?php
					echo LR\Filters::escapeHtmlAttr($iterator->counter) /* line 50 */ ?>">
<?php
					if ($rightAnswers[$upper-1][$iterator->counter -1]) {
						?>                    <span class="gree"><?php echo LR\Filters::escapeHtmlText($answer['text']) /* line 52 */ ?></span> (správná odpověď)
<?php
					}
					else {
						?>                    <?php echo LR\Filters::escapeHtmlText($answer['text']) /* line 54 */ ?>

<?php
					}
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
		
	}

}
