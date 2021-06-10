<?
use
	WD\Antirutin\Helper,
	WD\Antirutin\IBlock;

$intMacrosIBlockId = $this->isOfferField($this->get('field')) ? $this->getOffersIBlockId() : $this->intIBlockId;

?>

<div class="plugin-form__field">
	<div class="plugin-form__field-title">
		<?=$this->fieldName('FIELD', true);?>
	</div>
	<div class="plugin-form__field-value">
		<div id="<?=$this->getId('field');?>">
			<?=IBlock::showAvailableFields($this->getFields(), $this->strEntityType, $this->getInputName('field'),
				$this->get('field'), 'data-role="field"', true);?>
		</div>
	</div>
</div>

<div class="plugin-form__field">
	<div class="plugin-form__field-title">
		<?=$this->fieldName('TEXT_TYPE', true);?>
	</div>
	<div class="plugin-form__field-value">
		<div id="<?=$this->getId('text_type');?>">
			<?=Helper::selectBox($this->getInputName('text_type'), [
				'' => static::getMessage('TEXT_TYPE_NO'),
				'text' => static::getMessage('TEXT_TYPE_TEXT'),
				'html' => static::getMessage('TEXT_TYPE_HTML'),
			], $this->get('text_type'), null, 'data-role="text_type"');?>
		</div>
	</div>
</div>

<div class="plugin-form__field">
	<div class="plugin-form__field-title">
		<?=$this->fieldName('PATTERN', true);?>
	</div>
	<div class="plugin-form__field-value">
		<div id="<?=$this->getId('pattern');?>"data-role="pattern_wrapper">
			<textarea name="<?=$this->getInputName('pattern');?>" id="<?=$this->getTextareaId();?>" cols="80" rows="5"
				><?=htmlspecialcharsbx($this->get('pattern'));?></textarea>
		</div>
		<div id="<?=$this->getId('pattern_macro');?>" data-role="macro_wrapper">
			<span><?=static::getMessage('PATTERN_MACRO_TITLE');?></span>
			<select data-role="pattern">
				<?=$this->getMacrosForSelect($intMacrosIBlockId);?>
			</select>
			<?=$this->fieldHint('PATTERN_MACRO');?>
			<script>
			wdaSelect2($('#<?=$this->getId('pattern_macro');?> > select'), {
				dropdownParent: $('#<?=$this->getId('pattern_macro');?>'),
			});
			</script>
		</div>
	</div>
</div>

<div class="plugin-form__field">
	<span>
		<input type="hidden" name="<?=$this->getInputName('use_as_formula');?>" value="N" />
		<input type="checkbox" name="<?=$this->getInputName('use_as_formula');?>" value="Y" 
			<?if($this->get('use_as_formula') == 'Y'):?>checked="checked"<?endif?> 
			id="<?=$this->getId('use_as_formula');?>" data-role="use_as_formula" />
	</span>
	<label for="<?=$this->getId('use_as_formula');?>">
		<?=$this->fieldName('USE_AS_FORMULA', true, false);?>
	</label>
</div>

<input type="hidden" data-role="error_no_field" value="<?=static::getMessage('ERROR_NO_FIELD');?>" />
