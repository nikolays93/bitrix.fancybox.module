<?php

use Bitrix\Main\Localization\Loc;
use	Bitrix\Main\HttpApplication;
use Bitrix\Main\Loader;
use Bitrix\Main\Config\Option;

Loc::loadMessages(__FILE__);

$request = HttpApplication::getInstance()->getContext()->getRequest();

$module_id = htmlspecialcharsbx($request["mid"] != "" ? $request["mid"] : $request["id"]);

Loader::includeModule($module_id);

$aTabs = array(
	array(
		"DIV" 	  => "edit",
		"TAB" 	  => Loc::getMessage("NIKOLAYS93_FANCYBOX_OPTIONS_MAIN_TAB"),
		"TITLE"   => Loc::getMessage("NIKOLAYS93_FANCYBOX_OPTIONS_MAIN_TAB_TITLE"),
		"OPTIONS" => array(
			array(
				"enable",
				Loc::getMessage("NIKOLAYS93_FANCYBOX_OPTIONS_ENABLE"),
				"Y",
				array("checkbox")
			),
			array(
				"selector",
				Loc::getMessage("NIKOLAYS93_FANCYBOX_OPTIONS_SELECTOR"),
				".fancybox",
				array("text", 20)
			),
			Loc::getMessage("NIKOLAYS93_FANCYBOX_OPTIONS_DEVIDER"),
			array(
				"list-example",
				Loc::getMessage("NIKOLAYS93_FANCYBOX_OPTIONS_SELECTBOX"),
				"0",
				array("selectbox", array(
					'0' => 0,
					'1' => 1
				))
			),
		)
	)
);

if($request->isPost() && check_bitrix_sessid()) {

	foreach($aTabs as $aTab)
	{
		foreach($aTab["OPTIONS"] as $arOption)
		{
			if( ! is_array($arOption)) continue;
			if($arOption["note"]) continue;

			if($request["apply"]) {
				// Get option value.
				$optionValue = $request->getPost($arOption[0]);

				// Prepare values.
				if("switch_on" === $arOption[0] && "" == $optionValue) {
					$optionValue = "N";
				}

				// Set new option.
				Option::set($module_id, $arOption[0], is_array($optionValue) ? implode(",", $optionValue) : $optionValue);
			}
			elseif($request["default"]) {
				// Set default option.
				Option::set($module_id, $arOption[0], $arOption[2]);
			}
		}
	}

	LocalRedirect($APPLICATION->GetCurPage()."?mid={$module_id}&lang=".LANG);
}

$tabControl = new CAdminTabControl(
	"tabControl",
	$aTabs
);

$tabControl->Begin();
?>

<form action="<?= $APPLICATION->GetCurPage() ?>?mid=<?= $module_id ?>&lang=<?= LANG ?>" method="post">

	<?php
	foreach($aTabs as $aTab) {
		if(empty($aTab["OPTIONS"])) continue;

		$tabControl->BeginNextTab();
		__AdmSettingsDrawList($module_id, $aTab["OPTIONS"]);
	}

	$tabControl->Buttons();
	?>

	<input type="submit" name="apply" value="<?= Loc::GetMessage("NIKOLAYS93_FANCYBOX_OPTIONS_INPUT_APPLY") ?>" class="adm-btn-save" />
	<input type="submit" name="default" value="<?= Loc::GetMessage("NIKOLAYS93_FANCYBOX_OPTIONS_INPUT_DEFAULT") ?>" />

	<?= bitrix_sessid_post() ?>

</form>

<?php

$tabControl->End();
