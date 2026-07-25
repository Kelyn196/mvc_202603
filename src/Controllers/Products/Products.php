<?php

namespace Controllers\Products;

use Controllers\PublicController;
use Utilities\Context;
use Utilities\Paging;
use Dao\Products\Products as DaoProducts;
use Views\Renderer;

class Products extends PublicController
{
    private $partialName = "";
    private $categoria = "";
    private $orderBy = "";
    private $orderDescending = false;
    private $pageNumber = 1;
    private $itemsPerPage = 10;

    private $viewData = [];
    private $products = [];
    private $productsCount = 0;
    private $pages = 0;

    public function run(): void
    {
        $this->getParamsFromContext();
        $this->getParams();

        $tmpProducts = DaoProducts::getProducts(
            $this->partialName,
            $this->categoria,
            $this->orderBy,
            $this->orderDescending,
            $this->pageNumber - 1,
            $this->itemsPerPage
        );

        $this->products = $tmpProducts["products"];
        $this->productsCount = $tmpProducts["total"];

        $this->pages = ($this->productsCount > 0)
            ? ceil($this->productsCount / $this->itemsPerPage)
            : 1;

        if ($this->pageNumber > $this->pages) {
            $this->pageNumber = $this->pages;
        }

        $this->setParamsToContext();
        $this->setParamsToDataView();

        Renderer::render("products/products", $this->viewData);
    }

    private function getParams(): void
    {
        $this->partialName = $_GET["partialName"] ?? $this->partialName;

        $this->categoria = $_GET["categoria"] ?? $this->categoria;

        if ($this->categoria == "TODAS") {
            $this->categoria = "";
        }

        $this->orderBy = isset($_GET["orderBy"])
            ? $_GET["orderBy"]
            : $this->orderBy;

        if ($this->orderBy == "clear") {
            $this->orderBy = "";
        }

        if (
            !in_array(
                $this->orderBy,
                [
                    "",
                    "id_producto",
                    "nombre",
                    "precio_menor",
                    "precio_mayor",
                    "stock"
                ]
            )
        ) {
            $this->orderBy = "";
        }

        $this->orderDescending = isset($_GET["orderDescending"])
            ? boolval($_GET["orderDescending"])
            : $this->orderDescending;

        $this->pageNumber = isset($_GET["pageNum"])
            ? intval($_GET["pageNum"])
            : $this->pageNumber;

        $this->itemsPerPage = isset($_GET["itemsPerPage"])
            ? intval($_GET["itemsPerPage"])
            : $this->itemsPerPage;
    }

    private function getParamsFromContext(): void
    {
        $this->partialName = Context::getContextByKey("products_partialName");

        $this->categoria = Context::getContextByKey("products_categoria");

        $this->orderBy = Context::getContextByKey("products_orderBy");

        $this->orderDescending = boolval(
            Context::getContextByKey("products_orderDescending")
        );

        $this->pageNumber = intval(
            Context::getContextByKey("products_page")
        );

        $this->itemsPerPage = intval(
            Context::getContextByKey("products_itemsPerPage")
        );

        if ($this->pageNumber < 1) {
            $this->pageNumber = 1;
        }

        if ($this->itemsPerPage < 1) {
            $this->itemsPerPage = 10;
        }
    }

    private function setParamsToContext(): void
    {
        Context::setContext(
            "products_partialName",
            $this->partialName,
            true
        );

        Context::setContext(
            "products_categoria",
            $this->categoria,
            true
        );

        Context::setContext(
            "products_orderBy",
            $this->orderBy,
            true
        );

        Context::setContext(
            "products_orderDescending",
            $this->orderDescending,
            true
        );

        Context::setContext(
            "products_page",
            $this->pageNumber,
            true
        );

        Context::setContext(
            "products_itemsPerPage",
            $this->itemsPerPage,
            true
        );
    }

    private function setParamsToDataView(): void
    {
        $this->viewData["partialName"] = $this->partialName;
        $this->viewData["categoria"] = $this->categoria;
        $this->viewData["orderBy"] = $this->orderBy;
        $this->viewData["orderDescending"] = $this->orderDescending;
        $this->viewData["pageNum"] = $this->pageNumber;
        $this->viewData["itemsPerPage"] = $this->itemsPerPage;

        $this->viewData["productsCount"] = $this->productsCount;
        $this->viewData["pages"] = $this->pages;
        $this->viewData["products"] = $this->products;

        if ($this->orderBy != "") {

        switch ($this->orderBy) {

            case "id_producto":
                $orderByKey = "OrderId_producto";
                $orderByKeyNoOrder = "OrderById_producto";
                break;

            case "nombre":
                $orderByKey = "OrderNombre";
                $orderByKeyNoOrder = "OrderByNombre";
                break;

            case "precio_menor":
                $orderByKey = "OrderPrecio_menor";
                $orderByKeyNoOrder = "OrderByPrecio_menor";
                break;

            case "precio_mayor":
                $orderByKey = "OrderPrecio_mayor";
                $orderByKeyNoOrder = "OrderByPrecio_mayor";
                break;

            case "stock":
                $orderByKey = "OrderStock";
                $orderByKeyNoOrder = "OrderByStock";
                break;

            default:
                $orderByKey = "";
                $orderByKeyNoOrder = "";
                break;
        }

        if ($orderByKey != "") {

            $this->viewData[$orderByKeyNoOrder] = true;

            if ($this->orderDescending) {
                $orderByKey .= "Desc";
            }

            $this->viewData[$orderByKey] = true;
        }
        }   
        $this->viewData["categoria_" . ($this->categoria == "" ? "TODAS" : $this->categoria)] = "selected";

        $pagination = Paging::getPagination(
            $this->productsCount,
            $this->itemsPerPage,
            $this->pageNumber,
            "index.php?page=Products_Products",
            "Products_Products"
        );

        $this->viewData["pagination"] = $pagination;
    }
}