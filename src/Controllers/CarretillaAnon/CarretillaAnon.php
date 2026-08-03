<?php

namespace Controllers\CarretillaAnon;

use Controllers\PublicController;
use Views\Renderer;
use Dao\CarretillaAnon\CarretillaAnon as DaoCarretillaAnon;
use Dao\Products\Products as DaoProducts;
use Utilities\Site;

class CarretillaAnon extends PublicController
{
    private $viewData = [];

    public function run(): void
    {
        // Crear identificador anónimo si no existe
        if (!isset($_SESSION["anoncod"])) {
            $_SESSION["anoncod"] = bin2hex(random_bytes(32));
        }

        $anoncod = $_SESSION["anoncod"];

        $action = $_GET["action"] ?? $_POST["action"] ?? "VIEW";

        // Procesar acciones
        if ($this->isPostBack() || isset($_GET["action"])) {

            $productId = intval($_POST["productId"] ?? $_GET["productId"] ?? 0);

            switch ($action) {

                case "ADD":

                    $crrctd = intval($_POST["crrctd"] ?? 1);
                    $product = DaoProducts::getProductById($productId);

                    if ($product && $product["productStatus"] === "DISPO") {
                        DaoCarretillaAnon::addToCarretilla($anoncod, $productId, $crrctd, $product["productPrice"]);
                        Site::redirectToWithMsg(
                            "index.php?page=Products_Products",
                            "Producto agregado a la carretilla."
                        );
                    }

                    break;

                case "UPD":

                    if (
                        isset($_POST["items"]) &&
                        is_array($_POST["items"])
                    ) {

                        foreach ($_POST["items"] as $item) {

                            $pid = intval($item["productId"]);
                            $qty = intval($item["crrctd"]);

                            DaoCarretillaAnon::updateQuantity(
                                $anoncod,
                                $pid,
                                $qty
                            );
                        }
                    }

                    Site::redirectTo(
                        "index.php?page=CarretillaAnon_CarretillaAnon"
                    );

                    break;

                case "DEL":

                    DaoCarretillaAnon::removeFromCarretilla(
                        $anoncod,
                        $productId
                    );

                    Site::redirectToWithMsg(
                        "index.php?page=CarretillaAnon_CarretillaAnon",
                        "Producto eliminado de la carretilla."
                    );

                    break;
            }
        }

        // Obtener productos de la carretilla
        $items = DaoCarretillaAnon::getCarretillaByAnon($anoncod);

        $totalGeneral = 0;

        foreach ($items as &$item) {

            $item["subtotal"] =
                $item["crrctd"] * $item["crrprc"];

            $totalGeneral += $item["subtotal"];
        }

        $this->viewData["items"] = $items;
        $this->viewData["totalGeneral"] = $totalGeneral;

        Renderer::render(
            "carretillaanon/carretillaanon",
            $this->viewData
        );
    }
}