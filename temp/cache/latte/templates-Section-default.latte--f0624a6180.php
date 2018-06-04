<?php
// source: D:\WWW\web-portal-slozeny\app\FrontModule\presenters/templates/Section/default.latte

use Latte\Runtime as LR;

class Templatef0624a6180 extends Latte\Runtime\Template
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
		if (isset($this->params['section'])) trigger_error('Variable $section overwritten in foreach on line 16');
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
		?>    Kategorie - <?php echo LR\Filters::escapeHtmlText($category->name) /* line 6 */ ?>

<?php
	}


	function blockContent($_args)
	{
		extract($_args);
		/* line 10 */ $_tmp = $this->global->uiControl->getComponent("breadcrumb");
		if ($_tmp instanceof Nette\Application\UI\IRenderable) $_tmp->redrawControl(NULL, FALSE);
		$_tmp->render();
		if (!$sections) {
?>
    <div class='emptyContainer'>
        <h2 class='empty'> <i class ='fa fa-frown-o'></i> Kategorie je bohužel prázdná.</h2>
    </div>
<?php
		}
		$iterations = 0;
		foreach ($iterator = $this->global->its[] = new LR\CachingIterator($sections) as $section) {
			?>    <div class="section <?php
			if ($iterator->isLast()) {
				?>last<?php
			}
?> ">
    <h2> <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Section:show", [$section->sections_id])) ?>"><?php
			echo LR\Filters::escapeHtmlText($section->name) /* line 18 */ ?></a></h2>
    <p><?php echo LR\Filters::escapeHtmlText($section->description) /* line 19 */ ?></p>
    </div>
<?php
			$iterations++;
		}
		array_pop($this->global->its);
		$iterator = end($this->global->its);
		
	}

}
