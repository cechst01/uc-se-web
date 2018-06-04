<?php
// source: D:\WWW\web-portal-slozeny\app\FrontModule\presenters/templates/Tutorial/test.latte

use Latte\Runtime as LR;

class Template45519ece42 extends Latte\Runtime\Template
{
	public $blocks = [
		'myScripts' => 'blockMyScripts',
		'myCss' => 'blockMyCss',
		'title' => 'blockTitle',
		'content' => 'blockContent',
	];

	public $blockTypes = [
		'myScripts' => 'html',
		'myCss' => 'html',
		'title' => 'html',
		'content' => 'html',
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
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}


	function blockMyScripts($_args)
	{
		extract($_args);
		?><script src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 3 */ ?>/codemirror/lib/codemirror.js"></script>
<script src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 4 */ ?>/codemirror/mode/javascript/javascript.js"></script>
<script src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 5 */ ?>/codemirror/mode/xml/xml.js"></script>
<script src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 6 */ ?>/codemirror/mode/css/css.js"></script>
<script src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 7 */ ?>/codemirror/mode/htmlmixed/htmlmixed.js"></script>
<script src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 8 */ ?>/js/front/tutorial.js"></script>
<?php
	}


	function blockMyCss($_args)
	{
		extract($_args);
		?>    <link rel="stylesheet" href="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 12 */ ?>/codemirror/theme/3024-day.css"> 
    <link rel="stylesheet" href="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 13 */ ?>/codemirror/lib/codemirror.css">
    <link rel="stylesheet" href="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 14 */ ?>/css/content.css">
<?php
	}


	function blockTitle($_args)
	{
?>    Editor
<?php
	}


	function blockContent($_args)
	{
		extract($_args);
		/* line 22 */ $_tmp = $this->global->uiControl->getComponent("breadcrumb");
		if ($_tmp instanceof Nette\Application\UI\IRenderable) $_tmp->redrawControl(NULL, FALSE);
		$_tmp->render();
?>
<div class="editor-help">
<?php
		/* line 24 */ $_tmp = $this->global->uiControl->getComponent("helpControl");
		if ($_tmp instanceof Nette\Application\UI\IRenderable) $_tmp->redrawControl(NULL, FALSE);
		$_tmp->render();
?>
</div>
<div class='wrapper'>
    <div class='left input-part'>
        <textarea id='area' class='editor'
        ><?php echo LR\Filters::escapeHtmlText($code) /* line 29 */ ?></textarea>       
    </div>
    <div class="small-width">
         <input type='button' value='Vyzkoušet' class='button run'>
    </div>
    <div class="left frameWrapper">
        <iframe id="frame">
        </iframe>    
    </div>
     <div class="normal-width">
         <input type='button' value='Vyzkoušet' class='button run'>
     </div>
</div>
<?php
	}

}
