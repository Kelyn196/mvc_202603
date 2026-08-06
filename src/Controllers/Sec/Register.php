<?php

namespace Controllers\Sec;

use Controllers\PublicController;
use \Utilities\Validators;
use Exception;

class Register extends PublicController
{
    private $txtEmail = "";
    private $txtUsername = "";
    private $txtPswd = "";
    private $txttipousuario = "";

    private $errorEmail = "";
    private $errorUsername = "";
    private $errorPswd = "";
    private $errortipousuario = "";

    private $hasErrors = false;

    public function run(): void
    {

        if ($this->isPostBack()) {

            $this->txtEmail = $_POST["txtEmail"] ?? "";
            $this->txtUsername = $_POST["txtUsername"] ?? "";
            $this->txtPswd = $_POST["txtPswd"] ?? "";
            $this->txttipousuario = $_POST["txttipousuario"] ?? "";

            // Validaciones

            if (!(Validators::IsValidEmail($this->txtEmail))) {
                $this->errorEmail = "El correo no tiene el formato adecuado";
                $this->hasErrors = true;
            }

            if (Validators::IsEmpty($this->txtUsername)) {
                $this->errorUsername = "El nombre de usuario es requerido";
                $this->hasErrors = true;
            }

            if (!Validators::IsValidPassword($this->txtPswd)) {
                $this->errorPswd = "La contraseña debe tener al menos 8 caracteres una mayúscula, un número y un caracter especial.";
                $this->hasErrors = true;
            }

            if (!in_array($this->txttipousuario, ["ADM", "SUP", "EMP", "CLI"])) {
                $this->errortipousuario = "Tipo de usuario inválido";
                $this->hasErrors = true;
            }


            if (!$this->hasErrors) {

                try {

                    if (\Dao\Security\Security::newUsuario(
                        $this->txtEmail,
                        $this->txtUsername,
                        $this->txtPswd,
                        $this->txttipousuario
                    )) {

                        \Utilities\Site::redirectToWithMsg(
                            "index.php?page=sec_login",
                            "¡Usuario Registrado Satisfactoriamente!"
                        );

                    }

                } catch (Error $ex) {
                    die($ex);
                }
            }
        }


        $viewData = get_object_vars($this);

        \Views\Renderer::render(
            "security/sigin",
            $viewData
        );
    }
}
?>