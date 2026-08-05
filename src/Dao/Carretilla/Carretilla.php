<?php
namespace Dao\Carretilla;

use Dao\Table;

class Carretilla extends Table
{
    public static function getCarretillaByUser(int $usercod)
    {
        $sqlstr = "SELECT
                        c.usercod,
                        c.productId,
                        c.crrctd,
                        c.crrprc,
                        c.crrfching,
                        p.productName,
                        p.productDescription,
                        p.productImgUrl,
                        p.productStatus,
                        p.productStock
                    FROM carretilla c
                    INNER JOIN products p
                        ON c.productId = p.productId
                    WHERE c.usercod = :usercod";

        return self::obtenerRegistros($sqlstr, ["usercod"=>$usercod]);
    }

    public static function addToCarretilla(
        int $usercod,
        int $productId,
        int $crrctd,
        float $crrprc
    ){
        $product = self::obtenerUnRegistro(
            "SELECT productStock FROM products WHERE productId=:productId",
            ["productId"=>$productId]
        );

        if(!$product){ return 0; }
        if($product["productStock"] < $crrctd){ return 0; }

        $exists = self::obtenerUnRegistro(
            "SELECT crrctd FROM carretilla WHERE usercod=:usercod AND productId=:productId",
            ["usercod"=>$usercod, "productId"=>$productId]
        );

        if($exists){
            $newQty = $exists["crrctd"] + $crrctd;
            self::executeNonQuery(
                "UPDATE carretilla SET crrctd=:crrctd, crrprc=:crrprc, crrfching=NOW() WHERE usercod=:usercod AND productId=:productId",
                ["crrctd"=>$newQty, "crrprc"=>$crrprc, "usercod"=>$usercod, "productId"=>$productId]
            );
        }else{
            self::executeNonQuery(
                "INSERT INTO carretilla (usercod,productId,crrctd,crrprc,crrfching) VALUES (:usercod,:productId,:crrctd,:crrprc,NOW())",
                ["usercod"=>$usercod, "productId"=>$productId, "crrctd"=>$crrctd, "crrprc"=>$crrprc]
            );
        }

        self::executeNonQuery(
            "UPDATE products SET productStock = productStock - :cantidad WHERE productId=:productId",
            ["cantidad"=>$crrctd, "productId"=>$productId]
        );

        return 1;
    }

    public static function updateQuantity(int $usercod, int $productId, int $crrctd){
        $actual = self::obtenerUnRegistro(
            "SELECT crrctd FROM carretilla WHERE usercod=:usercod AND productId=:productId",
            ["usercod"=>$usercod, "productId"=>$productId]
        );

        if(!$actual){ return 0; }
        if($crrctd<=0){ return self::removeFromCarretilla($usercod,$productId); }

        $diferencia = $crrctd - $actual["crrctd"];

        if($diferencia>0){
            $stock = self::obtenerUnRegistro("SELECT productStock FROM products WHERE productId=:productId", ["productId"=>$productId]);
            if($stock["productStock"] < $diferencia){ return 0; }

            self::executeNonQuery(
                "UPDATE products SET productStock = productStock - :cantidad WHERE productId=:productId",
                ["cantidad"=>$diferencia, "productId"=>$productId]
            );
        }elseif($diferencia<0){
            self::executeNonQuery(
                "UPDATE products SET productStock = productStock + :cantidad WHERE productId=:productId",
                ["cantidad"=>abs($diferencia), "productId"=>$productId]
            );
        }

        return self::executeNonQuery(
            "UPDATE carretilla SET crrctd=:crrctd WHERE usercod=:usercod AND productId=:productId",
            ["crrctd"=>$crrctd, "usercod"=>$usercod, "productId"=>$productId]
        );
    }

    public static function removeFromCarretilla(int $usercod, int $productId){
        $item = self::obtenerUnRegistro(
            "SELECT crrctd FROM carretilla WHERE usercod=:usercod AND productId=:productId",
            ["usercod"=>$usercod, "productId"=>$productId]
        );

        if($item){
            self::executeNonQuery(
                "UPDATE products SET productStock = productStock + :cantidad WHERE productId=:productId",
                ["cantidad"=>$item["crrctd"], "productId"=>$productId]
            );
        }

        return self::executeNonQuery(
            "DELETE FROM carretilla WHERE usercod=:usercod AND productId=:productId",
            ["usercod"=>$usercod, "productId"=>$productId]
        );
    }

    public static function clearCarretillaByUser(int $usercod)
    {
        return self::executeNonQuery(
            "DELETE FROM carretilla WHERE usercod=:usercod",
            ["usercod"=>$usercod]
        );
    }
}