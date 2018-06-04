<?php
// source: D:\WWW\web-portal-slozeny\app\components/templates/user.latte

use Latte\Runtime as LR;

class Template37ed502326 extends Latte\Runtime\Template
{

	function main()
	{
		extract($this->params);
		if ($user->isLoggedIn()) {
?>
    <div class="wrapper">
        Přihlášený uživatel: <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiPresenter->link(":Front:Profile:show", [$user->id])) ?>"><?php
			echo LR\Filters::escapeHtmlText($user->getIdentity()->getData()['username']) /* line 3 */ ?></a>
    </div>
    <div class="wrapper">
        <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("logout")) ?>">Odhlásit se</a>    
        <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiPresenter->link(":Front:Profile:manage", [$user->id])) ?>">Upravit profil</a>
        <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiPresenter->link(":Front:Sign:manage", [$user->id])) ?>">Změnit údaje</a>
    </div> 
    <div class="wrapper">
<?php
			if ($user->isInRole('admin') || $user->isInRole('editor')) {
				?>           <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiPresenter->link(":Admin:Tutorial:manage")) ?>">Přidat tutoriál</a>
           <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiPresenter->link(":Admin:Exercise:manage")) ?>">Přidat cvičení</a>
           <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiPresenter->link(":Admin:Test:manage")) ?>">Přidat test</a>
<?php
			}
?>
    </div>
    <div class="wrapper">
<?php
			if (($user->isInRole('admin') || $user->isInRole('editor'))) {
				if ($adminModule) {
					$text = 'Administrace';
				}
				else {
					$text = 'Přepnout do administrace';
				}
				?>            <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiPresenter->link(":Admin:Homepage:")) ?>"><?php
				echo LR\Filters::escapeHtmlText($text) /* line 24 */ ?></a>
<?php
			}
?>
    </div>
<?php
		}
		else {
			/* line 28 */ $_tmp = $this->global->uiControl->getComponent("form");
			if ($_tmp instanceof Nette\Application\UI\IRenderable) $_tmp->redrawControl(NULL, FALSE);
			$_tmp->render();
?>
     <div class="wrapper">
        <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiPresenter->link(":Front:Sign:up")) ?>">Registrovat se</a> 
        <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiPresenter->link(":Front:Sign:forgotten")) ?>">Zapomenuté heslo</a> 
     </div>
<?php
		}
?>

<?php
		return get_defined_vars();
	}


	function prepare()
	{
		extract($this->params);
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}

}
