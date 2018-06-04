<?php
// source: D:\WWW\web-portal-slozeny\app\components/templates/picture.latte

use Latte\Runtime as LR;

class Template3c6b04186e extends Latte\Runtime\Template
{
	public $blocks = [
		'_' => 'block_b14a7',
	];

	public $blockTypes = [
		'_' => 'html',
	];


	function main()
	{
		extract($this->params);
		?><div id="<?php echo htmlSpecialChars($this->global->snippetDriver->getHtmlId('')) ?>"><?php $this->renderBlock('_', $this->params) ?></div><?php
		return get_defined_vars();
	}


	function prepare()
	{
		extract($this->params);
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}


	function block_b14a7($_args)
	{
		extract($_args);
		$this->global->snippetDriver->enter("", "static");
		if (isset($picture)) {
			if ($picture) {
?>
            <div class="padding-5">
                <img src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 5 */ ?>/<?php
				echo LR\Filters::escapeHtmlAttr($picture->url) /* line 5 */ ?>" alt="<?php echo LR\Filters::escapeHtmlAttr($picture->alt) /* line 5 */ ?>">
<?php
				if ($picture->pictures_id > 0) {
					?>                     <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("deletePicture!")) ?>">Smazat </a>
<?php
				}
				else {
?>
                     <div>
                     (Výchozí obrázek) 
                     </div>
<?php
				}
?>
            </div>
<?php
			}
		}
		$this->global->snippetDriver->leave();
		
	}

}
