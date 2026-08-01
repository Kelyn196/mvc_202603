<?php

namespace Controllers\Mnt;

use Controllers\PrivateController;
use Views\Renderer;
use Dao\Products\Products as ProductDAO;
use Utilities\Paging;

const PRODUCT_LIST_VIEW = 'mnt/list';

const PRODUCT_INS_MODE = 'Controllers\Mnt\ProductList\INS';
const PRODUCT_UPD_MODE = 'Controllers\Mnt\ProductList\UPD';
const PRODUCT_DEL_MODE = 'Controllers\Mnt\ProductList\DEL';
const PRODUCT_DSP_MODE = 'Controllers\Mnt\ProductList\DSP';


class ProductList extends PrivateController
{
    public function run(): void
{
    $pageNumber = isset($_GET["pageNum"]) ? intval($_GET["pageNum"]) : 1;
    $itemsPerPage = 10;

    $resultado = ProductDAO::getProducts(
        "",
        "",
        "",
        false,
        $pageNumber - 1,
        $itemsPerPage
    );

    $viewData = [];

    $viewData["products"] = $resultado["products"];

    $viewData["PRODUCT_INS_MODE"] = $this->isFeatureAutorized(PRODUCT_INS_MODE);
    $viewData["PRODUCT_UPD_MODE"] = $this->isFeatureAutorized(PRODUCT_UPD_MODE);
    $viewData["PRODUCT_DEL_MODE"] = $this->isFeatureAutorized(PRODUCT_DEL_MODE);
    $viewData["PRODUCT_DSP_MODE"] = $this->isFeatureAutorized(PRODUCT_DSP_MODE);

    $viewData["pagination"] = Paging::getPagination(
        $resultado["total"],
        $itemsPerPage,
        $pageNumber,
        "index.php?page=Mnt_ProductList",
        "Mnt_ProductList"
    );

    Renderer::render(
        PRODUCT_LIST_VIEW,
        $viewData
    );
}
}
?>