<?php

namespace Controllers\Roles;

use Controllers\PublicController;
use Utilities\Context;
use Utilities\Paging;
use Utilities\Security;
use Dao\Roles\Roles as DaoRoles;
use Views\Renderer;

class Roles extends PublicController
{
    private $partialName = "";
    private $status = "";
    private $orderBy = "";
    private $orderDescending = false;
    private $pageNumber = 1;
    private $itemsPerPage = 10;

    private $viewData = [];
    private $roles = [];
    private $rolesCount = 0;
    private $pages = 1;

    public function run(): void
    {
        $this->getParamsFromContext();
        $this->getParams();

        $tmpRoles = DaoRoles::getRoles(
            $this->partialName,
            $this->status,
            $this->orderBy,
            $this->orderDescending,
            $this->pageNumber - 1,
            $this->itemsPerPage

        );

        $this->roles = $tmpRoles["roles"] ?? [];
        $this->rolesCount = $tmpRoles["total"] ?? 0;

        $this->pages = max(1, ceil($this->rolesCount / $this->itemsPerPage));

        if ($this->pageNumber > $this->pages) {
            $this->pageNumber = $this->pages;
        }

        $this->setParamsToContext();
        $this->setParamsToDataView();

        Renderer::render("roles/roles", $this->viewData);
    }

    private function getParams(): void
    {
        $this->partialName = $_GET["partialName"] ?? "";
        $this->status = $_GET["status"] ?? "";
        if (!in_array($this->status, ["ACT", "INA"])) {
            $this->status = "";
        }

        $this->orderBy = $_GET["orderBy"] ?? "rolescod";
        $this->orderDescending = isset($_GET["orderDescending"]);

        $this->pageNumber = max(1, intval($_GET["pageNum"] ?? 1));
        $this->itemsPerPage = intval($_GET["itemsPerPage"] ?? 10);
    }

    private function getParamsFromContext(): void
    {
        $this->partialName = Context::getContextByKey("roles_partialName") ?? "";
        $this->status = Context::getContextByKey("roles_status") ?? "";
        $this->orderBy = Context::getContextByKey("roles_orderBy") ?? "rolescod";
        $this->orderDescending = boolval(Context::getContextByKey("roles_orderDescending"));
        $this->pageNumber = intval(Context::getContextByKey("roles_page") ?? 1);
        $this->itemsPerPage = intval(Context::getContextByKey("roles_itemsPerPage") ?? 10);
    }

    private function setParamsToContext(): void
    {
        Context::setContext("roles_partialName", $this->partialName, true);
        Context::setContext("roles_status", $this->status, true);
        Context::setContext("roles_orderBy", $this->orderBy, true);
        Context::setContext("roles_orderDescending", $this->orderDescending, true);
        Context::setContext("roles_page", $this->pageNumber, true);
        Context::setContext("roles_itemsPerPage", $this->itemsPerPage, true);
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
            "roles" => $this->roles,
            "rolesCount" => $this->rolesCount,
            "pages" => $this->pages,

            "isLogged" => Security::isLogged()

        ];

        if ($this->orderBy != "") {
            $key = "Order" . ucfirst($this->orderBy);
            $keyDesc = "OrderBy" . ucfirst($this->orderBy);

            $this->viewData[$keyDesc] = true;

            if ($this->orderDescending) {
                $key .= "Desc";
            }

            $this->viewData[$key] = true;
        }

        $statusKey = "status_" . ($this->status == "" ? "EMP" : $this->status);
        $this->viewData[$statusKey] = "selected";

        $this->viewData["pagination"] = Paging::getPagination(
            $this->rolesCount,
            $this->itemsPerPage,
            $this->pageNumber,
            "index.php?page=Roles_Roles",
            "Roles_Roles"
        );
    }
}
?>
