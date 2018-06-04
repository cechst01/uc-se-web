<?php
// source: D:\WWW\web-portal-slozeny\app\AdminModule\presenters/templates/Tests/manage.latte

use Latte\Runtime as LR;

class Templatecae8267589 extends Latte\Runtime\Template
{
	public $blocks = [
		'content' => 'blockContent',
		'title' => 'blockTitle',
		'_tests' => 'blockTests',
	];

	public $blockTypes = [
		'content' => 'html',
		'title' => 'html',
		'_tests' => 'html',
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
		if (isset($this->params['test'])) trigger_error('Variable $test overwritten in foreach on line 57');
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
		echo Nette\Bridges\FormsLatte\Runtime::renderFormBegin($form = $_form = $this->global->formsStack[] = $this->global->uiControl["testsFiltreForm"], []);
?>

<div class="admin-table-wrapper">
    <table class="stripped-table tests-table">
        <tr>
            <th>
                <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("sortTests!", ['name', $type])) ?>">Název</a>
<?php
		if ($sort == 'name') {
			?>                <span class="order <?php echo LR\Filters::escapeHtmlAttr($order) /* line 12 */ ?>"></span>
<?php
		}
?>
            </th>
            <th>
                <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("sortTests!", ['description', $type])) ?>">Popis</a>
<?php
		if ($sort == 'description') {
			?>                <span class="order <?php echo LR\Filters::escapeHtmlAttr($order) /* line 16 */ ?>"></span>
<?php
		}
?>
            </th>
            <th>
                <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("sortTests!", ['users.username', $type])) ?>">Autor</a>
<?php
		if ($sort == 'users.username') {
			?>                <span class="order <?php echo LR\Filters::escapeHtmlAttr($order) /* line 20 */ ?>"></span>
<?php
		}
?>
            </th>
            <th>Kategorie</th>
            <th>Sekce</th>
            <th>
                <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("sortTests!", ['question_count', $type])) ?>">Počet otázek</a>
<?php
		if ($sort == 'question_count') {
			?>                <span class="order <?php echo LR\Filters::escapeHtmlAttr($orderNumber) /* line 26 */ ?>"></span>
<?php
		}
?>
            </th>
            <th>
                <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("sortTests!", ['created_at', $type])) ?>">Přidáno</a>
<?php
		if ($sort == 'created_at') {
			?>                <span class="order <?php echo LR\Filters::escapeHtmlAttr($orderNumber) /* line 30 */ ?>"></span>
<?php
		}
?>
            </th>
            <th>
                <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("sortTests!", ['changed_at', $type])) ?>">Změněno</a>
<?php
		if ($sort == 'changed_at') {
			?>                <span class="order <?php echo LR\Filters::escapeHtmlAttr($orderNumber) /* line 34 */ ?>"></span>
<?php
		}
?>
            </th>
            <th>Stav</th>
            <th>Akce</th>
        </tr>

        <tr>        
                <td><?php echo end($this->global->formsStack)["namesearch"]->getControl() /* line 41 */ ?></td>
                <td><?php echo end($this->global->formsStack)["descriptsearch"]->getControl() /* line 42 */ ?></td>
                <td><?php echo end($this->global->formsStack)["authorsearch"]->getControl() /* line 43 */ ?></td>
                <td><?php echo end($this->global->formsStack)["categorySelect"]->getControl() /* line 44 */ ?></td>
                <td><?php echo end($this->global->formsStack)["sectionSelect"]->getControl() /* line 45 */ ?></td>
                <td>Počet otázek</td>
                <td>Vytvořeno</td>
                <td>změněno</td>
                <td><?php echo end($this->global->formsStack)["hiddenselect"]->getControl() /* line 49 */ ?></td>
                <td>
                    <button type="submit" class="ico-button large" title="Filtrovat"><span class="fa fa-filter"></span></button>
                    <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("removeFilter!")) ?>" class="ico-button large" title="Zrušit filtr"><span class="fa fa-times"></span></a>
                </td>        
        </tr>

        <tbody<?php echo ' id="' . htmlSpecialChars($this->global->snippetDriver->getHtmlId('tests')) . '"' ?>>
<?php $this->renderBlock('_tests', $this->params) ?>
        </tbody>
    </table>
</div>
<?php
		echo Nette\Bridges\FormsLatte\Runtime::renderFormEnd(array_pop($this->global->formsStack));
?>

<div class="paginationWrapper">
<?php
		/* line 86 */ $_tmp = $this->global->uiControl->getComponent("paginator");
		if ($_tmp instanceof Nette\Application\UI\IRenderable) $_tmp->redrawControl(NULL, FALSE);
		$_tmp->render();
?>
</div>
<?php
	}


	function blockTitle($_args)
	{
		extract($_args);
?><h2>Administrace testů</h2>
<?php
	}


	function blockTests($_args)
	{
		extract($_args);
		$this->global->snippetDriver->enter("tests", "static");
		?>            <?php
		$iterations = 0;
		foreach ($tests as $test) {
?>

                <tr>
                    <td><?php echo LR\Filters::escapeHtmlText($test->name) /* line 59 */ ?></td>
                    <td><?php echo LR\Filters::escapeHtmlText($test->description) /* line 60 */ ?></td>
                    <td><?php echo LR\Filters::escapeHtmlText($test->users->username) /* line 61 */ ?></td>
                    <td><?php echo LR\Filters::escapeHtmlText($test->sections->category->name) /* line 62 */ ?></td>
                    <td><?php echo LR\Filters::escapeHtmlText($test->sections->name) /* line 63 */ ?></td>
                    <td><?php echo LR\Filters::escapeHtmlText($test->question_count) /* line 64 */ ?></td>
                    <td><?php echo LR\Filters::escapeHtmlText(call_user_func($this->filters->date, $test->created_at, 'd-m-Y')) /* line 65 */ ?></td>
                    <td><?php echo LR\Filters::escapeHtmlText(call_user_func($this->filters->date, $test->changed_at, 'd-m-Y')) /* line 66 */ ?></td>
                    <td><?php echo LR\Filters::escapeHtmlText(call_user_func($this->filters->bool, $test->hidden, 'Rozpracovaný', 'Dokončený')) /* line 67 */ ?></td>
                    <td>
                        <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link(":Front:Test:Show", [$test->tests_id])) ?>" class="ico-button" title="Zobrazit">
                            <span class="fa fa-eye"></span>
                        </a>
                        <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Test:Manage", [$test->tests_id])) ?>" class="ico-button" title="Editovat">
                            <span class="fa fa-pencil"></span>
                        </a>               
                        <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("deleteTest!", [$test->tests_id])) ?>" class="confirm ico-button" title="Smazat">
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
