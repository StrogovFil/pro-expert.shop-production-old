<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

//print_r($arResult);

if ($arResult["isFormErrors"] == "Y"):?><?=$arResult["FORM_ERRORS_TEXT"];?><?endif;?>

<div class="form-note">
	<?echo $arResult["FORM_NOTE"];?>
</div>

<?if ($arResult["isFormNote"] != "Y")
{
echo $arResult["FORM_HEADER"];

/*if ($arResult["isFormDescription"] == "Y" || $arResult["isFormTitle"] == "Y" || $arResult["isFormImage"] == "Y")
{
	if ($arResult["isFormTitle"])
{
?>
	<h3><?=$arResult["FORM_TITLE"]?></h3>
<?
}

	if ($arResult["isFormImage"] == "Y")
	{
	?>
	<a href="<?=$arResult["FORM_IMAGE"]["URL"]?>" target="_blank" alt="<?=GetMessage("FORM_ENLARGE")?>"><img src="<?=$arResult["FORM_IMAGE"]["URL"]?>" <?if($arResult["FORM_IMAGE"]["WIDTH"] > 300):?>width="300"<?elseif($arResult["FORM_IMAGE"]["HEIGHT"] > 200):?>height="200"<?else:?><?=$arResult["FORM_IMAGE"]["ATTR"]?><?endif;?> hspace="3" vscape="3" border="0" /></a>
	<?//=$arResult["FORM_IMAGE"]["HTML_CODE"]?>
	<?
	} //endif
	?>

			<p><?=$arResult["FORM_DESCRIPTION"]?></p>
	<?
}*/
/***********************************************************************************
						form questions
***********************************************************************************/
$count = 1;

	foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion)
	{
		$structure = $arQuestion['STRUCTURE'][0];

		if ($arQuestion['STRUCTURE'][0]['FIELD_TYPE'] == 'hidden')
		{
			echo $arQuestion["HTML_CODE"];
		}
		elseif ($arQuestion['STRUCTURE'][0]['FIELD_TYPE'] == 'textarea')
		{
		?> </div>
                <label class="form-label form-label-shorttitle">
                    <textarea id="form_<?= $structure['FIELD_TYPE'] . "_" . $structure['ID'] ?>"
                              name="form_<?= $structure['FIELD_TYPE'] . "_" . $structure['ID'] ?>"
                              class="form-input" rows="3" <?= $structure['FIELD_PARAM'] ?>
                        <?= $arQuestion["REQUIRED"] == "Y" ? "required" : "" ?>
                    ><?= ($arResult['arrVALUES']['form_' . $structure['FIELD_TYPE'] . '_' . $structure['QUESTION_ID']] ?: $arQuestion['VALUE']) ?></textarea>
                    <span class="form-label-title"><?=$arQuestion["CAPTION"]?></span>
                </label>
				<?if (is_array($arResult["FORM_ERRORS"]) && array_key_exists($FIELD_SID, $arResult['FORM_ERRORS'])):?>
				<div class="form-error"><?= htmlspecialcharsbx($arResult["FORM_ERRORS"][$FIELD_SID]) ?></div>
				<?endif;?>
		<? }
		else
		{
		 	if ($count == 1):?>
			<div class="question-form-row">
			<?endif;?>
                    <div class="question-form-col">
                        <label class="form-label form-label-shorttitle">
							<input id="form_<?= $structure['FIELD_TYPE'] . "_" . $structure['ID'] ?>" type="<?=$structure['FIELD_TYPE_PSEUDO'] ?: $structure['FIELD_TYPE']?>" <?= $structure['FIELD_PARAM'] ?>
                                   class="form-input <?= $fieldHasError ? " has-danger" : "" ?> <?= ($structure['ID'] == 2) ? "js-phone" : "" ?>"
                                   name="form_<?= $structure['FIELD_TYPE'] . "_" . $structure['ID'] ?>"
                                <?= $arQuestion["REQUIRED"] == "Y" ? "required" : "" ?>
                                   value="<?= ($arResult['arrVALUES']['form_' . $structure['FIELD_TYPE'] . '_' . $structure['QUESTION_ID']] ?: $arQuestion['VALUE']) ?>" placeholder="<?= $arQuestion['CAPTION'] ?>" />
                            <span class="form-label-title"><?=$arQuestion["CAPTION"]?></span>
                        </label>
				<?if (is_array($arResult["FORM_ERRORS"]) && array_key_exists($FIELD_SID, $arResult['FORM_ERRORS'])):?>
				<div class="form-error"><?= htmlspecialcharsbx($arResult["FORM_ERRORS"][$FIELD_SID]) ?></div>
				<?endif;?>
                    </div>
	<?
		}

		$count++;
	} //endwhile
	?>
<button type="submit" name="web_form_submit" class="btn btn-black question-form-btn"><?=htmlspecialcharsbx(strlen(trim($arResult["arForm"]["BUTTON"])) <= 0 ? GetMessage("FORM_ADD") : $arResult["arForm"]["BUTTON"]);?> <i class="icon icon-arrow-left"></i></button>
<input type="hidden" name="web_form_apply" value="Y" />
<?=$arResult["FORM_FOOTER"]?>
<?
} //endif (isFormNote)
?>
