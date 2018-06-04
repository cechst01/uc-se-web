<?php
// source: D:\WWW\web-portal-slozeny\app\AdminModule\presenters/templates/Homepage/default.latte

use Latte\Runtime as LR;

class Template38de36cc53 extends Latte\Runtime\Template
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
    <div>
<?php
		if ($user->isInRole('admin')) {
?>        <div class="items-category">
            <h2>Uživatelé:</h2>        
            <div class="admin-menu-item hover">
                <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link(":Admin:Users:manage")) ?>"><span class="fa fa-user"> Administrace uživatelů </span></a>
            </div>
        </div>
<?php
		}
?>
        <div class="items-category">
            <h2>Obsah:</h2>        
            <div class="admin-menu-item hover">
                <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link(":Admin:Tutorial:manage")) ?>"><span class="fa fa-plus"> Přidat tutorial</span></a>
            </div>
             <div class="admin-menu-item hover">
                <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link(":Admin:Tutorials:manage")) ?>"><span class="fa fa-pencil-square-o"> Administrace tutorialů</span></a>
            </div>
            <div class="admin-menu-item hover">
                <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link(":Admin:Exercise:manage")) ?>"><span class="fa fa-plus"> Přidat cvičení</span></a>
            </div>
             <div class="admin-menu-item hover">
                <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link(":Admin:Exercises:manage")) ?>"><span class="fa fa-pencil-square-o"> Administrace cvičení</span></a>
            </div>
            <div class="admin-menu-item hover">
                <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link(":Admin:Test:manage")) ?>"><span class="fa fa-plus"> Přidat test</span></a>
            </div>
             <div class="admin-menu-item hover">
                <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link(":Admin:Tests:manage")) ?>"><span class="fa fa-pencil-square-o"> Administrace testů</span></a>
            </div>
        </div>
<?php
		if ($user->isInRole('admin')) {
?>        <div class="items-category">
            <h2>Portál:</h2>
            <div class="admin-menu-item hover">
                <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link(":Admin:Menu:manage")) ?>"><span class="fa fa-pencil-square-o"> Administrace menu</span></a>
            </div>
             <div class="admin-menu-item hover">
                <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link(":Admin:Sections:manage")) ?>"><span class="fa fa-pencil-square-o"> Administrace sekcí</span></a>
            </div>
            <div class="admin-menu-item hover">
                <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link(":Admin:Text:manage")) ?>"><span class="fa fa-pencil-square-o"> Administrace textů</span></a>
            </div>
        </div>
<?php
		}
		if ($user->isInRole('admin')) {
?>        <div class="items-category">
            <h2>Fórum:</h2>
            <div class="admin-menu-item hover">
                <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link(":Admin:Categories:categoriesManage")) ?>"><span class="fa fa-comments-o"> Administrace fóra</span></a>
            </div>
        </div>
<?php
		}
?>
    </div>

<?php
	}


	function blockTitle($_args)
	{
		extract($_args);
?>    <h1> Administrace </h1>
<?php
	}

}
