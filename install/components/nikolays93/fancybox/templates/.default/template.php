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

$rand = randString(7);

printf('<a href="javascript:;" data-fancybox data-src="#fancy_%s" class="%s">%s</a>',
	$rand,
	$arParams['BUTTON_CLASS'],
	$arParams['BUTTON_TEXT']
);

echo '<div id="fancy_' . $rand . '" style="display: none;">' . "\r\n";
if($arResult["FILE"] <> '') include($arResult["FILE"]);
echo '</div>' . "\r\n";
