<?php
// source: D:\WWW\web-portal-slozeny\app\components/templates/help.latte

use Latte\Runtime as LR;

class Templateb23193f614 extends Latte\Runtime\Template
{

	function main()
	{
		extract($this->params);
		if (isset($help) && $help) {
?>
    <div class="help">
        <span class='helpIco fa fa-question'></span>
        <div class='hide help-text'><?php echo $help->content /* line 4 */ ?></div>
    </div>
<?php
		}
		else {
?>
 
<?php
		}
?>

<?php
		return get_defined_vars();
	}


	function prepare()
	{
		extract($this->params);
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}

}
