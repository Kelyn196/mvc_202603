<?php

namespace Controllers\Mnt;

use Exception;
use Controllers\PublicController;
use Views\Renderer;
use Dao\Mantenimientos\Products as ProductDAO;
use Utilities\Site;
use Utilities\Validators;

const LIST_VIEW_URI = "index.php?page=Mnt-ResultList";
const FORM_VIEW_URI = "index.php?page=Mnt-ProductForm";
const FORM_VIEW_TEMPLATE = "mnt/productform";

const FORM_XSS_TOKEN = "product_form";

class ProductForm extends PublicController
{
    private string $mode = "NAS";

    private array $modes = [
        "INS" => "Creando Nuevo Producto",
        "UPD" => "Editar Producto %s",
        "DEL" => "Eliminar Producto %s",
        "DSP" => "Producto %s"
    ];


    private array $producto = [
        "productId" => null,
        "productName" => "",
        "productDescription" => "",
        "productPrice" => 0,
        "productImgUrl" => "",
        "productStock" => 0,
        "productStatus" => "DISPO"
    ];


    private $errors = [];

    private $xssToken = "";


    public function run(): void
    {
        try {

            $this->getQueryParams();

            if ($this->isPostBack()) {

                $validado = $this->validarPostData();

                if ($validado) {
                    $this->procesarPost();
                }
            }


            $this->mostrarVista();


        } catch (Exception $ex) {

            error_log($ex->getMessage());

            Site::redirectToWithMsg(
                LIST_VIEW_URI,
                "Algo inesperado ocurrió, vuelva a intentar."
            );
        }
    }



    private function getQueryParams()
    {

        $this->mode = $_GET["mode"] ?? "NAS";


        if (!isset($this->modes[$this->mode])) {
            throw new Exception("Modo no adecuado");
        }


        if ($this->mode !== "INS") {


            $this->producto["productId"] = intval($_GET["id"] ?? 0);


            if ($this->producto["productId"] == 0) {
                throw new Exception("ID es invalido.");
            }


            $productoFromDb = ProductDAO::getById(
                $this->producto["productId"]
            );


            $this->producto["productName"] = $productoFromDb["productName"];
            $this->producto["productDescription"] = $productoFromDb["productDescription"];
            $this->producto["productPrice"] = $productoFromDb["productPrice"];
            $this->producto["productImgUrl"] = $productoFromDb["productImgUrl"];
            $this->producto["productStock"] = $productoFromDb["productStock"];
            $this->producto["productStatus"] = $productoFromDb["productStatus"];

        }

    }




    private function validarPostData(): bool
    {

        $tmp_mode = $_POST["mode"] ?? 'NAP';


        if (!isset($this->modes[$tmp_mode])) {
            throw new Exception("Error modo no válido");
        }



        $tmp_xssToken = $_POST["xssToken"] ?? 'NAP';


        if ($tmp_xssToken === 'NAP') {
            throw new Exception("No pasó la prueba XSS");
        }



        $local_xssToken = $_SESSION[FORM_XSS_TOKEN] ?? 'NAP';


        if ($local_xssToken === 'NAP') {
            throw new Exception("No pasó la prueba XSS");
        }



        if ($local_xssToken !== $tmp_xssToken) {
            throw new Exception("No pasó la prueba XSS");
        }



        $productName = $_POST["productName"] ?? "";
        $productDescription = $_POST["productDescription"] ?? "";
        $productPrice = floatval($_POST["productPrice"] ?? 0);
        $productImgUrl = $_POST["productImgUrl"] ?? "";
        $productStock = intval($_POST["productStock"] ?? 0);
        $productStatus = $_POST["productStatus"] ?? "DISPO";



        if (Validators::IsEmpty($productName)) {
            $this->addViewError(
                "Campo requiere un valor",
                "productName"
            );
        }


        if (Validators::IsEmpty($productDescription)) {
            $this->addViewError(
                "Campo requiere un valor",
                "productDescription"
            );
        }



        $this->producto["productName"] = $productName;
        $this->producto["productDescription"] = $productDescription;
        $this->producto["productPrice"] = $productPrice;
        $this->producto["productImgUrl"] = $productImgUrl;
        $this->producto["productStock"] = $productStock;
        $this->producto["productStatus"] = $productStatus;



        return count($this->errors) <= 0;

    }





    private function procesarPost(): void
    {

        switch ($this->mode) {


            case "INS":

                if (
                    ProductDAO::create(
                        $this->producto["productName"],
                        $this->producto["productDescription"],
                        $this->producto["productPrice"],
                        $this->producto["productImgUrl"],
                        $this->producto["productStock"],
                        $this->producto["productStatus"]
                    ) > 0
                ) {

                    Site::redirectToWithMsg(
                        LIST_VIEW_URI,
                        "Producto creado satisfactoriamente."
                    );

                } else {

                    $this->addViewError(
                        "No se pudo insertar producto."
                    );
                }


            break;



            case "UPD":


                if (
                    ProductDAO::update(
                        $this->producto["productId"],
                        $this->producto["productName"],
                        $this->producto["productDescription"],
                        $this->producto["productPrice"],
                        $this->producto["productImgUrl"],
                        $this->producto["productStock"],
                        $this->producto["productStatus"]
                    ) > 0
                ) {


                    Site::redirectToWithMsg(
                        LIST_VIEW_URI,
                        "Producto actualizado satisfactoriamente."
                    );


                } else {


                    $this->addViewError(
                        "No se actualizó producto."
                    );
                }


            break;




            case "DEL":


                if (
                    ProductDAO::delete(
                        $this->producto["productId"]
                    ) > 0
                ) {


                    Site::redirectToWithMsg(
                        LIST_VIEW_URI,
                        "Producto eliminado satisfactoriamente."
                    );


                } else {


                    $this->addViewError(
                        "No se eliminó producto."
                    );

                }


            break;

        }

    }





    private function mostrarVista()
    {

        $dataView = [];


        $dataView["mode"] = $this->mode;



        $dataView["modeDsc"] =
            ($this->mode === "INS") ?
            $this->modes[$this->mode]
            :
            sprintf(
                $this->modes[$this->mode],
                $this->producto["productName"]
            );



        $dataView["producto"] = $this->producto;



        if (count($this->errors)) {

            foreach ($this->errors as $scope => $errors) {

                $dataView['error_' . $scope] = $errors;

            }
        }



        if (in_array($this->mode, ["DSP", "DEL"])) {

            $dataView["readonly"] = "readonly";

        }

        $dataView["editable"] = ($this->mode !== "DSP");
        $dataView["xssToken"] = $this->generarXssToken();
        Renderer::render(
            FORM_VIEW_TEMPLATE,
            $dataView
        );

    }

    private function generarXssToken()
    {
        $seed = rand(100000,999999);
        $dateTime = microtime(true);
        $toHash = md5(
            "product_form_token_" . $seed . $dateTime
        );
        $_SESSION[FORM_XSS_TOKEN] = $toHash;
        return $toHash;

    }


    private function addViewError(
        $errormsg,
        $context = "global"
    )
    {

        if(isset($this->errors[$context])){

            $this->errors[$context][] = $errormsg;

        }else{

            $this->errors[$context] = [$errormsg];

        }

    }

}
?>