<?php
// source: D:\WWW\web-portal-slozeny\app\FrontModule\presenters/templates/Sign/in.latte

use Latte\Runtime as LR;

class Template4940c59e3e extends Latte\Runtime\Template
{
	public $blocks = [
		'content' => 'blockContent',
		'title' => 'blockTitle',
	];

	public $blockTypes = [
		'content' => 'html',
		'title' => 'html',
	];


	function main()
	{
		extract($this->params);
		if ($this->getParentName()) return get_defined_vars();
		$this->renderBlock('content', get_defined_vars());
		return get_defined_vars();
	}


	function prepare()
	{
		extract($this->params);
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}


	function blockContent($_args)
	{
		extract($_args);
		/* line 2 */ $_tmp = $this->global->uiControl->getComponent("breadcrumb");
		if ($_tmp instanceof Nette\Application\UI\IRenderable) $_tmp->redrawControl(NULL, FALSE);
		$_tmp->render();
		$this->renderBlock('title', get_defined_vars());
?>
<div class='signWrapper'>
<?php
		/* line 5 */ $_tmp = $this->global->uiControl->getComponent("userBar-sign");
		if ($_tmp instanceof Nette\Application\UI\IRenderable) $_tmp->redrawControl(NULL, FALSE);
		$_tmp->render();
?>
</div>
<?php
	}


	function blockTitle($_args)
	{
		extract($_args);
?><h1>Přihlášení</h1>
<?php
	}

}
