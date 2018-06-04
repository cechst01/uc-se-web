<?php
// source: D:\WWW\web-portal-slozeny\app\FrontModule\presenters/templates/Tutorial/show.latte

use Latte\Runtime as LR;

class Template9ec472fe23 extends Latte\Runtime\Template
{
	public $blocks = [
		'title' => 'blockTitle',
		'myScripts' => 'blockMyScripts',
		'myCss' => 'blockMyCss',
		'content' => 'blockContent',
	];

	public $blockTypes = [
		'title' => 'html',
		'myScripts' => 'html',
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
		$this->renderBlock('myScripts', get_defined_vars());
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
		if (isset($this->params['comment'])) trigger_error('Variable $comment overwritten in foreach on line 35');
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}


	function blockTitle($_args)
	{
		extract($_args);
		?>    Tutorial - <?php echo LR\Filters::escapeHtmlText($tutorial->name) /* line 2 */ ?>

<?php
	}


	function blockMyScripts($_args)
	{
		extract($_args);
		?>    <script src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 6 */ ?>/tinymce/js/tinymce/tinymce.min.js"></script>
    <script src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 7 */ ?>/js/front/tutorial.js"></script>
<?php
	}


	function blockMyCss($_args)
	{
		extract($_args);
		?>    <link rel="stylesheet" href="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 11 */ ?>/css/content.css">	
<?php
	}


	function blockContent($_args)
	{
		extract($_args);
		/* line 15 */ $_tmp = $this->global->uiControl->getComponent("breadcrumb");
		if ($_tmp instanceof Nette\Application\UI\IRenderable) $_tmp->redrawControl(NULL, FALSE);
		$_tmp->render();
		/* line 16 */ $_tmp = $this->global->uiControl->getComponent("helpControl");
		if ($_tmp instanceof Nette\Application\UI\IRenderable) $_tmp->redrawControl(NULL, FALSE);
		$_tmp->render();
		?><h2 class="content-header"><?php echo LR\Filters::escapeHtmlText($tutorial->name) /* line 17 */ ?></h2>
<div class="code-wrapper" data-url="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link(":Front:Tutorial:test")) ?>">
<?php echo $tutorial->content /* line 19 */ ?>

</div>

<div class='toggle-comments'>
        <span class='fa fa-comments toggle-comments-ico'></span>
        <span class='toggle-comments-text'>Zobrazit komentáře</span>
        <span> 
<?php
		if ($comments) {
			?>                (<?php echo LR\Filters::escapeHtmlText(count($comments)) /* line 27 */ ?>)
<?php
		}
		else {
?>
                (0)
<?php
		}
?>
        </span>
</div>

<div<?php if ($_tmp = array_filter(['comments', 'table-space10', $hidden ? 'hidden' : NULL])) echo ' class="', LR\Filters::escapeHtmlAttr(implode(" ", array_unique($_tmp))), '"' ?>>  
<?php
		$iterations = 0;
		foreach ($iterator = $this->global->its[] = new LR\CachingIterator($comments) as $comment) {
			$myUser = $comment->users;
			$profile = $myUser->ref('profiles','users_id');
			$picture = $profile->ref('pictures','pictures_id');
			?>    <div class='comment-wrapper code-wrapper <?php
			if ($iterator->isLast()) {
				?>last<?php
			}
?>'
         data-url="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link(":Front:Tutorial:test")) ?>">
    <table>
    <tr>
        <td rowspan='2'>
            <img src='<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 44 */ ?>/<?php
			echo LR\Filters::escapeHtmlAttr($picture->url) /* line 44 */ ?>' class="avatar" alt="<?php echo LR\Filters::escapeHtmlAttr($picture->alt) /* line 44 */ ?>">
            <h4 class='center'><?php echo LR\Filters::escapeHtmlText($myUser->username) /* line 45 */ ?></h4>
        </td>
        <td>            
            <?php echo $comment->content /* line 48 */ ?>

        </td>
    </tr>       
      
    <tr>        
        <td>
            Vloženo: <?php echo LR\Filters::escapeHtmlText(call_user_func($this->filters->date, $comment->created_at, 'd. m. Y H.i:s')) /* line 54 */ ?>

            
<?php
			if (($user->id == $comment->users_id)) {
				?>                <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("editComment!", [$comment->comments_id])) ?>" title='Editovat komentář'
                   class='ico action-button'>
                    <span class='fa fa-edit'></span>
                </a> 
                <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("deleteComment!", [$comment->comments_id])) ?>" 
                   class="confirm ico action-button" title='Smazat komentář'>
                    <span class='fa fa-trash-o'></span>
                </a>
<?php
			}
			if ($user->isLoggedIn() && $user->id != $comment->users_id) {
				?>            <span data-re="<?php echo LR\Filters::escapeHtmlAttr($myUser->username) /* line 67 */ ?>"
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
		array_pop($this->global->its);
		$iterator = end($this->global->its);
		if ($user->isLoggedIn()) {
?>
    <div class='comment-form-wrapper'>
<?php
			/* line 77 */ $_tmp = $this->global->uiControl->getComponent("commentForm");
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
