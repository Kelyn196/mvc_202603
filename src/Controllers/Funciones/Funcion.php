<?php

namespace Controllers\Funciones;

use Controllers\PublicController;
use Dao\Funciones\Funciones as FuncionesDAO;
use Utilities\Site;
use Utilities\Validators;
use Views\Renderer;

class Funcion extends PublicController
{
    private array $viewData = [];
    private string $mode = "INS";

    private array $modeDescriptions = [
        "INS" => "Nueva Función",
        "UPD" => "Editar Función %s",
        "DEL" => "Eliminar Función %s",
        "DSP" => "Detalle de la Función %s"
    ];

    private string $readonly = "";
    private bool $showCommitBtn = true;

    private array $funcion = [
        "fncod" => "",
        "fndsc" => "",
        "fnest" => "ACT",
        "fntyp" => "MEN"
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

            Renderer::render("funciones/funcion", $this->viewData);

        } catch (\Exception $ex) {

            Site::redirectToWithMsg(
                "index.php?page=Funciones_Funciones",
                $ex->getMessage()
            );
        }
    }

    private function getData(): void
    {
        $this->mode = $_GET["mode"] ?? "INS";

        if (!isset($this->modeDescriptions[$this->mode])) {
            throw new \Exception("Modo inválido");
        }

        $this->readonly = ($this->mode == "DSP" || $this->mode == "DEL")
            ? "readonly"
            : "";

        $this->showCommitBtn = ($this->mode == "INS" || $this->mode == "UPD");

        if ($this->mode != "INS") {

            $fncod = $_GET["fncod"] ?? "";

            if (Validators::IsEmpty($fncod)) {
                throw new \Exception("Código de función no recibido.");
            }

            $this->funcion = FuncionesDAO::getFuncionById($fncod);

            if (!$this->funcion) {
                throw new \Exception("La función no existe.");
            }
        }
    }

    private function validateData(): bool
    {
        $errors = [];

        $this->funcion["fncod"] = trim($_POST["fncod"] ?? "");
        $this->funcion["fndsc"] = trim($_POST["fndsc"] ?? "");
        $this->funcion["fnest"] = $_POST["fnest"] ?? "";
        $this->funcion["fntyp"] = $_POST["fntyp"] ?? "";

        if (Validators::IsEmpty($this->funcion["fncod"])) {
            $errors["fncod_error"] = "El código es requerido.";
        }

        if (Validators::IsEmpty($this->funcion["fndsc"])) {
            $errors["fndsc_error"] = "La descripción es requerida.";
        }

        if (!in_array($this->funcion["fnest"], ["ACT", "INA"])) {
            $errors["fnest_error"] = "Estado inválido.";
        }

        if (!in_array($this->funcion["fntyp"], ["MEN", "API"])) {
            $errors["fntyp_error"] = "Tipo inválido.";
        }

        foreach ($errors as $key => $value) {
            $this->funcion[$key] = $value;
        }

        return count($errors) === 0;
    }

    private function handlePostAction(): void
    {
        switch ($this->mode) {

            case "INS":

                FuncionesDAO::insertFuncion(
                    $this->funcion["fncod"],
                    $this->funcion["fndsc"],
                    $this->funcion["fnest"],
                    $this->funcion["fntyp"]
                );

                break;

            case "UPD":

                FuncionesDAO::updateFuncion(
                    $this->funcion["fncod"],
                    $this->funcion["fndsc"],
                    $this->funcion["fnest"],
                    $this->funcion["fntyp"]
                );

                break;

            case "DEL":

                FuncionesDAO::deleteFuncion(
                    $this->funcion["fncod"]
                );

                break;
        }

        Site::redirectToWithMsg(
            "index.php?page=Funciones_Funciones",
            "Operación realizada correctamente."
        );
    }

    private function setViewData(): void
    {
        $this->viewData["mode"] = $this->mode;
        $this->viewData["readonly"] = $this->readonly;
        $this->viewData["showCommitBtn"] = $this->showCommitBtn;

        $this->viewData["FormTitle"] = sprintf(
            $this->modeDescriptions[$this->mode],
            $this->funcion["fncod"]
        );

        $this->funcion["fnest_ACT"] =($this->funcion["fnest"] == "ACT") ? "selected" : "";
        $this->funcion["fnest_INA"] =($this->funcion["fnest"] == "INA") ? "selected" : "";
        
        $this->funcion["fntyp_MEN"] =($this->funcion["fntyp"] == "MEN") ? "selected" : "";
        $this->funcion["fntyp_API"] =($this->funcion["fntyp"] == "API") ? "selected" : "";
        
        $this->viewData = array_merge($this->viewData, $this->funcion);
}
}
?>