<?php
// source: D:\WWW\web-portal-slozeny\app\FrontModule\presenters/templates/Rank/show.latte

use Latte\Runtime as LR;

class Templateff596a8682 extends Latte\Runtime\Template
{
	public $blocks = [
		'myCss' => 'blockMyCss',
		'content' => 'blockContent',
	];

	public $blockTypes = [
		'myCss' => 'html',
		'content' => 'html',
	];


	function main()
	{
		extract($this->params);
		if ($this->getParentName()) return get_defined_vars();
		$this->renderBlock('myCss', get_defined_vars());
		$this->renderBlock('content', get_defined_vars());
		return get_defined_vars();
	}


	function prepare()
	{
		extract($this->params);
		if (isset($this->params['rank'])) trigger_error('Variable $rank overwritten in foreach on line 13');
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}


	function blockMyCss($_args)
	{
		extract($_args);
		?><link rel="stylesheet" href="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 2 */ ?>/css/content.css">	
<?php
	}


	function blockContent($_args)
	{
		extract($_args);
		/* line 5 */ $_tmp = $this->global->uiControl->getComponent("breadcrumb");
		if ($_tmp instanceof Nette\Application\UI\IRenderable) $_tmp->redrawControl(NULL, FALSE);
		$_tmp->render();
?>
<div class="center-div">
    <table class="rank-table stripped-table center">
        <tr>
            <th>Pořadí</th>
            <th>Jméno</th>
            <th>Počet bodů</th>
        </tr>
<?php
		$iterations = 0;
		foreach ($ranks as $rank) {
?>        <tr>
            <?php
			$rankNumber = $rank->better == 0 && $rank->same == 0 ? '1.' : $rank->same == 1 ? ($rank->better + 1).'.' : ($rank->better + 1) . '-' . ($rank->better + $rank->same) . '.';
?>

            <td><?php echo LR\Filters::escapeHtmlText($rankNumber) /* line 15 */ ?></td>
            <td><?php echo LR\Filters::escapeHtmlText($rank->username) /* line 16 */ ?></td>
            <td><?php echo LR\Filters::escapeHtmlText($rank->points) /* line 17 */ ?></td>
        </tr>
<?php
			$iterations++;
		}
?>
    </table>
</div>
<div class="paginationWrapper">
<?php
		/* line 22 */ $_tmp = $this->global->uiControl->getComponent("paginator");
		if ($_tmp instanceof Nette\Application\UI\IRenderable) $_tmp->redrawControl(NULL, FALSE);
		$_tmp->render();
?>
</div>
<?php
	}

}
