<?php
// source: D:\WWW\web-portal-slozeny\app\FrontModule\presenters/templates/Forum/threads.latte

use Latte\Runtime as LR;

class Template1bbeff8857 extends Latte\Runtime\Template
{
	public $blocks = [
		'myCss' => 'blockMyCss',
		'title' => 'blockTitle',
		'content' => 'blockContent',
	];

	public $blockTypes = [
		'myCss' => 'html',
		'title' => 'html',
		'content' => 'html',
	];


	function main()
	{
		extract($this->params);
?>

<?php
		if ($this->getParentName()) return get_defined_vars();
		$this->renderBlock('myCss', get_defined_vars());
?>

<?php
		$this->renderBlock('title', get_defined_vars());
?>

<?php
		$this->renderBlock('content', get_defined_vars());
		return get_defined_vars();
	}


	function prepare()
	{
		extract($this->params);
		if (isset($this->params['thread'])) trigger_error('Variable $thread overwritten in foreach on line 32');
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}


	function blockMyCss($_args)
	{
		extract($_args);
		?>    <link rel="stylesheet" href="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 3 */ ?>/css/forum.css">	
<?php
	}


	function blockTitle($_args)
	{
		extract($_args);
		?>    Kategorie fóra - <?php echo LR\Filters::escapeHtmlText($category->name) /* line 7 */ ?>

<?php
	}


	function blockContent($_args)
	{
		extract($_args);
		/* line 11 */ $_tmp = $this->global->uiControl->getComponent("breadcrumb");
		if ($_tmp instanceof Nette\Application\UI\IRenderable) $_tmp->redrawControl(NULL, FALSE);
		$_tmp->render();
		?><h2 class="margin-bottom-20"><?php echo LR\Filters::escapeHtmlText($category->name) /* line 12 */ ?></h2>
<?php
		if ($user->isLoggedIn()) {
			?>    <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Forum:manageThread", [$categoryId])) ?>" class='add hover'><span class='fa fa-plus'> Přidat vlákno</span></a>
<?php
		}
		if ($threads) {
?>
    <table class="threads-table stripped-table">
        <tr>
            <th>
                Vlákno:
            </th>
            <th>
                Autor:
            </th>
            <th>
                Počet příspěvků:
            </th>
            <th>
                Poslední příspěvek:
            </th>         
        </tr>
<?php
			$iterations = 0;
			foreach ($threads as $thread) {
				$posts = $thread->related('posts');
				$postsCount = $posts->count();
				$lastPost = $posts->max('created_at');
?>
        <tr>
            <td>
                <h3><a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Forum:posts", [$thread->threads_id])) ?>"><?php
				echo LR\Filters::escapeHtmlText($thread->name) /* line 38 */ ?></a></h3>
            </td>
            <td>
                <?php echo LR\Filters::escapeHtmlText($thread->users->username) /* line 41 */ ?>

            </td>
            <td>
                <?php echo LR\Filters::escapeHtmlText($postsCount) /* line 44 */ ?>

            </td>

            <td>
                <?php echo LR\Filters::escapeHtmlText(call_user_func($this->filters->date, $lastPost, 'd. m. Y H:i:s')) /* line 48 */ ?>

            </td>     
            
<?php
				if ($user->id == $thread->users_id) {
?>
                    <td>
                        <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("deleteThread!", [$thread->threads_id])) ?>" title="Smazat vlákno"
                        class="confirm ico-button">
                            <span class="fa fa-trash-o"></span>
                        </a>
                        <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Forum:manageThread", [$categoryId, $thread->threads_id])) ?>"
                        class='ico-button' title='Editovat vlákno'>
                            <span class='fa fa-pencil'></span>
                        </a> 
                    </td> 
<?php
				}
?>
            

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
        <h2 class='empty'> <i class ='fa fa-frown-o'></i> Kategorie je bohužel prázdná.</h2>
    </div>
<?php
		}
?>
<div class="paginationWrapper">
<?php
		/* line 74 */ $_tmp = $this->global->uiControl->getComponent("pagination");
		if ($_tmp instanceof Nette\Application\UI\IRenderable) $_tmp->redrawControl(NULL, FALSE);
		$_tmp->render();
?>
</div>
<?php
	}

}
