<?php
// source: D:\WWW\web-portal-slozeny\app\AdminModule\presenters/templates/Tutorials/manage.latte

use Latte\Runtime as LR;

class Templatedf7ffbef6e extends Latte\Runtime\Template
{
	public $blocks = [
		'content' => 'blockContent',
		'title' => 'blockTitle',
		'_tutorials' => 'blockTutorials',
	];

	public $blockTypes = [
		'content' => 'html',
		'title' => 'html',
		'_tutorials' => 'html',
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
		if (isset($this->params['tutorial'])) trigger_error('Variable $tutorial overwritten in foreach on line 52');
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}


	function blockContent($_args)
	{
		extract($_args);
		$order = ($type == 'DESC') ? 'fa fa-sort-alpha-desc' : 'fa fa-sort-alpha-asc';
		$orderNumber = ($type == 'DESC') ? 'fa fa-sort-numeric-desc' : 'fa fa-sort-numeric-asc';
		/* line 4 */ $_tmp = $this->global->uiControl->getComponent("breadcrumb");
		if ($_tmp instanceof Nette\Application\UI\IRenderable) $_tmp->redrawControl(NULL, FALSE);
		$_tmp->render();
		$this->renderBlock('title', get_defined_vars());
		/* line 6 */
		echo Nette\Bridges\FormsLatte\Runtime::renderFormBegin($form = $_form = $this->global->formsStack[] = $this->global->uiControl["tutorialsFilterForm"], []);
?>

<div class="admin-table-wrapper">
<table class="stripped-table tutorials-table">
    <tr>
        <th>
            <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("sortTutorials!", ['name', $type])) ?>">Název</a>
<?php
		if ($sort == 'name') {
			?>            <span class="order <?php echo LR\Filters::escapeHtmlAttr($order) /* line 12 */ ?>"></span>
<?php
		}
?>
        </th>
        <th>
            <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("sortTutorials!", ['description', $type])) ?>">Popis</a>
<?php
		if ($sort == 'description') {
			?>            <span class="order <?php echo LR\Filters::escapeHtmlAttr($order) /* line 16 */ ?>"></span>
<?php
		}
?>
        </th>
        <th>
            <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("sortTutorials!", ['users.username', $type])) ?>">Autor</a>
<?php
		if ($sort == 'users.username') {
			?>            <span class="order <?php echo LR\Filters::escapeHtmlAttr($order) /* line 20 */ ?>"></span>
<?php
		}
?>
        </th>
        <th>Kategorie</th>
        <th>Sekce</th>
        <th>
            <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("sortTutorials!", ['created_at', $type])) ?>">Přidáno</a>
<?php
		if ($sort == 'created_at') {
			?>            <span class="order <?php echo LR\Filters::escapeHtmlAttr($orderNumber) /* line 26 */ ?>"></span>
<?php
		}
?>
        </th>
        <th>
            <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("sortTutorials!", ['changed_at', $type])) ?>">Změněno</a>
<?php
		if ($sort == 'changed_at') {
			?>            <span class="order <?php echo LR\Filters::escapeHtmlAttr($orderNumber) /* line 30 */ ?>"></span>
<?php
		}
?>
        </th>
        <th>Stav</th>
        <th>Akce</th>
    </tr>

    <tr>    
            <td><?php echo end($this->global->formsStack)["namesearch"]->getControl() /* line 37 */ ?></td>
            <td><?php echo end($this->global->formsStack)["descriptsearch"]->getControl() /* line 38 */ ?></td>
            <td><?php echo end($this->global->formsStack)["authorsearch"]->getControl() /* line 39 */ ?></td>
            <td><?php echo end($this->global->formsStack)["categorySelect"]->getControl() /* line 40 */ ?></td>
            <td><?php echo end($this->global->formsStack)["sectionSelect"]->getControl() /* line 41 */ ?></td>                
            <td></td>
            <td></td>                 
            <td><?php echo end($this->global->formsStack)["hiddenSelect"]->getControl() /* line 44 */ ?></td>
            <td>
                <button type="submit" class="ico-button large" title="Filtrovat"><span class="fa fa-filter"></span></button>
               <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("removeFilter!")) ?>" class="ico-button large" title="Zrušit filtr"><span class="fa fa-times"></span></a>
            </td>                       
    </tr>
   
    <tbody<?php echo ' id="' . htmlSpecialChars($this->global->snippetDriver->getHtmlId('tutorials')) . '"' ?>> 
<?php $this->renderBlock('_tutorials', $this->params) ?>
    </tbody>
</table>
</div>
<?php
		echo Nette\Bridges\FormsLatte\Runtime::renderFormEnd(array_pop($this->global->formsStack));
?>

<div class="paginationWrapper">
<?php
		/* line 83 */ $_tmp = $this->global->uiControl->getComponent("paginator");
		if ($_tmp instanceof Nette\Application\UI\IRenderable) $_tmp->redrawControl(NULL, FALSE);
		$_tmp->render();
?>
</div>
<?php
	}


	function blockTitle($_args)
	{
		extract($_args);
?><h2>Administrace tutorialů</h2>
<?php
	}


	function blockTutorials($_args)
	{
		extract($_args);
		$this->global->snippetDriver->enter("tutorials", "static");
		?>    <?php
		$iterations = 0;
		foreach ($tutorials as $tutorial) {
?>

        <tr>
            <td><?php echo LR\Filters::escapeHtmlText($tutorial->name) /* line 54 */ ?></td>
            <td><?php echo LR\Filters::escapeHtmlText($tutorial->description) /* line 55 */ ?></td>
            <td><?php echo LR\Filters::escapeHtmlText($tutorial->users->username) /* line 56 */ ?></td>
            <td><?php echo LR\Filters::escapeHtmlText($tutorial->section->category->name) /* line 57 */ ?></td>
            <td><?php echo LR\Filters::escapeHtmlText($tutorial->section->name) /* line 58 */ ?></td>
            <td><?php echo LR\Filters::escapeHtmlText(call_user_func($this->filters->date, $tutorial->created_at, 'd-m-Y')) /* line 59 */ ?></td>
            <td><?php echo LR\Filters::escapeHtmlText(call_user_func($this->filters->date, $tutorial->changed_at, 'd-m-Y')) /* line 60 */ ?></td>
            <td><?php echo LR\Filters::escapeHtmlText(call_user_func($this->filters->bool, $tutorial->hidden, 'Rozpracovaný', 'Dokončený')) /* line 61 */ ?></td>
            <td>
                <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link(":Front:Tutorial:Show", [$tutorial->tutorials_id])) ?>" class="ico-button" title="Zobrazit">
                    <span class="fa fa-eye"></span>
                </a>
                <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Tutorial:Manage", [$tutorial->tutorials_id])) ?>" class="ico-button" title="Eitovat">
                    <span class="fa fa-pencil"></span>
                </a>
                <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Comments:Manage", [$tutorial->tutorials_id])) ?>" class="ico-button" title="Spravovat komentáře">
                    <span class="fa fa-comments-o"></span>
                </a>
                <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("deleteTutorial!", [$tutorial->tutorials_id])) ?>" class="confirm ico-button" title="Smazat">
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
