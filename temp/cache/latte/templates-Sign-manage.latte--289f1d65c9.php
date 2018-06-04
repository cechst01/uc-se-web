<?php
// source: D:\WWW\web-portal-slozeny\app\FrontModule\presenters/templates/Sign/manage.latte

use Latte\Runtime as LR;

class Template289f1d65c9 extends Latte\Runtime\Template
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
		/* line 4 */ $_tmp = $this->global->uiControl->getComponent("changeForm");
		if ($_tmp instanceof Nette\Application\UI\IRenderable) $_tmp->redrawControl(NULL, FALSE);
		$_tmp->render();
		
	}


	function blockTitle($_args)
	{
		extract($_args);
?><h1>Změna údajů</h1>
<?php
	}

}
