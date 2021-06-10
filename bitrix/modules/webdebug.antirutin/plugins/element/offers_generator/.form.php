<?
use
	WD\Antirutin\Helper,
	WD\Antirutin\IBlock;

$intSort = intVal($this->get('sort'));
if($intSort <= 0){
	$intSort = 500;
}

?>

<div class="plugin-form__field">
	<div class="plugin-form__field-title">
		<?=$this->fieldName('COUNT', true);?>
	</div>
	<div class="plugin-form__field-value">
		<div id="<?=$this->getId('count');?>">
			<input type="text" name="<?=$this->getInputName('count');?>" value="<?=$this->get('count');?>" size="5"
				data-role="count" />
		</div>
	</div>
</div>

<div class="plugin-form__field">
	<div class="plugin-form__field-title">
		<?=$this->fieldName('ACTIVE', true);?>
	</div>
	<div class="plugin-form__field-value">
		<div id="<?=$this->getId('active');?>">
			<input type="checkbox" name="<?=$this->getInputName('active');?>" value="Y" data-role="count" 
				<?if($this->get('active') == 'Y'):?>checked<?endif?>/>
		</div>
	</div>
</div>

<div class="plugin-form__field">
	<div class="plugin-form__field-title">
		<?=$this->fieldName('COPY_PRICES', true);?>
	</div>
	<div class="plugin-form__field-value">
		<div id="<?=$this->getId('copy_prices');?>">
			<input type="checkbox" name="<?=$this->getInputName('copy_prices');?>" value="Y" data-role="copy_prices" 
				<?if($this->get('copy_prices') == 'Y'):?>checked<?endif?>/>
		</div>
	</div>
</div>

<input type="hidden" data-role="error_no_count" value="<?=static::getMessage('ERROR_NO_COUNT');?>" />
