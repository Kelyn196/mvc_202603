<?php

namespace Controllers\Usuarios;

use Controllers\PublicController;
use Utilities\Context;
use Utilities\Paging;
use Dao\Usuarios\Usuarios as DaoUsuarios;
use Views\Renderer;

class Usuarios extends PublicController
{
    private $partialName = "";
    private $status = "";
    private $orderBy = "";
    private $orderDescending = false;
    private $pageNumber = 1;
    private $itemsPerPage = 10;

    private $viewData = [];
    private $usuarios = [];
    private $usuariosCount = 0;
    private $pages = 1;

    public function run(): void
    {
        $this->getParamsFromContext();
        $this->getParams();

        $tmpUsuarios = DaoUsuarios::getUsuarios(
            $this->partialName,
            $this->status,
            $this->orderBy,
            $this->orderDescending,
            $this->pageNumber - 1,
            $this->itemsPerPage
        );

        $this->usuarios = $tmpUsuarios["usuarios"] ?? [];
        $this->usuariosCount = $tmpUsuarios["total"] ?? 0;

        $this->pages = max(
            1,
            ceil($this->usuariosCount / $this->itemsPerPage)
        );

        if ($this->pageNumber > $this->pages) {
            $this->pageNumber = $this->pages;
        }

        $this->setParamsToContext();
        $this->setParamsToDataView();

        Renderer::render(
            "usuarios/usuarios",
            $this->viewData
        );
    }

    private function getParams(): void
    {
        $this->partialName = $_GET["partialName"] ?? $this->partialName;

        $this->status = $_GET["status"] ?? $this->status;

        if ($this->status == "EMP") {
            $this->status = "";
        }

        $this->orderBy = $_GET["orderBy"] ?? $this->orderBy;

        if ($this->orderBy == "clear") {
            $this->orderBy = "";
        }

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
        $this->partialName = Context::getContextByKey("usuarios_partialName") ?? "";
        $this->status = Context::getContextByKey("usuarios_status") ?? "";
        $this->orderBy = Context::getContextByKey("usuarios_orderBy") ?? "";
        $this->orderDescending = boolval(
            Context::getContextByKey("usuarios_orderDescending")
        );
        $this->pageNumber = intval(
            Context::getContextByKey("usuarios_page") ?? 1
        );
        $this->itemsPerPage = intval(
            Context::getContextByKey("usuarios_itemsPerPage") ?? 10
        );
    }

    private function setParamsToContext(): void
    {
        Context::setContext(
            "usuarios_partialName",
            $this->partialName,
            true
        );

        Context::setContext(
            "usuarios_status",
            $this->status,
            true
        );

        Context::setContext(
            "usuarios_orderBy",
            $this->orderBy,
            true
        );

        Context::setContext(
            "usuarios_orderDescending",
            $this->orderDescending,
            true
        );

        Context::setContext(
            "usuarios_page",
            $this->pageNumber,
            true
        );

        Context::setContext(
            "usuarios_itemsPerPage",
            $this->itemsPerPage,
            true
        );
    }

    private function setParamsToDataView(): void
    {
        $this->viewData = [
            "partialName" => $this->partialName,
            "status" => $this->status,
            "orderBy" => $this->orderBy,
            "orderDescending" => $this->orderDescending,
            "pageNum" => $this->pageNumber,
            "itemsPerPage" => $this->itemsPerPage,
            "usuariosCount" => $this->usuariosCount,
            "pages" => $this->pages,
            "usuarios" => $this->usuarios
        ];

        if ($this->orderBy != "") {

            $orderByKey = "Order" . ucfirst($this->orderBy);
            $orderByKeyNoOrder = "OrderBy" . ucfirst($this->orderBy);

            $this->viewData[$orderByKeyNoOrder] = true;

            if ($this->orderDescending) {
                $orderByKey .= "Desc";
            }

            $this->viewData[$orderByKey] = true;
        }

        $statusKey = "status_" . ($this->status == "" ? "EMP" : $this->status);
        $this->viewData[$statusKey] = "selected";

        $this->viewData["pagination"] = Paging::getPagination(
            $this->usuariosCount,
            $this->itemsPerPage,
            $this->pageNumber,
            "index.php?page=Usuarios_Usuarios",
            "Usuarios_Usuarios"
        );
    }
}
?>