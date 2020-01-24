<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$arType = array(
	"page" => GetMessage("FANCYBOX_PAGE"),
	"sect" => GetMessage("FANCYBOX_SECT"),
	"url" => GetMessage("FANCYBOX_URL"),
);
if ($GLOBALS['USER']->CanDoOperation('edit_php'))
{
	$arType["file"] = GetMessage("FANCYBOX_FILE");
}

$site_template = false;
$site = ($_REQUEST["site"] <> ''? $_REQUEST["site"] : ($_REQUEST["src_site"] <> ''? $_REQUEST["src_site"] : false));
if($site !== false)
{
	$rsSiteTemplates = CSite::GetTemplateList($site);
	while($arSiteTemplate = $rsSiteTemplates->Fetch())
	{
		if(strlen($arSiteTemplate["CONDITION"])<=0)
		{
			$site_template = $arSiteTemplate["TEMPLATE"];
			break;
		}
	}
}

$arComponentParameters = array(
	"GROUPS" => array(
		"PARAMS" => array(
			"NAME" => GetMessage("FANCYBOX_PARAMS"),
		),
		"BUTTON" => array(
			"NAME" => GetMessage("FANCYBOX_BUTTON_PARAMS"),
		),
	),

	"PARAMETERS" => array(
		"AREA_FILE_SHOW" => array(
			"NAME" => GetMessage("FANCYBOX_AREA_FILE_SHOW"), 
			"TYPE" => "LIST",
			"MULTIPLE" => "N",
			"VALUES" => $arType,
			"ADDITIONAL_VALUES" => "N",
			"DEFAULT" => "page",
			"PARENT" => "PARAMS",
			"REFRESH" => "Y",
		),
	),
);

if ($GLOBALS['USER']->CanDoOperation('edit_php') && $arCurrentValues["AREA_FILE_SHOW"] == "file")
{
	$arComponentParameters["PARAMETERS"]["PATH"] = array(
		"NAME" => GetMessage("FANCYBOX_PATH"), 
		"TYPE" => "STRING",
		"MULTIPLE" => "N",
		"ADDITIONAL_VALUES" => "N",
		"PARENT" => "PARAMS",
	);
}
else
{
	if ("url" == $arCurrentValues["AREA_FILE_SHOW"])
	{
		$arComponentParameters["PARAMETERS"]["URL_PATH"] = array(
			"NAME" => GetMessage("FANCYBOX_URL_PATH"), 
			"TYPE" => "STRING",
			"DEFAULT" => "#",
			"PARENT" => "PARAMS",
		);
	}
	else
	{
		$arComponentParameters["PARAMETERS"]["AREA_FILE_SUFFIX"] = array(
			"NAME" => GetMessage("FANCYBOX_AREA_FILE_SUFFIX"), 
			"TYPE" => "STRING",
			"DEFAULT" => "inc",
			"PARENT" => "PARAMS",
		);
	}

	if ($arCurrentValues["AREA_FILE_SHOW"] == "sect")
	{
		$arComponentParameters["PARAMETERS"]["AREA_FILE_RECURSIVE"] = array(
			"NAME" => GetMessage("FANCYBOX_AREA_FILE_RECURSIVE"), 
			"TYPE" => "CHECKBOX",
			"ADDITIONAL_VALUES" => "N",
			"DEFAULT" => "Y",
			"PARENT" => "PARAMS",
		);
	}
}

$arComponentParameters["PARAMETERS"]["BUTTON_TEXT"] = Array(
	"NAME"    => GetMessage("FANCYBOX_BUTTON_TEXT"),
	"TYPE"    => "STRING",
	"DEFAULT" => "Открыть",
	"PARENT"  => "BUTTON",
);

$arComponentParameters["PARAMETERS"]["BUTTON_CLASS"] = Array(
	"NAME"    => GetMessage("FANCYBOX_BUTTON_CLASS"),
	"TYPE"    => "STRING",
	"DEFAULT" => "btn btn-primary",
	"PARENT"  => "BUTTON",
);
