<?php

namespace Controllers\Mnt;

use Exception;
use Controllers\PublicController;
use Views\Renderer;
use Dao\Products\Products as ProductDAO;
use Utilities\Site;
use Utilities\Validators;

const LIST_VIEW_URI = "index.php?page=Mnt-ResultList";
const FORM_VIEW_URI = "index.php?page=Mnt-ResultForm";
const FORM_VIEW_TEMPLATE = "mnt/form";

const FORM_XSS_TOKEN = "result_form";


class ResultFrom extends PublicController
{
    private string $mode = "NAS"; 
    private array  $modes = [
        "INS" => "Creando Nuevo Producto",
        "UPD" => "Editar Producto %s - %s",
        "DEL" => "Eliminar Producto %s - %s",
        "DSP" => "Detalle de Producto %s - %s"
    ];
    private array $product = [
        "productId" => null,
        "productName" => "",
        "productDescription" => "",
        "productPrice" => 0,
        "productStock" => 0,
        "productImgUrl" => "",
        "productStatus" => "ACT"
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
                "Algo inesperado ocurrió, vuelva a intentar. Si el error persiste contacte con el administrador."
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
            $this->product["productId"] = intval($_GET["productId"] ?? 0);
            if ($this->product["productId"] == 0) {
                throw new Exception("ID es inválido.");
            }
            $productFromDb = ProductDAO::getProductById($this->product["productId"]);

            $this->product["productName"] = $productFromDb["productName"];
            $this->product["productDescription"] = $productFromDb["productDescription"];
            $this->product["productPrice"] = $productFromDb["productPrice"];
            $this->product["productStock"] = $productFromDb["productStock"];
            $this->product["productImgUrl"] = $productFromDb["productImgUrl"];
            $this->product["productStatus"] = $productFromDb["productStatus"];
        }
    }

    private function validarPostData(): bool
    {
        $tmp_mode = $_POST["mode"] ?? 'NAP';
        if (!isset($this->modes[$tmp_mode])) {
            throw new Exception("Error: modo no es válido");
        }

        $tmp_xssToken = $_POST["xssToken"] ?? 'NAP';
        $local_xssToken = $_SESSION[FORM_XSS_TOKEN] ?? 'NAP';
        if ($tmp_xssToken === 'NAP' || $local_xssToken === 'NAP' || $local_xssToken !== $tmp_xssToken) {
            throw new Exception("No pasó la prueba de XSS Script Forgery");
        }

        $productName = $_POST["productName"] ?? '';
        $productDescription = $_POST["productDescription"] ?? '';
        $productPrice = floatval($_POST["productPrice"] ?? '0');
        $productStock = intval($_POST["productStock"] ?? '0');
        $productImgUrl = $_POST["productImgUrl"] ?? '';
        $productStatus = $_POST["productStatus"] ?? 'ACT';

        if (Validators::IsEmpty($productName)) {
            $this->addViewError("Campo requiere de un valor", "productName");
        }
        if (Validators::IsEmpty($productDescription)) {
            $this->addViewError("Campo requiere de un valor", "productDescription");
        }
        if ($productPrice <= 0) {
            $this->addViewError("El precio debe ser mayor a cero", "productPrice");
        }
        if ($productStock < 0) {
            $this->addViewError("El stock no puede ser negativo", "productStock");
        }
        if (Validators::IsEmpty($productImgUrl)) {
            $this->addViewError("Campo requiere de un valor", "productImgUrl");
        }
        if (!in_array($productStatus, ["ACT", "INA"])) {
            $this->addViewError("Estado inválido", "productStatus");
        }

        $this->product["productName"] = $productName;
        $this->product["productDescription"] = $productDescription;
        $this->product["productPrice"] = $productPrice;
        $this->product["productStock"] = $productStock;
        $this->product["productImgUrl"] = $productImgUrl;
        $this->product["productStatus"] = $productStatus;

        return count($this->errors) <= 0;
    }

    private function procesarPost(): void
    {
        switch ($this->mode) {
            case "INS":
                if (ProductDAO::insertProduct(
                    $this->product["productName"],
                    $this->product["productDescription"],
                    $this->product["productPrice"],
                    $this->product["productImgUrl"],
                    $this->product["productStock"],
                    $this->product["productStatus"]
                ) > 0) {
                    Site::redirectToWithMsg(LIST_VIEW_URI, "Producto creado satisfactoriamente!");
                } else {
                    $this->addViewError("No se pudo insertar nuevo registro");
                }
                break;
            case "UPD":
                if (ProductDAO::updateProduct(
                    $this->product["productId"],
                    $this->product["productName"],
                    $this->product["productDescription"],
                    $this->product["productPrice"],
                    $this->product["productImgUrl"],
                    $this->product["productStock"],
                    $this->product["productStatus"]
                ) > 0) {
                    Site::redirectToWithMsg(LIST_VIEW_URI, "Producto actualizado satisfactoriamente!");
                } else {
                    $this->addViewError("No se actualizó registro");
                }
                break;
            case "DEL":
                if (ProductDAO::deleteProduct($this->product["productId"]) > 0) {
                    Site::redirectToWithMsg(LIST_VIEW_URI, "Producto eliminado satisfactoriamente!");
                } else {
                    $this->addViewError("No se eliminó registro");
                }
                break;
        }
    }

    private function mostrarVista()
    {
        $dataView = [];
        $dataView["mode"] = $this->mode;
        $dataView["modeDsc"] = ($this->mode === "INS") ?
            $this->modes[$this->mode]
            : sprintf(
                $this->modes[$this->mode],
                $this->product["productId"],
                $this->product["productName"]
            );
        $dataView["product"] = $this->product;

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

        Renderer::render(FORM_VIEW_TEMPLATE, $dataView);
    }

    private function generarXssToken()
    {
        $seed = rand(100000, 999999);
        $dateTime = microtime(true);
        $toHash = md5("product_form_token_" . $seed . $dateTime);
        $_SESSION[FORM_XSS_TOKEN] = $toHash;
        return $toHash;
    }

    private function addViewError($errormsg, $context = "global")
    {
        if (isset($this->errors[$context])) {
            $this->errors[$context][] = $errormsg;
        } else {
            $this->errors[$context] = [$errormsg];
        }
    }
}
?>