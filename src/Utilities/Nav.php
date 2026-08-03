<?php

namespace Utilities;

use Dao\CarretillaAnon\CarretillaAnon as DaoCarretillaAnon;

class Nav
{
    public static function setPublicNavContext()
    {
        $tmpNAVIGATION = Context::getContextByKey("PUBLIC_NAVIGATION");

        if ($tmpNAVIGATION === "") {
            $tmpNAVIGATION = self::getNavFromJson()["public"];
        }

        // El redireccionamiento depende de la sesion y si hay productos en la caretilla anonima
        foreach ($tmpNAVIGATION as &$navEntry) {
            if ($navEntry["id"] === "Menu_Carretilla") {
                $navEntry["nav_url"] = self::resolveCartUrl();
            }
        }
        unset($navEntry);

        $saveToSession = intval(Context::getContextByKey("DEVELOPMENT")) !== 1;
        Context::setContext("PUBLIC_NAVIGATION", $tmpNAVIGATION, $saveToSession);
    }

    private static function resolveCartUrl(): string
    {
        if (Security::isLogged()) {
            return "index.php?page=Carretilla_Carretilla";
        }

        $anoncod = $_SESSION["anoncod"] ?? null;

        if ($anoncod) {
            $count = DaoCarretillaAnon::getItemsCount($anoncod);
            if ($count && intval($count["cantidad"]) > 0) {
                return "index.php?page=CarretillaAnon_CarretillaAnon";
            }
        }

        return "index.php?page=Sec_Login";
    }

    public static function setNavContext()
    {
        $tmpNAVIGATION = Context::getContextByKey("NAVIGATION");
        if ($tmpNAVIGATION === "") {
            $tmpNAVIGATION = [];
            $userID = Security::getUserId();
            $navigationData = self::getNavFromJson()["private"];
            foreach ($navigationData as $navEntry) {
                if (Security::isAuthorized($userID, $navEntry["id"], 'MNU')) {
                    $tmpNAVIGATION[] = $navEntry;
                }
            }
            $saveToSession = intval(Context::getContextByKey("DEVELOPMENT")) !== 1;
            Context::setContext("NAVIGATION", $tmpNAVIGATION, $saveToSession);
        }
    }

    public static function invalidateNavData()
    {
        Context::removeContextByKey("NAVIGATION_DATA");
        Context::removeContextByKey("NAVIGATION");
        Context::removeContextByKey("PUBLIC_NAVIGATION");
    }

    private static function getNavFromJson()
    {
        $jsonContent = Context::getContextByKey("NAVIGATION_DATA");
        if ($jsonContent === "") {
            $filePath = 'nav.config.json';
            if (!file_exists($filePath)) {
                throw new \Exception(sprintf('%s does not exist', $filePath));
            }
            if (!is_readable($filePath)) {
                throw new \Exception(sprintf('%s file is not readable', $filePath));
            }
            $jsonContent = file_get_contents($filePath);
            $saveToSession = intval(Context::getContextByKey("DEVELOPMENT")) !== 1;
            Context::setContext("NAVIGATION_DATA", $jsonContent, $saveToSession);
        }
        $jsonData = json_decode($jsonContent, true);
        return $jsonData;
    }

    private function __construct()
    {
    }
    private function __clone()
    {
    }
}
