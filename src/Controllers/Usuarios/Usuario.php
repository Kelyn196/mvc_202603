<?php

namespace Controllers\Usuarios;

use Controllers\PublicController;
use Dao\Usuarios\Usuarios as UsuariosDAO;
use Utilities\Site;
use Utilities\Validators;
use Views\Renderer;

class Usuario extends PublicController
{
    private $viewData = [];
    private $mode = "DSP";

    private $modeDescriptions = [
        "DSP" => "Detalle del Usuario %s",
        "INS" => "Nuevo Usuario",
        "UPD" => "Editar Usuario %s",
        "DEL" => "Eliminar Usuario %s"
    ];

    private $readonly = "";
    private $showCommitBtn = true;

    private $usuario = [
        "usercod" => 0,
        "useremail" => "",
        "username" => "",
        "userpswd" => "",
        "userfching" => "",
        "userpswdest" => "VIG",
        "userpswdexp" => "",
        "userest" => "ACT",
        "useractcod" => "",
        "userpswdchg" => "",
        "usertipo" => "NOR"
    ];

    private $usuario_xss_token = "";

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

            Renderer::render(
                "usuarios/usuario",
                $this->viewData
            );

        } catch (\Exception $ex) {

            Site::redirectToWithMsg(
                "index.php?page=Usuarios_Usuarios",
                $ex->getMessage()
            );

        }
    }

    private function getData()
    {
        $this->mode = $_GET["mode"] ?? "NOF";

        if (!isset($this->modeDescriptions[$this->mode])) {
            throw new \Exception(
                "Formulario cargado en modalidad inválida"
            );
        }

        $this->readonly = ($this->mode == "DSP" || $this->mode == "DEL") ? "readonly" : "";
        $this->showCommitBtn = ($this->mode != "DSP");

        if ($this->mode != "INS") {

            $this->usuario = UsuariosDAO::getUsuarioById(
                intval($_GET["usercod"] ?? 0)
            );

            if (!$this->usuario) {
                throw new \Exception(
                    "No se encontró el Usuario"
                );
            }
        }
    }

    private function validateData()
    {
        $errors = [];

        $this->usuario_xss_token = $_POST["usuario_xss_token"] ?? "";

        $this->usuario["usercod"] = intval($_POST["usercod"] ?? 0);
        $this->usuario["useremail"] = strval($_POST["useremail"] ?? "");
        $this->usuario["username"] = strval($_POST["username"] ?? "");
        $this->usuario["userpswd"] = strval($_POST["userpswd"] ?? "");
        $this->usuario["userfching"] = strval($_POST["userfching"] ?? "");
        $this->usuario["userpswdest"] = strval($_POST["userpswdest"] ?? "");
        $this->usuario["userpswdexp"] = strval($_POST["userpswdexp"] ?? "");
        $this->usuario["userest"] = strval($_POST["userest"] ?? "");
        $this->usuario["useractcod"] = strval($_POST["useractcod"] ?? "");
        $this->usuario["userpswdchg"] = strval($_POST["userpswdchg"] ?? "");
        $this->usuario["usertipo"] = strval($_POST["usertipo"] ?? "");

        if (Validators::IsEmpty($this->usuario["useremail"])) {
            $errors["useremail_error"] = "El correo electrónico es requerido";
        }

        if (Validators::IsEmpty($this->usuario["username"])) {
            $errors["username_error"] = "El nombre del usuario es requerido";
        }

        if ($this->mode == "INS") {
            if (Validators::IsEmpty($this->usuario["userpswd"])) {
                $errors["userpswd_error"] = "La contraseña es requerida";
            }
        }

        if (!in_array($this->usuario["userest"], ["ACT", "INA"])) {
            $errors["userest_error"] = "Estado inválido";
        }

        if (!in_array($this->usuario["usertipo"], ["NOR", "CON", "CLI"])) {
            $errors["usertipo_error"] = "Tipo de usuario inválido";
        }

        if (count($errors) > 0) {
            foreach ($errors as $key => $value) {
                $this->usuario[$key] = $value;
            }
            return false;
        }

        return true;
    }

    private function handlePostAction()
    {
        switch ($this->mode) {

            case "INS":
                $result = UsuariosDAO::insertUsuario(
                    $this->usuario["useremail"],
                    $this->usuario["username"],
                    $this->usuario["userpswd"],
                    $this->usuario["userfching"],
                    $this->usuario["userpswdest"],
                    $this->usuario["userpswdexp"],
                    $this->usuario["userest"],
                    $this->usuario["useractcod"],
                    $this->usuario["userpswdchg"],
                    $this->usuario["usertipo"]
                );
                break;

            case "UPD":
                $result = UsuariosDAO::updateUsuario(
                    $this->usuario["usercod"],
                    $this->usuario["useremail"],
                    $this->usuario["username"],
                    $this->usuario["userpswd"],
                    $this->usuario["userfching"],
                    $this->usuario["userpswdest"],
                    $this->usuario["userpswdexp"],
                    $this->usuario["userest"],
                    $this->usuario["useractcod"],
                    $this->usuario["userpswdchg"],
                    $this->usuario["usertipo"]
                );
                break;

            case "DEL":
                $result = UsuariosDAO::deleteUsuario(
                    $this->usuario["usercod"]
                );
                break;

            default:
                throw new \Exception("Modo inválido");
        }

        if ($result > 0) {
            Site::redirectToWithMsg(
                "index.php?page=Usuarios_Usuarios",
                "Operación realizada correctamente"
            );
        }

        throw new \Exception(
            "Ocurrió un error al procesar la operación"
        );
    }

    private function setViewData(): void
    {
        $this->viewData = $this->usuario;

        $this->viewData["mode"] = $this->mode;
        $this->viewData["readonly"] = $this->readonly;
        $this->viewData["showCommitBtn"] = $this->showCommitBtn;
        $this->viewData["usuario_xss_token"] = $this->usuario_xss_token;

        $this->viewData["FormTitle"] = sprintf(
            $this->modeDescriptions[$this->mode],
            $this->usuario["usercod"]
        );

        $this->viewData["userest_ACT"] = "";
        $this->viewData["userest_INA"] = "";

        if (isset($this->viewData["userest"])) {
            $this->viewData["userest_" . $this->viewData["userest"]] = "selected";
        }

        $this->viewData["usertipo_NOR"] = "";
        $this->viewData["usertipo_CON"] = "";
        $this->viewData["usertipo_CLI"] = "";

        if (isset($this->viewData["usertipo"])) {
            $this->viewData["usertipo_" . $this->viewData["usertipo"]] = "selected";
        }
    }
}
?>