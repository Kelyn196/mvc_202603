<?php

namespace Controllers\Funciones;

use Controllers\PublicController;
use Dao\Funciones\Funciones as FuncionesDAO;
use Utilities\Context;
use Utilities\Paging;
use Views\Renderer;

class Funciones extends PublicController
{
    private string $partialName = "";
    private string $status = "";
    private string $orderBy = "";
    private bool $orderDescending = false;
    private int $pageNumber = 1;
    private int $itemsPerPage = 10;

    private array $viewData = [];
    private array $funciones = [];
    private int $funcionesCount = 0;
    private int $pages = 1;

    public function run(): void
    {
        $this->getParamsFromContext();
        $this->getParams();

        $result = FuncionesDAO::getFunciones(
            $this->partialName,
            $this->status,
            $this->orderBy,
            $this->orderDescending,
            $this->pageNumber - 1,
            $this->itemsPerPage
        );

        $this->funciones = $result["funciones"] ?? [];
        $this->funcionesCount = $result["total"] ?? 0;

        $this->pages = max(
            1,
            intval(ceil($this->funcionesCount / $this->itemsPerPage))
        );

        if ($this->pageNumber > $this->pages) {
            $this->pageNumber = $this->pages;
        }

        $this->setParamsToContext();
        $this->setParamsToViewData();

        Renderer::render(
            "funciones/funciones",
            $this->viewData
        );
    }

    private function getParams(): void
    {
        $this->partialName = $_GET["partialName"] ?? "";
        $this->status = $_GET["status"] ?? "";

        if ($this->status === "EMP") {
            $this->status = "";
        }

        $this->orderBy = $_GET["orderBy"] ?? "";
        $this->orderDescending = isset($_GET["orderDescending"]);

        $this->pageNumber = max(
            1,
            intval($_GET["pageNum"] ?? $this->pageNumber)
        );

        $this->itemsPerPage = intval(
            $_GET["itemsPerPage"] ?? $this->itemsPerPage
        );
    }

    private function getParamsFromContext(): void
    {
        $this->partialName = Context::getContextByKey("funciones_partialName") ?? "";
        $this->status = Context::getContextByKey("funciones_status") ?? "";
        $this->orderBy = Context::getContextByKey("funciones_orderBy") ?? "";
        $this->orderDescending = boolval(
            Context::getContextByKey("funciones_orderDescending")
        );
        $this->pageNumber = intval(
            Context::getContextByKey("funciones_page") ?? 1
        );
        $this->itemsPerPage = intval(
            Context::getContextByKey("funciones_itemsPerPage") ?? 10
        );
    }

    private function setParamsToContext(): void
    {
        Context::setContext("funciones_partialName",$this->partialName,true);
        Context::setContext("funciones_status",$this->status,true);
        Context::setContext("funciones_orderBy",$this->orderBy,true);
        Context::setContext("funciones_orderDescending",$this->orderDescending,true);
        Context::setContext("funciones_page",$this->pageNumber,true);
        Context::setContext("funciones_itemsPerPage",$this->itemsPerPage,true);
    }

    private function setParamsToViewData(): void
    {
        $this->viewData = [
            "partialName" => $this->partialName,
            "status" => $this->status,
            "orderBy" => $this->orderBy,
            "orderDescending" => $this->orderDescending,
            "pageNum" => $this->pageNumber,
            "itemsPerPage" => $this->itemsPerPage,
            "funcionesCount" => $this->funcionesCount,
            "pages" => $this->pages,
            "funciones" => $this->funciones
        ];

        $this->viewData["pagination"] = Paging::getPagination(
            $this->funcionesCount,
            $this->itemsPerPage,
            $this->pageNumber,
            "index.php?page=Funciones_Funciones",
            "Funciones_Funciones"
        );
    }
}
?>