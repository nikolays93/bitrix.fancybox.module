<?
if ( ! defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);

printf('<a href="javascript:;" data-fancybox data-type="ajax" data-src="%s" class="%s">%s</a>',
	$arParams['URL_PATH'],
	$arParams['BUTTON_CLASS'],
	$arParams['BUTTON_TEXT']
);
