<?php

namespace Controllers\Roles;

use Controllers\PublicController;
use Dao\Roles\Roles as RolesDAO;
use Views\Renderer;
use Utilities\Validators;

class Rol extends PublicController
{
    private $mode = "DSP";
    private $modeDescriptions = [
        "INS" => "Nuevo Rol",
        "UPD" => "Editar Rol (%s)",
        "DEL" => "Eliminar Rol (%s)",
        "DSP" => "Detalle de Rol (%s)"
    ];

    private $rolescod = "";
    private $rolesdsc = "";
    private $rolesest = "ACT";

    private $hasErrors = false;
    private $errors = [];

    public function run(): void
    {
        $this->init();

        if ($this->isPostBack()) {
            $this->handlePost();
        }

        $this->render();
    }

    private function init()
    {
        if (isset($_GET["mode"])) {
            $this->mode = $_GET["mode"];
        }

        if (isset($_GET["rolescod"])) {
            $this->rolescod = $_GET["rolescod"];
        }

        if (!key_exists($this->mode, $this->modeDescriptions)) {
            \Utilities\Site::redirectToWithMsg(
                "index.php?page=Roles_Roles",
                "Modo no válido"
            );
        }

        if ($this->mode !== "INS") {
            $tmpRol = RolesDAO::getRolById($this->rolescod);
            if ($tmpRol) {
                $this->rolescod = $tmpRol["rolescod"];
                $this->rolesdsc = $tmpRol["rolesdsc"];
                $this->rolesest = $tmpRol["rolesest"];
            } else {
                \Utilities\Site::redirectToWithMsg(
                    "index.php?page=Roles_Roles",
                    "Registro no encontrado"
                );
            }
        }
    }

    private function handlePost()
    {
        $this->rolescod = $_POST["rolescod"] ?? "";
        $this->rolesdsc = $_POST["rolesdsc"] ?? "";
        $this->rolesest = $_POST["rolesest"] ?? "ACT";

        // Validaciones básicas
        if (Validators::isEmpty($this->rolescod)) {
            $this->errors["rolescod"] = "El código del rol es obligatorio.";
            $this->hasErrors = true;
        }

        if (Validators::isEmpty($this->rolesdsc)) {
            $this->errors["rolesdsc"] = "La descripción del rol es obligatoria.";
            $this->hasErrors = true;
        }

        if (!$this->hasErrors) {
            switch ($this->mode) {
                case "INS":
                    $result = RolesDAO::insertRol(
                        $this->rolescod,
                        $this->rolesdsc,
                        $this->rolesest
                    );
                    if ($result > 0) {
                        \Utilities\Site::redirectToWithMsg(
                            "index.php?page=Roles_Roles",
                            "Rol creado exitosamente."
                        );
                    }
                    break;

                case "UPD":
                    $result = RolesDAO::updateRol(
                        $this->rolescod,
                        $this->rolesdsc,
                        $this->rolesest
                    );
                    if ($result > 0) {
                        \Utilities\Site::redirectToWithMsg(
                            "index.php?page=Roles_Roles",
                            "Rol actualizado exitosamente."
                        );
                    }
                    break;

                case "DEL":
                    $result = RolesDAO::deleteRol($this->rolescod);
                    if ($result > 0) {
                        \Utilities\Site::redirectToWithMsg(
                            "index.php?page=Roles_Roles",
                            "Rol eliminado exitosamente."
                        );
                    }
                    break;
            }
        }
    }

    private function render()
    {
        $viewData = [];
        $viewData["mode"] = $this->mode;
        $viewData["modeDsc"] = sprintf(
            $this->modeDescriptions[$this->mode],
            $this->rolescod
        );

        $viewData["rolescod"] = $this->rolescod;
        $viewData["rolesdsc"] = $this->rolesdsc;
        $viewData["rolesest"] = $this->rolesest;

        // Banderas de estado para el formulario
        $viewData["readonly"] = ($this->mode === "DEL" || $this->mode === "DSP") ? "readonly" : "";
        $viewData["showBtn"] = ($this->mode !== "DSP");
        $viewData["isInsert"] = ($this->mode === "INS");

        $viewData["statusOptions"] = [
            ["value" => "ACT", "text" => "Activo", "selected" => $this->rolesest === "ACT" ? "selected" : ""],
            ["value" => "INA", "text" => "Inactivo", "selected" => $this->rolesest === "INA" ? "selected" : ""]
        ];

        $viewData["hasErrors"] = $this->hasErrors;
        $viewData["errors"] = $this->errors;

        Renderer::render("roles/rol", $viewData);
    }
}
?>