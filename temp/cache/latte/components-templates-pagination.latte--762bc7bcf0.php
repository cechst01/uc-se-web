<?php
// source: D:\WWW\web-portal-slozeny\app\components/templates/pagination.latte

use Latte\Runtime as LR;

class Template762bc7bcf0 extends Latte\Runtime\Template
{

	function main()
	{
		extract($this->params);
?>
<nav>
    <ul class="pagination">
        <li<?php if ($_tmp = array_filter([$page <= 1 ? 'disabled' : NULL])) echo ' class="', LR\Filters::escapeHtmlAttr(implode(" ", array_unique($_tmp))), '"' ?>>
            <span><span aria-hidden="true">
<?php
		if ($page > 1) {
			?>                <a href="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($url->setQueryParameter($type, $page - 1)->getAbsoluteUrl())) /* line 7 */ ?>">&laquo;</a>
<?php
		}
		else {
?>
                &laquo;
<?php
		}
?>
            </span></span>
        </li>

<?php
		if ($left > 1) {
?>        <li>
            <span><a href="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($url->setQueryParameter($type, 1)->getAbsoluteUrl())) /* line 16 */ ?>">1</a></span>
        </li>
<?php
		}
?>

<?php
		if ($left > 2) {
?>        <li class="disabled">
            <span>&hellip;</span>
        </li>
<?php
		}
?>

<?php
		for ($i = $left;
		$i <= $right;
		$i++) {
			?>        <li<?php if ($_tmp = array_filter([$i == $page ? 'active' : NULL])) echo ' class="', LR\Filters::escapeHtmlAttr(implode(" ", array_unique($_tmp))), '"' ?>>
            <?php
			if ($i == $page) {
				?>                <span><?php echo LR\Filters::escapeHtmlText($i) /* line 27 */ ?></span>
<?php
			}
			else {
				?>                <a href="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($url->setQueryParameter($type, $i)->getAbsoluteUrl())) /* line 29 */ ?>"><?php
				echo LR\Filters::escapeHtmlText($i) /* line 29 */ ?></a>
<?php
			}
?>
        </li>
<?php
		}
?>

<?php
		if ($right < $pages - 1) {
?>        <li class="disabled">
            <span>&hellip;</span>
        </li>
<?php
		}
?>

<?php
		if ($right < $pages) {
?>        <li>
            <span><a href="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($url->setQueryParameter($type, $pages)->getAbsoluteUrl())) /* line 40 */ ?>"><?php
			echo LR\Filters::escapeHtmlText($pages) /* line 40 */ ?></a></span>
        </li>
<?php
		}
?>

        <li<?php if ($_tmp = array_filter([$page >= $pages ? 'disabled' : NULL])) echo ' class="', LR\Filters::escapeHtmlAttr(implode(" ", array_unique($_tmp))), '"' ?>>
            <span><span aria-hidden="true">
<?php
		if ($page < $pages) {
			?>                <a href="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($url->setQueryParameter($type, $page + 1)->getAbsoluteUrl())) /* line 47 */ ?>">&raquo;</a>
<?php
		}
		else {
?>
                &raquo;
<?php
		}
?>
            </span></span>
        </li>
    </ul>
</nav>
            <?php
		return get_defined_vars();
	}


	function prepare()
	{
		extract($this->params);
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}

}
