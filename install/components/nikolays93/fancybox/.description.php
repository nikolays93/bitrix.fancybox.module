<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => GetMessage("FANCYBOX_COMPONENT_NAME"),
	"DESCRIPTION" => GetMessage("FANCYBOX_COMPONENT_DESCR"),
	"ICON" => "/images/include.gif",
	"PATH" => array(
		"ID" => "utility",
		"CHILD" => array(
			"ID" => "include_area",
			"NAME" => GetMessage("FANCYBOX_GROUP_NAME"),
		),
	),
);
?>
