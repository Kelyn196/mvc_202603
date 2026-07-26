<?php

namespace Controllers\Mnt;

use Controllers\PrivateController;
use Views\Renderer;
use Dao\Products\Products as ProductDAO;

const PRODUCT_LIST_VIEW = 'products/products';

const PRODUCT_INS_MODE = 'Controllers\Mnt\ProductList\INS';
const PRODUCT_UPD_MODE = 'Controllers\Mnt\ProductList\UPD';
const PRODUCT_DEL_MODE = 'Controllers\Mnt\ProductList\DEL';
const PRODUCT_DSP_MODE = 'Controllers\Mnt\ProductList\DSP';

class ProductList extends PrivateController
{
    public function run(): void
    {
        $productos = ProductDAO::getProducts();
        $productos["PRODUCT_INS_MODE"] = $this->isFeatureAutorized(PRODUCT_INS_MODE);
        $productos["PRODUCT_UPD_MODE"] = $this->isFeatureAutorized(PRODUCT_UPD_MODE);
        $productos["PRODUCT_DEL_MODE"] = $this->isFeatureAutorized(PRODUCT_DEL_MODE);
        $productos["PRODUCT_DSP_MODE"] = $this->isFeatureAutorized(PRODUCT_DSP_MODE);

        Renderer::render(
            PRODUCT_LIST_VIEW,
            $productos
        );
    }
}
?>