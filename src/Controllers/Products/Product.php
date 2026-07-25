<?php

namespace Controllers\Products;

use Controllers\PublicController;
use Views\Renderer;
use Dao\Products\Products as ProductsDao;
use Utilities\Site;
use Utilities\Validators;

class Product extends PublicController
{
    private $viewData = [];
    private $mode = "DSP";

    private $modeDescriptions = [
        "DSP" => "Detalle del Producto %s",
        "INS" => "Nuevo Producto",
        "UPD" => "Editar Producto %s",
        "DEL" => "Eliminar Producto %s"
    ];

    private $readonly = "";
    private $showCommitBtn = true;

    private $product = [
        "id_producto" => 0,
        "nombre" => "",
        "descripcion" => "",
        "precio_menor" => 0,
        "precio_mayor" => 0,
        "stock" => 0,
        "imagen" => "",
        "categoria" => ""
    ];

    private $product_xss_token = "";

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

            Renderer::render("products/product", $this->viewData);

        } catch (\Exception $ex) {
            Site::redirectToWithMsg(
                "index.php?page=Products_Products",
                $ex->getMessage()
            );
        }
    }

    private function getData()
    {
        $this->mode = $_GET["mode"] ?? "NOF";

        if (isset($this->modeDescriptions[$this->mode])) {

            $this->readonly = ($this->mode == "DEL") ? "readonly" : "";
            $this->showCommitBtn = ($this->mode != "DSP");

            if ($this->mode != "INS") {

                $this->product = ProductsDao::getProductById(
                    intval($_GET["id_producto"])
                );

                if (!$this->product) {
                    throw new \Exception("Producto no encontrado");
                }
            }

        } else {
            throw new \Exception("Modo inválido");
        }
    }

    private function validateData()
    {
        $errors = [];

        $this->product_xss_token = $_POST["product_xss_token"] ?? "";

        $this->product["id_producto"] = intval($_POST["id_producto"] ?? 0);
        $this->product["nombre"] = trim($_POST["nombre"] ?? "");
        $this->product["descripcion"] = trim($_POST["descripcion"] ?? "");
        $this->product["precio_menor"] = floatval($_POST["precio_menor"] ?? 0);
        $this->product["precio_mayor"] = floatval($_POST["precio_mayor"] ?? 0);
        $this->product["stock"] = intval($_POST["stock"] ?? 0);
        $this->product["imagen"] = trim($_POST["imagen"] ?? "");
        $this->product["categoria"] = trim($_POST["categoria"] ?? "");

        if (Validators::IsEmpty($this->product["nombre"])) {
            $errors["nombre_error"] = "Ingrese el nombre";
        }

        if (Validators::IsEmpty($this->product["descripcion"])) {
            $errors["descripcion_error"] = "Ingrese la descripción";
        }

        if ($this->product["precio_menor"] <= 0) {
            $errors["precio_menor_error"] = "Precio menor inválido";
        }

        if ($this->product["precio_mayor"] <= 0) {
            $errors["precio_mayor_error"] = "Precio mayor inválido";
        }

        if ($this->product["stock"] < 0) {
            $errors["stock_error"] = "Stock inválido";
        }

        if (Validators::IsEmpty($this->product["imagen"])) {
            $errors["imagen_error"] = "Ingrese la imagen";
        }

        if (Validators::IsEmpty($this->product["categoria"])) {
            $errors["categoria_error"] = "Ingrese la categoría";
        }

        if (count($errors) > 0) {

            foreach ($errors as $key => $value) {
                $this->product[$key] = $value;
            }

            return false;
        }

        return true;
    }

    private function handlePostAction()
    {
        switch ($this->mode) {

            case "INS":
                $this->handleInsert();
                break;

            case "UPD":
                $this->handleUpdate();
                break;

            case "DEL":
                $this->handleDelete();
                break;

            default:
                throw new \Exception("Modo inválido");
        }
    }

    private function handleInsert()
    {
        $result = ProductsDao::insertProduct(
            $this->product["nombre"],
            $this->product["descripcion"],
            $this->product["precio_menor"],
            $this->product["precio_mayor"],
            $this->product["stock"],
            $this->product["imagen"],
            $this->product["categoria"]
        );

        if ($result > 0) {
            Site::redirectToWithMsg(
                "index.php?page=Products_Products",
                "Producto agregado correctamente"
            );
        }
    }

    private function handleUpdate()
    {
        $result = ProductsDao::updateProduct(
            $this->product["id_producto"],
            $this->product["nombre"],
            $this->product["descripcion"],
            $this->product["precio_menor"],
            $this->product["precio_mayor"],
            $this->product["stock"],
            $this->product["imagen"],
            $this->product["categoria"]
        );

        if ($result > 0) {
            Site::redirectToWithMsg(
                "index.php?page=Products_Products",
                "Producto actualizado correctamente"
            );
        }
    }

    private function handleDelete()
    {
        $result = ProductsDao::deleteProduct(
            $this->product["id_producto"]
        );

        if ($result > 0) {
            Site::redirectToWithMsg(
                "index.php?page=Products_Products",
                "Producto eliminado correctamente"
            );
        }
    }

    private function setViewData(): void
    {
        $this->viewData["mode"] = $this->mode;
        $this->viewData["readonly"] = $this->readonly;
        $this->viewData["showCommitBtn"] = $this->showCommitBtn;
        $this->viewData["product_xss_token"] = $this->product_xss_token;

        $this->viewData["FormTitle"] = sprintf(
            $this->modeDescriptions[$this->mode],
            $this->product["nombre"]
        );

        $this->viewData["product"] = $this->product;
    }
}
?>