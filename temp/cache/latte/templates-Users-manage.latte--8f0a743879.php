<?php
// source: D:\WWW\web-portal-slozeny\app\AdminModule\presenters/templates/Users/manage.latte

use Latte\Runtime as LR;

class Template8f0a743879 extends Latte\Runtime\Template
{
	public $blocks = [
		'content' => 'blockContent',
		'title' => 'blockTitle',
		'_wrapper' => 'blockWrapper',
		'_users' => 'blockUsers',
	];

	public $blockTypes = [
		'content' => 'html',
		'title' => 'html',
		'_wrapper' => 'html',
		'_users' => 'html',
	];


	function main()
	{
		extract($this->params);
		if ($this->getParentName()) return get_defined_vars();
		$this->renderBlock('content', get_defined_vars());
		return get_defined_vars();
	}


	function prepare()
	{
		extract($this->params);
		if (isset($this->params['key'])) trigger_error('Variable $key overwritten in foreach on line 48');
		if (isset($this->params['role'])) trigger_error('Variable $role overwritten in foreach on line 48');
		if (isset($this->params['myuser'])) trigger_error('Variable $myuser overwritten in foreach on line 37');
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}


	function blockContent($_args)
	{
		extract($_args);
		/* line 2 */ $_tmp = $this->global->uiControl->getComponent("breadcrumb");
		if ($_tmp instanceof Nette\Application\UI\IRenderable) $_tmp->redrawControl(NULL, FALSE);
		$_tmp->render();
		$this->renderBlock('title', get_defined_vars());
		?><div id="<?php echo htmlSpecialChars($this->global->snippetDriver->getHtmlId('wrapper')) ?>"><?php $this->renderBlock('_wrapper', $this->params) ?></div><div class="paginationWrapper">
<?php
		/* line 87 */ $_tmp = $this->global->uiControl->getComponent("paginator");
		if ($_tmp instanceof Nette\Application\UI\IRenderable) $_tmp->redrawControl(NULL, FALSE);
		$_tmp->render();
?>
</div>
<script>
       
    $('.changeRole').on('change',function(){
      $.nette.ajax({
        type: 'GET',
        url: <?php echo LR\Filters::escapeJs($this->global->uiControl->link("changeRole!")) ?>,
        data: {
            'userId': $(this).data('id'),
            'roleId': $(this).val()          
        }
      });
    });   
   
</script><?php
	}


	function blockTitle($_args)
	{
		extract($_args);
?><h2>Administrace uživatelů</h2>
<?php
	}


	function blockWrapper($_args)
	{
		extract($_args);
		$this->global->snippetDriver->enter("wrapper", "static");
		$order = ($type == 'DESC') ? 'fa fa-sort-alpha-desc' : 'fa fa-sort-alpha-asc';
		/* line 6 */
		echo Nette\Bridges\FormsLatte\Runtime::renderFormBegin($form = $_form = $this->global->formsStack[] = $this->global->uiControl["usersFilterForm"], []);
?>

    <div class="admin-table-wrapper">
        <table class="stripped-table">
            <tr>
                <th>
                    <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("sortUsers!", ['username', $type])) ?>" class="order-link">Uživatelské jméno</a>
<?php
		if ($sort == 'username') {
			?>                    <span class="order <?php echo LR\Filters::escapeHtmlAttr($order) /* line 12 */ ?>"></span>
<?php
		}
?>
                </th>
                <th>
                    <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("sortUsers!", ['email', $type])) ?>">Email</a>
<?php
		if ($sort == 'email') {
			?>                    <span class="order <?php echo LR\Filters::escapeHtmlAttr($order) /* line 16 */ ?>"></span>
<?php
		}
?>
                </th>
                <th>Role</th>
                <th>Zamčeno/Odemčeno</th>
                <th>Změnit roli</th>
                <th>Akce</th>
            </tr>

            <tr>
                <td><?php echo end($this->global->formsStack)["namesearch"]->getControl() /* line 25 */ ?></td>
                <td><?php echo end($this->global->formsStack)["emailsearch"]->getControl() /* line 26 */ ?></td>
                <td><?php echo end($this->global->formsStack)["role"]->getControl() /* line 27 */ ?></td>
                <td><?php echo end($this->global->formsStack)["lock"]->getControl() /* line 28 */ ?></td>
                <td></td>
                <td>
                <button type="submit" class="ico-button large" title="Filtrovat"><span class="fa fa-filter"></span></button>
                <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("removeFilter!")) ?>" class="ico-button large" title="Zrušit filtr"><span class="fa fa-times"></span></a>
                </td>   
            </tr>

            <tbody<?php echo ' id="' . htmlSpecialChars($this->global->snippetDriver->getHtmlId('users')) . '"' ?>>
<?php $this->renderBlock('_users', $this->params) ?>
            </tbody>    
        </table>
    </div>
<?php
		echo Nette\Bridges\FormsLatte\Runtime::renderFormEnd(array_pop($this->global->formsStack));
?>

<?php
		$this->global->snippetDriver->leave();
		
	}


	function blockUsers($_args)
	{
		extract($_args);
		$this->global->snippetDriver->enter("users", "static");
		?>            <?php
		$iterations = 0;
		foreach ($users as $myuser) {
?>

                <tr>        
                    <td><?php echo LR\Filters::escapeHtmlText($myuser->username) /* line 39 */ ?></td>
                    <td><?php echo LR\Filters::escapeHtmlText($myuser->email) /* line 40 */ ?></td>            
                    <td<?php echo ' id="' . htmlSpecialChars($this->global->snippetDriver->getHtmlId($myuser->users_id)) . '"' ?>><?php
			$this->global->snippetDriver->enter($myuser->users_id, "dynamic");
			echo LR\Filters::escapeHtmlText($myuser->user_role->view_name) /* line 41 */ ?> <?php
			$this->global->snippetDriver->leave();
?></td>
                    <td><?php echo LR\Filters::escapeHtmlText(call_user_func($this->filters->bool, $myuser->locked, 'Zamčeno', 'Odemčeno')) /* line 42 */ ?></td>
                    <td>                
                        <select class='changeRole' data-id="<?php echo LR\Filters::escapeHtmlAttr($myuser->users_id) /* line 44 */ ?>"
<?php
			if ($user->id == $myuser->users_id) {
?>
                                    disabled=""
                                <?php
			}
?>>
<?php
			$iterations = 0;
			foreach ($roles as $key => $role) {
				?>                                <option value="<?php echo LR\Filters::escapeHtmlAttr($key) /* line 49 */ ?>"
<?php
				if ($myuser->user_role_id == $key) {
?>
                                        selected="selected"
                                    <?php
				}
?>>
                                    <?php echo LR\Filters::escapeHtmlText($role) /* line 53 */ ?>

                                </option>
<?php
				$iterations++;
			}
?>
                        </select>
                    </td> 
                    <td>
<?php
			if ($myuser->locked == 0) {
				$class ='fa-lock';
				$text ='Zamčít';
			}
			else {
				$class = 'fa-unlock-alt';
				$text ='Odemčít';
			}
			if ($user->id == $myuser->users_id) {
				?>                        <div class="ico-button-disabled"><span class="fa <?php echo LR\Filters::escapeHtmlAttr($class) /* line 67 */ ?>"></span></div>
                        <div class="ico-button-disabled"><span class="fa fa-trash-o"></span></div>
<?php
			}
			else {
				?>                        <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("toggleLock!", [$myuser->users_id])) ?>" class="ico-button" title="<?php
				echo LR\Filters::escapeHtmlAttr($text) /* line 70 */ ?> účet">
                            <span class="fa <?php echo LR\Filters::escapeHtmlAttr($class) /* line 71 */ ?>"></span>
                    </a>  
                        <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("deleteUser!", [$myuser->users_id])) ?>" class="confirm ico-button" title="Smazat uživatele">
                            <span class="fa fa-trash-o"></span>
                        </a>
<?php
			}
?>

                    </td>
                </tr>
<?php
			$iterations++;
		}
		$this->global->snippetDriver->leave();
		
	}

}
