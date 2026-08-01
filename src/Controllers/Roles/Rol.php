<?php

namespace Controllers\Roles;

use Controllers\PublicController;
use Views\Renderer;
use Dao\Roles\Roles as RolesDao;
use Utilities\Site;
use Utilities\Validators;

class Rol extends PublicController
{
    private $viewData = [];
    private $mode = "INS";

    private $modeDescriptions = [
        "DSP" => "Detalle del Rol %s",
        "INS" => "Nuevo Rol",
        "UPD" => "Editar Rol %s",
        "DEL" => "Eliminar Rol %s"
    ];

    private $readonly = "";
    private $disabled = "";
    private $showCommitBtn = true;

    private $rol = [
        "rolescod" => "",
        "rolesdsc" => "",
        "rolesest" => "ACT"
    ];

    public function run(): void
    {
        try {
            $this->getData();

            if ($this->isPostBack()) {
                if ($this->validateData()) {
                    $this->handlePostAction();
                }
            }

            $this->setViewData();

            Renderer::render("roles/rol", $this->viewData);

        } catch (\Throwable $ex) {
            echo "<pre>";
            echo $ex->getMessage();
            echo "</pre>";
            die();
        }
    }

    private function getData()
    {
        $this->mode = strtoupper($_GET["mode"] ?? "INS");

        if (!array_key_exists($this->mode, $this->modeDescriptions)) {
            throw new \Exception("Modo inválido");
        }

        if ($this->mode === "DSP" || $this->mode === "DEL") {
            $this->readonly = "readonly";
            $this->disabled = "disabled";
        } else {
            $this->readonly = "";
            $this->disabled = "";
        }

$this->showCommitBtn = ($this->mode !== "DSP");

        if ($this->mode !== "INS") {
            $this->rol = RolesDao::getRolById($_GET["rolescod"] ?? "");

            if (!$this->rol) {
                throw new \Exception("Rol no encontrado");
            }
        }
    }

    private function validateData()
    {
        $errors = [];

        $this->rol["rolescod"] = $_POST["rolescod"] ?? "";
        $this->rol["rolesdsc"] = $_POST["rolesdsc"] ?? "";
        $this->rol["rolesest"] = $_POST["rolesest"] ?? "";

        if (Validators::IsEmpty($this->rol["rolescod"])) {
            $errors["rolescod_error"] = "Código requerido";
        }

        if (Validators::IsEmpty($this->rol["rolesdsc"])) {
            $errors["rolesdsc_error"] = "Descripción requerida";
        }

        if (!in_array($this->rol["rolesest"], ["ACT", "INA"])) {
            $errors["rolesest_error"] = "Estado inválido";
        }

        if (count($errors) > 0) {
            foreach ($errors as $k => $v) {
                $this->rol[$k] = $v;
            }
            return false;
        }

        return true;
    }

    private function handlePostAction()
    {
        switch ($this->mode) {
            case "INS":
                RolesDao::insertRol(
                    $this->rol["rolescod"],
                    $this->rol["rolesdsc"],
                    $this->rol["rolesest"]
                );
                break;

            case "UPD":
                RolesDao::updateRol(
                    $this->rol["rolescod"],
                    $this->rol["rolesdsc"],
                    $this->rol["rolesest"]
                );
                break;

            case "DEL":
                RolesDao::deleteRol($this->rol["rolescod"]);
                break;
        }

        Site::redirectToWithMsg(
            "index.php?page=Roles_Roles",
            "Operación realizada correctamente"
        );
    }

    private function setViewData(): void
    {
        $this->viewData["mode"] = $this->mode;

        $this->viewData["FormTitle"] =
            ($this->mode === "INS")
            ? "Nuevo Rol"
            : sprintf($this->modeDescriptions[$this->mode], $this->rol["rolescod"]);

        $this->viewData["showCommitBtn"] = $this->showCommitBtn;
        $this->viewData["readonly"] = $this->readonly;
        $this->viewData["disabled"] = $this->disabled;

        $this->rol["rolesest_act"] = ($this->rol["rolesest"] == "ACT") ? "selected" : "";
        $this->rol["rolesest_ina"] = ($this->rol["rolesest"] == "INA") ? "selected" : "";

        $this->viewData = array_merge($this->viewData, $this->rol);             }
}
?>