<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var array $templateData
 * @var array $arParams
 * @var string $templateFolder
 * @global CMain $APPLICATION
 */

global $APPLICATION;

$is_compressed = ! defined( 'SCRIPT_DEBUG' ) || SCRIPT_DEBUG === false;
$min           = $is_compressed ? '.min' : '';

// Add vendor assets.
$APPLICATION->SetAdditionalCSS("{$templateFolder}/fancybox/jquery.fancybox{$min}.css");
$APPLICATION->AddHeadScript("{$templateFolder}/fancybox/jquery.fancybox{$min}.js");

// Add jQuery when not exists.
printf(
	'<script>window.jQuery || document.write(\'<script src="%s"><\/script>\')</script>',
	str_replace('/', '\/', TPL . '/assets/vendor/jquery/jquery.min.js')
);