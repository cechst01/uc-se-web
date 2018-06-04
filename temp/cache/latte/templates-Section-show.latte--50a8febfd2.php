<?php
// source: D:\WWW\web-portal-slozeny\app\FrontModule\presenters/templates/Section/show.latte

use Latte\Runtime as LR;

class Template50a8febfd2 extends Latte\Runtime\Template
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
		$this->renderBlock('title', get_defined_vars());
		$this->renderBlock('content', get_defined_vars());
		return get_defined_vars();
	}


	function prepare()
	{
		extract($this->params);
		if (isset($this->params['tutorial'])) trigger_error('Variable $tutorial overwritten in foreach on line 19');
		if (isset($this->params['exercise'])) trigger_error('Variable $exercise overwritten in foreach on line 43');
		if (isset($this->params['test'])) trigger_error('Variable $test overwritten in foreach on line 68');
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
		?>    Sekce - <?php echo LR\Filters::escapeHtmlText($section->name) /* line 5 */ ?>

<?php
	}


	function blockContent($_args)
	{
		extract($_args);
		/* line 8 */ $_tmp = $this->global->uiControl->getComponent("breadcrumb");
		if ($_tmp instanceof Nette\Application\UI\IRenderable) $_tmp->redrawControl(NULL, FALSE);
		$_tmp->render();
		if (!$tutorials && !$exercises && !$tests) {
?>
    <div class='emptyContainer'>
    <h2 class='empty'> <i class ='fa fa-frown-o'></i> Sekce je bohužel prázdná.</h2>
    </div>
<?php
		}
		if ($tutorials) {
?>
<div class="itemsWrapper">
<?php
			if ($exercises || $tests) {
?>
        <h2 class="content-center head2">Tutoriály</h2>
<?php
			}
			$iterations = 0;
			foreach ($iterator = $this->global->its[] = new LR\CachingIterator($tutorials) as $tutorial) {
				?>        <table class="itemTable <?php
				if ($iterator->isLast()) {
					?>last<?php
				}
?>">
          <tr>
<?php
				$picture = $tutorial->ref('pictures','pictures_id');
?>
            <td class="itemPictureCell">
<?php
				if (isset($picture->url)) {
					?>                <img src='<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 25 */ ?>/<?php
					echo LR\Filters::escapeHtmlAttr($picture->url) /* line 25 */ ?>'class='itemPicture' alt="<?php echo LR\Filters::escapeHtmlAttr($picture->alt) /* line 25 */ ?>">
<?php
				}
?>
            </td>
            <td>
                <h2><a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Tutorial:show", [$tutorial->tutorials_id])) ?>"><?php
				echo LR\Filters::escapeHtmlText($tutorial->name) /* line 29 */ ?></a></h2>
                <p><?php echo LR\Filters::escapeHtmlText($tutorial->description) /* line 30 */ ?></p>                
            </td>
          <tr>
        </table>
<?php
				$iterations++;
			}
			array_pop($this->global->its);
			$iterator = end($this->global->its);
?>
</div>
<?php
		}
?>

<?php
		if ($exercises) {
?>
<div class="itemsWrapper">
<?php
			if ($tutorials || $tests) {
?>
        <h2 class="content-center head2">Cvičení</h2>
<?php
			}
			$iterations = 0;
			foreach ($iterator = $this->global->its[] = new LR\CachingIterator($exercises) as $exercise) {
				?>        <table class="itemTable <?php
				if ($iterator->isLast()) {
					?>last<?php
				}
?>">            
          <tr>
<?php
				$picture = $exercise->ref('pictures','pictures_id');
?>
            <td class="itemPictureCell">
<?php
				if (isset($picture->url)) {
					?>            <img src='<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 49 */ ?>/<?php
					echo LR\Filters::escapeHtmlAttr($picture->url) /* line 49 */ ?>'class='itemPicture' alt="<?php echo LR\Filters::escapeHtmlAttr($picture->alt) /* line 49 */ ?>">             
<?php
				}
?>
            </td>
            <td>
            <h2><a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Exercise:show", [$exercise->exercises_id])) ?>"><?php
				echo LR\Filters::escapeHtmlText($exercise->name) /* line 53 */ ?></a></h2> 
            <p><?php echo LR\Filters::escapeHtmlText($exercise->description) /* line 54 */ ?></p>   
            </td>
           </tr>
         </table>

<?php
				$iterations++;
			}
			array_pop($this->global->its);
			$iterator = end($this->global->its);
?>
</div>
<?php
		}
?>

<?php
		if ($tests) {
?>
<div class="itemsWrapper">
<?php
			if ($exercises || $tutorials) {
?>
        <h2 class="content-center head2">Testy</h2>
<?php
			}
			$iterations = 0;
			foreach ($iterator = $this->global->its[] = new LR\CachingIterator($tests) as $test) {
				?>        <table class="itemTable <?php
				if ($iterator->isLast()) {
					?>last<?php
				}
?>">
            <tr>
<?php
				$picture = $test->ref('pictures','pictures_id');
?>
                <td class="itemPictureCell"> 
<?php
				if (isset($picture->url)) {
					?>                <img src='<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 74 */ ?>/<?php
					echo LR\Filters::escapeHtmlAttr($picture->url) /* line 74 */ ?>'class='itemPicture' alt="<?php echo LR\Filters::escapeHtmlAttr($picture->alt) /* line 74 */ ?>">    
<?php
				}
?>
                </td> 
                <td>
                <h2><a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Test:show", [$test['tests_id']])) ?>"><?php
				echo LR\Filters::escapeHtmlText($test['name']) /* line 78 */ ?></a></h2>
                <p><?php echo LR\Filters::escapeHtmlText($test['description']) /* line 79 */ ?></p>               
                </td>
            </tr>
        </table>          
<?php
				$iterations++;
			}
			array_pop($this->global->its);
			$iterator = end($this->global->its);
?>
</div>
<?php
		}
		
	}

}
