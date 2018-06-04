<?php
// source: D:\WWW\web-portal-slozeny\app\FrontModule\presenters/templates/Profile/show.latte

use Latte\Runtime as LR;

class Template627cbe08ce extends Latte\Runtime\Template
{
	public $blocks = [
		'myCss' => 'blockMyCss',
		'content' => 'blockContent',
		'title' => 'blockTitle',
	];

	public $blockTypes = [
		'myCss' => 'html',
		'content' => 'html',
		'title' => 'html',
	];


	function main()
	{
		extract($this->params);
		if ($this->getParentName()) return get_defined_vars();
		$this->renderBlock('myCss', get_defined_vars());
?>

<?php
		$this->renderBlock('content', get_defined_vars());
		return get_defined_vars();
	}


	function prepare()
	{
		extract($this->params);
		if (isset($this->params['result'])) trigger_error('Variable $result overwritten in foreach on line 60, 75');
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
		/* line 6 */ $_tmp = $this->global->uiControl->getComponent("breadcrumb");
		if ($_tmp instanceof Nette\Application\UI\IRenderable) $_tmp->redrawControl(NULL, FALSE);
		$_tmp->render();
		$profileUser = $profile->users;
		$picture = $profile->ref('pictures','pictures_id');
		$role = $profileUser->role->view_name;
		$level = $profileUser->ref('user_level','user_level_id');
?>
<div class='profile-wrapper'>
    
    <div class="left avatar-wrapper">
        <img src='<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 14 */ ?>/<?php
		echo LR\Filters::escapeHtmlAttr($picture->url) /* line 14 */ ?>' class="profile-avatar" alt="<?php echo LR\Filters::escapeHtmlAttr($picture->alt) /* line 14 */ ?>">
        <div class="level">           
            <strong> Úroveň: </strong> <?php echo LR\Filters::escapeHtmlText($level->name) /* line 16 */ ?>

        </div>
        <div class="points-meter">
            <meter value="<?php echo LR\Filters::escapeHtmlAttr($profileUser->points) /* line 19 */ ?>" min="0" max="<?php
		echo LR\Filters::escapeHtmlAttr($level->max_points + 1) /* line 19 */ ?>"> 
            </meter>
        </div>
        <div class="points">
            <?php echo LR\Filters::escapeHtmlText($profileUser->points) /* line 23 */ ?>/<?php echo LR\Filters::escapeHtmlText($level->max_points + 1) /* line 23 */ ?>

        </div>
        <div>
            <strong>Pořadí: </strong> <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link(":Front:Rank:show")) ?>"><?php
		echo LR\Filters::escapeHtmlText($rank) /* line 26 */ ?></a>
        </div>
    </div>
    
    <div class=' left profile-info'>
<?php
		$this->renderBlock('title', get_defined_vars());
?>
        <div class='profile-one-line'>
            <strong> Moje role: </strong> <?php echo LR\Filters::escapeHtmlText($role) /* line 33 */ ?>

        </div>
        <div class='profile-one-line'>
            <strong> Pohlaví: </strong> <?php echo LR\Filters::escapeHtmlText($sex) /* line 36 */ ?>

        </div>
        <div class='profile-one-line'>
            <strong> Bydliště: </strong> <?php echo LR\Filters::escapeHtmlText($profile->address) /* line 39 */ ?>

        </div>        
        <div class='profile-multi'>
            <strong>Motto:</strong>
            <p><?php echo LR\Filters::escapeHtmlText($profile->motto) /* line 43 */ ?></p>
        </div>
        <div class='profile-multi'>
            <strong>O mě:</strong>
            <p><?php echo LR\Filters::escapeHtmlText($profile->about_me) /* line 47 */ ?></p>
        </div>
        <div class='profile-one-line'>            
            <strong> www: </strong> <a href='//<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl(call_user_func($this->filters->url, $profile->www))) /* line 50 */ ?>' target='blank'><?php
		echo LR\Filters::escapeHtmlText($profile->www) /* line 50 */ ?></a>
        </div>
        
    </div>


</div>
<?php
		if ($testResults) {
?>
    <div class="results left">
        <h3> Výsledky mých testů </h3>
<?php
			$iterations = 0;
			foreach ($testResults as $result) {
				$percent = floor($result->right_count / ($result->right_count + $result->wrong_count) * 100 );
				if ($user->id == $profileUser['users_id']) {
					?>                <a href='<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Test:result", [$result->tests->tests_id])) ?>'><?php
					echo LR\Filters::escapeHtmlText($result->tests->name) /* line 63 */ ?>: <?php echo LR\Filters::escapeHtmlText($percent) /* line 63 */ ?>%</a>
<?php
				}
				else {
					?>                <?php echo LR\Filters::escapeHtmlText($result->tests->name) /* line 65 */ ?>: <?php
					echo LR\Filters::escapeHtmlText($percent) /* line 65 */ ?>%  
<?php
				}
?>
            <br>
<?php
				$iterations++;
			}
?>
    </div>
<?php
		}
?>

<?php
		if ($exerciseResults) {
?>
    <div class="results right">
        <h3> Splněná cvičení </h3>
<?php
			$iterations = 0;
			foreach ($exerciseResults as $result) {
				?>             <?php echo LR\Filters::escapeHtmlText($result->exercises->name) /* line 76 */ ?>

             <br>
<?php
				$iterations++;
			}
?>
    </div>
<?php
		}
		
	}


	function blockTitle($_args)
	{
		extract($_args);
		?>        <h2 class=""><?php echo LR\Filters::escapeHtmlText($profile->users['username']) /* line 31 */ ?></h2>
<?php
	}

}
