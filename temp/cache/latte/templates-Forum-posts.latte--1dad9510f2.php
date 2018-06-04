<?php
// source: D:\WWW\web-portal-slozeny\app\FrontModule\presenters/templates/Forum/posts.latte

use Latte\Runtime as LR;

class Template1dad9510f2 extends Latte\Runtime\Template
{
	public $blocks = [
		'myScripts' => 'blockMyScripts',
		'title' => 'blockTitle',
		'myCss' => 'blockMyCss',
		'content' => 'blockContent',
	];

	public $blockTypes = [
		'myScripts' => 'html',
		'title' => 'html',
		'myCss' => 'html',
		'content' => 'html',
	];


	function main()
	{
		extract($this->params);
		if ($this->getParentName()) return get_defined_vars();
		$this->renderBlock('myScripts', get_defined_vars());
?>

<?php
		$this->renderBlock('title', get_defined_vars());
?>

<?php
		$this->renderBlock('myCss', get_defined_vars());
?>

<?php
		$this->renderBlock('content', get_defined_vars());
		return get_defined_vars();
	}


	function prepare()
	{
		extract($this->params);
		if (isset($this->params['post'])) trigger_error('Variable $post overwritten in foreach on line 25');
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}


	function blockMyScripts($_args)
	{
		extract($_args);
		?>     <script src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 2 */ ?>/tinymce/js/tinymce/tinymce.min.js"></script>
     <script src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 3 */ ?>/js/front/forum-mce.js"></script>
<?php
	}


	function blockTitle($_args)
	{
		extract($_args);
		?>    Vlákno - <?php echo LR\Filters::escapeHtmlText($thread->name) /* line 7 */ ?>

<?php
	}


	function blockMyCss($_args)
	{
		extract($_args);
		?>    <link rel="stylesheet" href="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 11 */ ?>/css/forum.css">	
<?php
	}


	function blockContent($_args)
	{
		extract($_args);
?>

<?php
		/* line 16 */ $_tmp = $this->global->uiControl->getComponent("breadcrumb");
		if ($_tmp instanceof Nette\Application\UI\IRenderable) $_tmp->redrawControl(NULL, FALSE);
		$_tmp->render();
?>

<div class="posts table-space10">
    <h2 class="margin-bottom-20"><?php echo LR\Filters::escapeHtmlText($thread->name) /* line 19 */ ?></h2>
<?php
		if (!$posts) {
?>
    <div class='emptyContainer'>
        <h2 class='empty'> <i class ='fa fa-frown-o'></i> Vlákno je bohužel prázdné.</h2>
    </div>
<?php
		}
		$iterations = 0;
		foreach ($posts as $post) {
			$author = $post->users;
			$profile = $author->ref('profiles','users_id');
			$picture = $profile->ref('pictures','pictures_id');
			?><div class='post-wrapper code-wrapper' data-url="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link(":Front:Tutorial:test")) ?>">
    <table>
        <tr>
            <td rowspan='2'>
                <img src='<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 33 */ ?>/<?php
			echo LR\Filters::escapeHtmlAttr($picture->url) /* line 33 */ ?>' class="avatar" alt="<?php echo LR\Filters::escapeHtmlAttr($picture->alt) /* line 33 */ ?>">
                <h4 class='center'><?php echo LR\Filters::escapeHtmlText($author->username) /* line 34 */ ?></h4>
            </td>
            <td>            
                <?php echo $post->content /* line 37 */ ?>

            </td>
        </tr> 
       <tr>        
        <td>
            Vloženo: <?php echo LR\Filters::escapeHtmlText(call_user_func($this->filters->date, $post->created_at, 'd. m. Y H.i:s')) /* line 42 */ ?>

            
<?php
			if (($user->id == $author->users_id)) {
				?>                <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("managePost!", [$post->post_id])) ?>" title='Editovat příspěvek'
                   class='ico action-button'>
                    <span class='fa fa-edit'></span>
                </a> 
                <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("deletePost!", [$post->post_id])) ?>" 
                   class="confirm ico action-button" title='Smazat příspěvek'>
                    <span class='fa fa-trash-o'></span>
                </a>
<?php
			}
			if ($user->isLoggedIn() && $user->id != $post->users_id) {
				?>            <span data-re="<?php echo LR\Filters::escapeHtmlAttr($author->username) /* line 55 */ ?>"
                  class="re fa fa-comment-o ico action-button" title='Reagovat'></span>
<?php
			}
?>
        </td>
    </tr>   
    </table>
  </div>
<?php
			$iterations++;
		}
?>


<?php
		if ($thread->locked == 0 && $user->isLoggedIn()) {
?>
    <div class="mce-form-wrapper margin-top-20">
<?php
			/* line 67 */ $_tmp = $this->global->uiControl->getComponent("postForm");
			if ($_tmp instanceof Nette\Application\UI\IRenderable) $_tmp->redrawControl(NULL, FALSE);
			$_tmp->render();
?>
    </div>
    
       
<?php
		}
?>
</div>
<?php
	}

}
