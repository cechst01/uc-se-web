<?php
// source: D:\WWW\web-portal-slozeny\app\FrontModule\presenters/templates/Profile/manage.latte

use Latte\Runtime as LR;

class Templatec0c395e935 extends Latte\Runtime\Template
{
	public $blocks = [
		'title' => 'blockTitle',
		'content' => 'blockContent',
	];

	public $blockTypes = [
		'title' => 'html',
		'content' => 'html',
	];


	function main()
	{
		extract($this->params);
		if ($this->getParentName()) return get_defined_vars();
		$this->renderBlock('title', get_defined_vars());
		$this->renderBlock('content', get_defined_vars());
		return get_defined_vars();
	}


	function prepare()
	{
		extract($this->params);
		if (isset($this->params['error'])) trigger_error('Variable $error overwritten in foreach on line 17');
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}


	function blockTitle($_args)
	{
?>    Úprava profilu
<?php
	}


	function blockContent($_args)
	{
		extract($_args);
		/* line 5 */ $_tmp = $this->global->uiControl->getComponent("breadcrumb");
		if ($_tmp instanceof Nette\Application\UI\IRenderable) $_tmp->redrawControl(NULL, FALSE);
		$_tmp->render();
?>
<h2> 
<?php
		if ($user->isInRole('admin')&& $profile->users_id != $user->id) {
			?>        Úprava profilu uživatele <?php echo LR\Filters::escapeHtmlText($profile->users->username) /* line 8 */ ?>

<?php
		}
		else {
?>
        Úprava mého profilu 
<?php
		}
?>
   
</h2>
  
<?php
		/* line 15 */
		echo Nette\Bridges\FormsLatte\Runtime::renderFormBegin($form = $_form = $this->global->formsStack[] = $this->global->uiControl["profileForm"], []);
?>

<?php
		if ($form->hasErrors()) {
?>    <ul class="form-error">
<?php
			$iterations = 0;
			foreach ($form->errors as $error) {
				?>        <li><?php echo LR\Filters::escapeHtmlText($error) /* line 17 */ ?></li>
<?php
				$iterations++;
			}
?>
    </ul>
<?php
		}
?>
    <div class="inputs-200 table-space10">
        <table>
            <tr>
                <td>Aktuální obrázek:</td>
                <td><?php
		/* line 23 */ $_tmp = $this->global->uiControl->getComponent("picture");
		if ($_tmp instanceof Nette\Application\UI\IRenderable) $_tmp->redrawControl(NULL, FALSE);
		$_tmp->render();
?></td>
            </tr>
            <tr>
                <td><?php if ($_label = end($this->global->formsStack)["photo"]->getLabel()) echo $_label ?></td>
                <td><?php echo end($this->global->formsStack)["photo"]->getControl() /* line 27 */ ?></td>
            </tr>
            <tr>
                <td><?php if ($_label = end($this->global->formsStack)["about_me"]->getLabel()) echo $_label ?></td>
                <td><?php echo end($this->global->formsStack)["about_me"]->getControl() /* line 31 */ ?></td>
            </tr>
            <tr>
                <td><?php if ($_label = end($this->global->formsStack)["motto"]->getLabel()) echo $_label ?></td>
                <td><?php echo end($this->global->formsStack)["motto"]->getControl() /* line 35 */ ?></td>
            </tr>
            <tr>
                <td><?php if ($_label = end($this->global->formsStack)["sex"]->getLabel()) echo $_label ?></td>
                <td><?php echo end($this->global->formsStack)["sex"]->getControl() /* line 39 */ ?></td>
            </tr>
            <tr>
                <td><?php if ($_label = end($this->global->formsStack)["address"]->getLabel()) echo $_label ?></td>
                <td><?php echo end($this->global->formsStack)["address"]->getControl() /* line 43 */ ?></td>
            </tr>
            <tr>
                <td><?php if ($_label = end($this->global->formsStack)["www"]->getLabel()) echo $_label ?></td>
                <td><?php echo end($this->global->formsStack)["www"]->getControl() /* line 47 */ ?></td>
            </tr> 
        </table>
            <?php echo end($this->global->formsStack)["send"]->getControl() /* line 50 */ ?>

    </div>
<?php
		echo Nette\Bridges\FormsLatte\Runtime::renderFormEnd(array_pop($this->global->formsStack));
?>

<?php
	}

}
