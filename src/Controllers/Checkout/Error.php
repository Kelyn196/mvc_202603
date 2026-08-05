<?php

namespace Controllers\Checkout;

use Controllers\PrivateController;
use Utilities\Site;

class Error extends PrivateController
{
    public function run(): void
    {
        Site::redirectToWithMsg("index.php?page=Carretilla_Carretilla", "Pago cancelado o error en el proceso.");
    }
}