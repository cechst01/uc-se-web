<?php
// source: D:\WWW\web-portal-slozeny\app\AdminModule\presenters/templates/Exercises/manage.latte

use Latte\Runtime as LR;

class Template86ce97ae12 extends Latte\Runtime\Template
{
	public $blocks = [
		'content' => 'blockContent',
		'title' => 'blockTitle',
		'_exercises' => 'blockExercises',
	];

	public $blockTypes = [
		'content' => 'html',
		'title' => 'html',
		'_exercises' => 'html',
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
		if (isset($this->params['exercise'])) trigger_error('Variable $exercise overwritten in foreach on line 47');
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}


	function blockContent($_args)
	{
		extract($_args);
		/* line 2 */ $_tmp = $this->global->uiControl->getComponent("breadcrumb");
		if ($_tmp instanceof Nette\Application\UI\IRenderable) $_tmp->redrawControl(NULL, FALSE);
		$_tmp->render();
		$order = ($type == 'DESC') ? 'fa fa-sort-alpha-desc' : 'fa fa-sort-alpha-asc';
		$orderNumber = ($type == 'DESC') ? 'fa fa-sort-numeric-desc' : 'fa fa-sort-numeric-asc';
		$this->renderBlock('title', get_defined_vars());
		/* line 6 */
		echo Nette\Bridges\FormsLatte\Runtime::renderFormBegin($form = $_form = $this->global->formsStack[] = $this->global->uiControl["exercisesFiltreForm"], []);
?>

    <div class="admin-table-wrapper">
        <table class="stripped-table">
            <tr>
                <th>
                    <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("sortExercises!", ['name', $type])) ?>">Název</a>
<?php
		if ($sort == 'name') {
			?>                    <span class="order <?php echo LR\Filters::escapeHtmlAttr($order) /* line 12 */ ?>"></span>
<?php
		}
?>
                </th>
                <th>
                    <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("sortExercises!", ['users.username', $type])) ?>">Autor</a>
<?php
		if ($sort == 'users.username') {
			?>                    <span class="order <?php echo LR\Filters::escapeHtmlAttr($order) /* line 16 */ ?>"></span>
<?php
		}
?>
                </th>
                <th>Kategorie</th>
                <th>Sekce</th>
                <th>
                    <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("sortExercises!", ['created_at', $type])) ?>">Přidáno</a>
<?php
		if ($sort == 'created_at') {
			?>                    <span class="order <?php echo LR\Filters::escapeHtmlAttr($orderNumber) /* line 22 */ ?>"></span>
<?php
		}
?>
                </th>
                <th>
                    <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("sortExercises!", ['changed_at', $type])) ?>">Změněno</a>
<?php
		if ($sort == 'changed_at') {
			?>                    <span class="order <?php echo LR\Filters::escapeHtmlAttr($orderNumber) /* line 26 */ ?>"></span>
<?php
		}
?>
                </th>
                <th>Stav</th>
                <th>Akce</th>
            </tr>
            <tr>  

                    <td><?php echo end($this->global->formsStack)["namesearch"]->getControl() /* line 33 */ ?></td>
                    <td><?php echo end($this->global->formsStack)["authorsearch"]->getControl() /* line 34 */ ?></td>
                    <td><?php echo end($this->global->formsStack)["categorySelect"]->getControl() /* line 35 */ ?></td>
                    <td><?php echo end($this->global->formsStack)["sectionSelect"]->getControl() /* line 36 */ ?></td>
                    <td></td>
                    <td></td>
                    <td><?php echo end($this->global->formsStack)["hiddenselect"]->getControl() /* line 39 */ ?></td>
                    <td>
                     <button type="submit" class="ico-button large" title="Filtrovat"><span class="fa fa-filter"></span></button>
                    <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("removeFilter!")) ?>" class="ico-button large" title="Zrušit filtr"><span class="fa fa-times"></span></a>
                    </td>            
            </tr>  

        <tbody<?php echo ' id="' . htmlSpecialChars($this->global->snippetDriver->getHtmlId('exercises')) . '"' ?>>
<?php $this->renderBlock('_exercises', $this->params) ?>
        </tbody>
    </table>
</div>
<?php
		echo Nette\Bridges\FormsLatte\Runtime::renderFormEnd(array_pop($this->global->formsStack));
?>

<div class="paginationWrapper">
<?php
		/* line 74 */ $_tmp = $this->global->uiControl->getComponent("paginator");
		if ($_tmp instanceof Nette\Application\UI\IRenderable) $_tmp->redrawControl(NULL, FALSE);
		$_tmp->render();
?>
</div>
<?php
	}


	function blockTitle($_args)
	{
		extract($_args);
?><h2>Administrace cvičení</h2>
<?php
	}


	function blockExercises($_args)
	{
		extract($_args);
		$this->global->snippetDriver->enter("exercises", "static");
		?>            <?php
		$iterations = 0;
		foreach ($exercises as $exercise) {
?>

                <tr>
                    <td><?php echo LR\Filters::escapeHtmlText($exercise->name) /* line 49 */ ?></td>
                    <td><?php echo LR\Filters::escapeHtmlText($exercise->users->username) /* line 50 */ ?></td>
                    <td><?php echo LR\Filters::escapeHtmlText($exercise->sections->category->name) /* line 51 */ ?></td>
                    <td><?php echo LR\Filters::escapeHtmlText($exercise->sections->name) /* line 52 */ ?></td>
                    <td><?php echo LR\Filters::escapeHtmlText(call_user_func($this->filters->date, $exercise->created_at, 'd-m-Y')) /* line 53 */ ?></td>
                    <td><?php echo LR\Filters::escapeHtmlText(call_user_func($this->filters->date, $exercise->changed_at, 'd-m-Y')) /* line 54 */ ?></td>
                    <td><?php echo LR\Filters::escapeHtmlText(call_user_func($this->filters->bool, $exercise->hidden, 'Rozpracované', 'Dokončené')) /* line 55 */ ?></td>
                    <td>
                        <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link(":Front:Exercise:Show", [$exercise->exercises_id])) ?>" class="ico-button" title="Zobrazit">
                            <span class="fa fa-eye"></span>
                        </a>
                        <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Exercise:Manage", [$exercise->exercises_id])) ?>" class="ico-button" title="Editovat">
                            <span class="fa fa-pencil"></span>
                        </a>                   
                        <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("deleteExercise!", [$exercise->exercises_id])) ?>" class="ico-button confirm" title="Smazat">
                            <span class="fa fa-trash-o"></span>
                        </a>
                    </td>            
                </tr>
<?php
			$iterations++;
		}
		$this->global->snippetDriver->leave();
		
	}

}
