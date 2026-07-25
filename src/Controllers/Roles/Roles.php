<?php

namespace Controllers\Roles;

use Controllers\PublicController;
use Dao\Roles\Roles as RolesDAO;
use Views\Renderer;

class Roles extends PublicController
{
    public function run(): void
    {
        $viewData = [];

        // Captura de filtros y paginación desde GET
        $viewData["partialName"] = $_GET["partialName"] ?? "";
        $viewData["status"] = $_GET["status"] ?? "";
        $viewData["orderBy"] = $_GET["orderBy"] ?? "rolescod";
        $viewData["orderDescending"] = isset($_GET["orderDescending"]) && $_GET["orderDescending"] === "true";
        $viewData["page"] = isset($_GET["page"]) ? intval($_GET["page"]) : 0;
        $viewData["itemsPerPage"] = isset($_GET["itemsPerPage"]) ? intval($_GET["itemsPerPage"]) : 10;

        // Búsqueda de datos mediante el DAO
        $rolesData = RolesDAO::getRoles(
            $viewData["partialName"],
            $viewData["status"],
            $viewData["orderBy"],
            $viewData["orderDescending"],
            $viewData["page"],
            $viewData["itemsPerPage"]
        );

        // Asignación de resultados a la vista
        $viewData["roles"] = $rolesData["roles"];
        $viewData["total"] = $rolesData["total"];

        // Renderizado de la plantilla
        Renderer::render("roles/roles", $viewData);
    }
}
?>