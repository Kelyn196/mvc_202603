<?php
namespace Controllers\Mnt;

use Controllers\PublicController;
use Views\Renderer;
use Dao\Products\Products as ProductDAO;

const PRODUCT_LIST_VIEW = 'products/products';

class ResultList extends PublicController
{
    public function run(): void
    {
        $productos["productos"] = ProductDAO::getProducts()["products"];

        Renderer::render(
            PRODUCT_LIST_VIEW,
            $productos
        );
    }
}
?>