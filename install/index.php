<?php
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ModuleManager;
use Bitrix\Main\Config\Option;
use Bitrix\Main\EventManager;
use Bitrix\Main\Application;
use Bitrix\Main\IO\Directory;

Loc::loadMessages(__FILE__);

Class Nikolays93_Fancybox extends CModule
{
    public $MODULE_VERSION = '0.0';
    public $MODULE_VERSION_DATE = '0000-00-00 00:00:00';

    public $errors = array();

    function __construct()
    {
        $versionFile = __DIR__ . "/version.php";

        if(file_exists($versionFile)) {
            $arModuleVersion = array();

            include_once($versionFile);

            $this->MODULE_VERSION       = $arModuleVersion["VERSION"];
            $this->MODULE_VERSION_DATE  = $arModuleVersion["VERSION_DATE"];
        }

        $this->MODULE_ID            = 'nikolays93.fancybox';
        $this->MODULE_NAME          = Loc::getMessage("NIKOLAYS93_FANCYBOX_NAME");
        $this->MODULE_DESCRIPTION   = Loc::getMessage("NIKOLAYS93_FANCYBOX_DESCRIPTION");
        $this->PARTNER_NAME         = Loc::getMessage("NIKOLAYS93_FANCYBOX_PARTNER_NAME");
        $this->PARTNER_URI          = Loc::getMessage("NIKOLAYS93_FANCYBOX_PARTNER_URI");
    }

    function DoInstall()
    {
        global $APPLICATION;

        if(CheckVersion(ModuleManager::getVersion("main"), "14.00.00")) {
            $this->InstallDB();
            $this->InstallEvents();
            $this->InstallFiles();
            \Bitrix\Main\ModuleManager::RegisterModule($this->MODULE_ID);
        }
        else {
            $APPLICATION->ThrowException(
                Loc::getMessage("NIKOLAYS93_FANCYBOX_INSTALL_ERROR_VERSION")
            );
        }

        $APPLICATION->IncludeAdminFile(
            Loc::getMessage("NIKOLAYS93_FANCYBOX_INSTALL_TITLE")." \"".
            Loc::getMessage("NIKOLAYS93_FANCYBOX_NAME")."\"",
            __DIR__ . "/step.php"
        );

        return true;
    }

    function DoUninstall()
    {
        global $APPLICATION;

        $this->UnInstallDB();
        $this->UnInstallEvents();
        $this->UnInstallFiles();
        \Bitrix\Main\ModuleManager::UnRegisterModule($this->MODULE_ID);

        $APPLICATION->IncludeAdminFile(
            Loc::getMessage("NIKOLAYS93_FANCYBOX_UNINSTALL_TITLE")." \"".
            Loc::getMessage("NIKOLAYS93_FANCYBOX_NAME")."\"",
            __DIR__ . "/unstep.php"
        );

        return true;
    }

    function InstallDB()
    {
        global $DB;

        // $this->errors = $DB->RunSQLBatch(__DIR__ . "/db/install.sql");

        return !empty($this->errors) ? $this->errors : true;
    }

    function UnInstallDB()
    {
        global $DB;

        // Option::delete($this->MODULE_ID);
        // $this->errors = $DB->RunSQLBatch(__DIR__ . "/db/uninstall.sql");

        return !empty($this->errors) ? $this->errors : true;
    }

    function InstallEvents()
    {
        return EventManager::getInstance()->registerEventHandler(
            "main",
            "OnBeforeEndBufferContent",
            $this->MODULE_ID,
            "Nikolays93\fancybox\Main",
            "appendAssets"
        );
    }

    function UnInstallEvents()
    {
        return EventManager::getInstance()->unRegisterEventHandler(
            "main",
            "OnBeforeEndBufferContent",
            $this->MODULE_ID,
            "Nikolays93\fancybox\Main",
            "appendAssets"
        );
    }

    function InstallFiles()
    {
        return CopyDirFiles(
        	__DIR__ . "/components",
        	Application::getDocumentRoot() . "/local/components",
        	true,
        	true
        );
    }

    function UnInstallFiles()
    {
    	Directory::deleteDirectory(Application::getDocumentRoot() . "/local/components/nikolays93/fancybox");
    }
}
