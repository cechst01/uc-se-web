<?php
// source: D:\WWW\web-portal-slozeny\app\components/templates/menu.latte

use Latte\Runtime as LR;

class Template5e55019ac0 extends Latte\Runtime\Template
{
	public $blocks = [
		'menu' => 'blockMenu',
	];

	public $blockTypes = [
		'menu' => 'html',
	];


	function main()
	{
		extract($this->params);
?>

<?php
		if ($this->getParentName()) return get_defined_vars();
		$this->renderBlock('menu', get_defined_vars());
		return get_defined_vars();
	}


	function prepare()
	{
		extract($this->params);
		if (isset($this->params['item'])) trigger_error('Variable $item overwritten in foreach on line 3');
		if (isset($this->params['category'])) trigger_error('Variable $category overwritten in foreach on line 3');
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}


	function blockMenu($_args)
	{
		extract($_args);
		$iterations = 0;
		foreach ($iterator = $this->global->its[] = new LR\CachingIterator($categories) as $item => $category) {
			if ($category['subcategories']) {
				?>        <li class="category"><span><?php echo LR\Filters::escapeHtmlText(call_user_func($this->filters->firstupper, $category['category']['name'])) /* line 5 */ ?> </span><i class="fa fa-angle-down"></i>
            <ul class="subcategories">
<?php
				$this->renderBlock('menu', ['categories' => $category['subcategories']] + get_defined_vars(), 'html');
?>
            </ul>
        </li>
<?php
			}
			else {
?>
        <li  class='category'> 
<?php
				if ($category['category']['url'] !== '') {
					if (isset($menuArray[$category['category']['url']])) {
						$url = $menuArray[$category['category']['url']];
					}
					else {
						$url = '';
					}
					if (strpos($category['category']['url'],'www') !== false) {
						?>                   <a href="//<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl(call_user_func($this->filters->url, $category['category']['url']))) /* line 19 */ ?>" target="_blank">
                       <?php echo LR\Filters::escapeHtmlText(call_user_func($this->filters->firstupper, $category['category']['name'])) /* line 20 */ ?> <span class=" external-link fa fa-external-link"></span>
                   </a>                      
<?php
					}
					else {
						if ($url) {
							?>                 <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiPresenter->link($url)) ?>"><?php
							echo LR\Filters::escapeHtmlText(call_user_func($this->filters->firstupper, $category['category']['name'])) /* line 24 */ ?></a> 
<?php
						}
					}
				}
				else {
					?>            <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiPresenter->link(":Front:Section:default", [$category['category']['categories_id']])) ?>"><?php
					echo LR\Filters::escapeHtmlText(call_user_func($this->filters->firstupper, $category['category']['name'])) /* line 28 */ ?></a>
<?php
				}
?>
        </li>
<?php
			}
			$iterations++;
		}
		array_pop($this->global->its);
		$iterator = end($this->global->its);
		
	}

}
