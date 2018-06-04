<?php
// source: D:\WWW\web-portal-slozeny\app\components/templates/breadcrumb.latte

use Latte\Runtime as LR;

class Template6e6c2ff446 extends Latte\Runtime\Template
{

	function main()
	{
		extract($this->params);
?>
<nav class="breadcrumb">
    <ul>
<?php
		$iterations = 0;
		foreach ($iterator = $this->global->its[] = new LR\CachingIterator($links) as $link) {
			if (!$iterator->isLast()) {
?>
                <li>                   
                    <a href="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($link[1])) /* line 6 */ ?>" title="<?php
				echo LR\Filters::escapeHtmlAttr($link[2]) /* line 6 */ ?>"><?php echo LR\Filters::escapeHtmlText($link[0]) /* line 6 */ ?></a>                     
                </li>
<?php
			}
			if ($iterator->isLast()) {
?>
                <li>
                <span title="<?php echo LR\Filters::escapeHtmlAttr($link[2]) /* line 11 */ ?>"><?php echo LR\Filters::escapeHtmlText($link[0]) /* line 11 */ ?></span>
                </li>
<?php
			}
			$iterations++;
		}
		array_pop($this->global->its);
		$iterator = end($this->global->its);
?>
    </ul>
</nav><?php
		return get_defined_vars();
	}


	function prepare()
	{
		extract($this->params);
		if (isset($this->params['link'])) trigger_error('Variable $link overwritten in foreach on line 3');
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}

}
