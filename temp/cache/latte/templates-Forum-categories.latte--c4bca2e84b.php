<?php
// source: D:\WWW\web-portal-slozeny\app\FrontModule\presenters/templates/Forum/categories.latte

use Latte\Runtime as LR;

class Templatec4bca2e84b extends Latte\Runtime\Template
{
	public $blocks = [
		'title' => 'blockTitle',
		'myCss' => 'blockMyCss',
		'content' => 'blockContent',
	];

	public $blockTypes = [
		'title' => 'html',
		'myCss' => 'html',
		'content' => 'html',
	];


	function main()
	{
		extract($this->params);
		if ($this->getParentName()) return get_defined_vars();
		$this->renderBlock('title', get_defined_vars());
?>

<?php
		$this->renderBlock('myCss', get_defined_vars());
		$this->renderBlock('content', get_defined_vars());
		return get_defined_vars();
	}


	function prepare()
	{
		extract($this->params);
		if (isset($this->params['thread'])) trigger_error('Variable $thread overwritten in foreach on line 34');
		if (isset($this->params['category'])) trigger_error('Variable $category overwritten in foreach on line 29');
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}


	function blockTitle($_args)
	{
?>    Fórum
<?php
	}


	function blockMyCss($_args)
	{
		extract($_args);
		?>    <link rel="stylesheet" href="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 6 */ ?>/css/forum.css">	
<?php
	}


	function blockContent($_args)
	{
		extract($_args);
		/* line 9 */ $_tmp = $this->global->uiControl->getComponent("breadcrumb");
		if ($_tmp instanceof Nette\Application\UI\IRenderable) $_tmp->redrawControl(NULL, FALSE);
		$_tmp->render();
?>
<h2 class="margin-bottom-20">Kategorie</h2>
<?php
		Tracy\Debugger::barDump(($categories), '$categories');
		if ($categories) {
?>
    <table class="stripped-table categories-table">
           <tr>
               <th>
                   Kategorie:
               </th>
               <th>
                   Vlákna:
               </th>
               <th>
                   Příspěvky:
               </th>
               <th>
                   Poslední příspěvek:
               </th>
           </tr>

<?php
			$iterations = 0;
			foreach ($categories as $category) {
				$threads = $category->related('threads')->fetchAll();
				$threadsCount = count($threads);
				$postsCount = 0;
				$lastPost = '0-0-0000';
				$iterations = 0;
				foreach ($threads as $thread) {
					$posts = $thread->related('posts');
					$threadLastPost = $posts->max('created_at');
					$lastPost = $lastPost > $threadLastPost ? $lastPost : $threadLastPost;
					$postsCount = $postsCount + $posts->count();
					$iterations++;
				}
?>
         <tr>          
             <td>
               <h3><a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Forum:threads", [$category->forum_categories_id])) ?>"><?php
				echo LR\Filters::escapeHtmlText($category->name) /* line 42 */ ?></a></h3>
               <p><?php echo LR\Filters::escapeHtmlText($category->description) /* line 43 */ ?></p>
             </td>
             <td>
                 <?php echo LR\Filters::escapeHtmlText($threadsCount) /* line 46 */ ?>

             </td>
             <td>
                  <?php echo LR\Filters::escapeHtmlText($postsCount) /* line 49 */ ?>

             </td>      
             <td><?php
				if ($lastPost > '1999-1-1') {
?>

                  <?php echo LR\Filters::escapeHtmlText(call_user_func($this->filters->date, $lastPost, 'd. m. Y H:i:s')) /* line 52 */ ?>

<?php
				}
				else {
?>
                    -
<?php
				}
?>
             </td>         
         </tr>    
<?php
				$iterations++;
			}
?>
   </table>
<?php
		}
		else {
?>
    <div class='emptyContainer'>
        <h2 class='empty'> <i class ='fa fa-frown-o'></i> Fórum je bohužel prázdné.</h2>
    </div>

<?php
		}
?>
    
<?php
	}

}
