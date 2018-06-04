<?php
// source: D:\WWW\web-portal-slozeny\app\FrontModule\presenters/templates/@layout.latte

use Latte\Runtime as LR;

class Template27fc8b9923 extends Latte\Runtime\Template
{
	public $blocks = [
		'scripts' => 'blockScripts',
		'css' => 'blockCss',
		'head' => 'blockHead',
		'_flashes' => 'blockFlashes',
	];

	public $blockTypes = [
		'scripts' => 'html',
		'css' => 'html',
		'head' => 'html',
		'_flashes' => 'html',
	];


	function main()
	{
		extract($this->params);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">        
        <meta name="viewport" content="width=device-width">
<?php
		if ($this->getParentName()) return get_defined_vars();
		$this->renderBlock('scripts', get_defined_vars());
?>
        
<?php
		$this->renderBlock('css', get_defined_vars());
?>
        
       <title>          
            <?php
		if (isset($this->blockQueue["title"])) {
			$this->renderBlock('title', $this->params, function ($s, $type) {
				$_fi = new LR\FilterInfo($type);
				return LR\Filters::convertTo($_fi, 'html', $this->filters->filterContent('striphtml', $_fi, $s));
			});
			?> | <?php
		}
?>

            <?php
		if ($header) {
			echo LR\Filters::escapeHtmlText(call_user_func($this->filters->striptags, $header->content)) /* line 30 */;
		}
?>

        </title>

	<?php
		$this->renderBlock('head', get_defined_vars());
?>
</head>

<body>
    <header class="main-header">
        <h1><?php
		if ($header) {
			?><a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link(":Front:Homepage:")) ?>"><?php
			echo LR\Filters::escapeHtmlText(call_user_func($this->filters->striptags, $header->content)) /* line 38 */ ?></a><?php
		}
?>
</h1>
        <div id="userBarWrapper">
<?php
		/* line 40 */ $_tmp = $this->global->uiControl->getComponent("userBar-head");
		if ($_tmp instanceof Nette\Application\UI\IRenderable) $_tmp->redrawControl(NULL, FALSE);
		$_tmp->render();
?>
        </div>
        
        <nav id="menu"> 
            <ul class="categories">
<?php
		/* line 45 */ $_tmp = $this->global->uiControl->getComponent("menu");
		if ($_tmp instanceof Nette\Application\UI\IRenderable) $_tmp->redrawControl(NULL, FALSE);
		$_tmp->render();
?>
            </ul>
        </nav>      
            
    </header>
<div id="<?php echo htmlSpecialChars($this->global->snippetDriver->getHtmlId('flashes')) ?>"><?php $this->renderBlock('_flashes', $this->params) ?></div>     <div class="content">
<?php
		$this->renderBlock('content', $this->params, 'html');
?>
     </div>
     
     <footer id="main-footer" class="clear">
<?php
		if ($footer) {
			?>            <?php echo LR\Filters::escapeHtmlText(call_user_func($this->filters->striptags, $footer->content)) /* line 59 */ ?>

<?php
		}
?>
     </footer>
	
</body>
</html>
<?php
		return get_defined_vars();
	}


	function prepare()
	{
		extract($this->params);
		if (isset($this->params['flash'])) trigger_error('Variable $flash overwritten in foreach on line 51');
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}


	function blockScripts($_args)
	{
		extract($_args);
?>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
	<script src="https://nette.github.io/resources/js/netteForms.min.js"></script>
         <script src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 13 */ ?>/js/nette.ajax.js"></script>  
        <script src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 14 */ ?>/js/spinner.ajax.js"></script>             
        <script src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 15 */ ?>/js/prism.js"></script>
        <script src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 16 */ ?>/js/main.js"></script>
        <?php
		if (isset($this->blockQueue["myScripts"])) {
			$this->renderBlock('myScripts', $this->params, 'html');
			?> <?php
		}
?>

<?php
	}


	function blockCss($_args)
	{
		extract($_args);
		?>        <link rel="stylesheet" href="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 21 */ ?>/css/prism.css">      
        <link href="https://fonts.googleapis.com/css?family=Arima+Madurai|Roboto+Condensed:300&amp;subset=latin-ext" rel="stylesheet"> 
        <link rel="stylesheet" href="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 23 */ ?>/font-awesome/css/font-awesome.min.css">        
        <?php
		if (isset($this->blockQueue["myCss"])) {
			$this->renderBlock('myCss', $this->params, 'html');
			?> <?php
		}
?>

        <link rel="stylesheet" href="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 25 */ ?>/css/main.css">	
<?php
	}


	function blockHead($_args)
	{
		
	}


	function blockFlashes($_args)
	{
		extract($_args);
		$this->global->snippetDriver->enter("flashes", "static");
		$iterations = 0;
		foreach ($flashes as $flash) {
			?>	<div<?php if ($_tmp = array_filter(['flash', $flash->type])) echo ' class="', LR\Filters::escapeHtmlAttr(implode(" ", array_unique($_tmp))), '"' ?>><?php
			echo LR\Filters::escapeHtmlText($flash->message) /* line 51 */ ?></div>
<?php
			$iterations++;
		}
		$this->global->snippetDriver->leave();
		
	}

}
