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
                        p.productStatus
                    FROM carretilla c
                    INNER JOIN products p ON c.productId = p.productId
                    WHERE c.usercod = :usercod";
        return self::obtenerRegistros($sqlstr, ["usercod" => $usercod]);
    }

    public static function addToCarretilla(int $usercod, int $productId, int $crrctd, float $crrprc)
    {
        $exists = self::obtenerUnRegistro(
            "SELECT crrctd FROM carretilla WHERE usercod = :usercod AND productId = :productId",
            ["usercod" => $usercod, "productId" => $productId]
        );

        if ($exists) {
            $newQty = $exists["crrctd"] + $crrctd;
            return self::executeNonQuery(
                "UPDATE carretilla SET crrctd = :crrctd, crrprc = :crrprc, crrfching = NOW() WHERE usercod = :usercod AND productId = :productId",
                ["crrctd" => $newQty, "crrprc" => $crrprc, "usercod" => $usercod, "productId" => $productId]
            );
        } else {
            return self::executeNonQuery(
                "INSERT INTO carretilla (usercod, productId, crrctd, crrprc, crrfching) VALUES (:usercod, :productId, :crrctd, :crrprc, NOW())",
                ["usercod" => $usercod, "productId" => $productId, "crrctd" => $crrctd, "crrprc" => $crrprc]
            );
        }
    }

    public static function updateQuantity(int $usercod, int $productId, int $crrctd)
    {
        if ($crrctd <= 0) {
            return self::removeFromCarretilla($usercod, $productId);
        }
        return self::executeNonQuery(
            "UPDATE carretilla SET crrctd = :crrctd WHERE usercod = :usercod AND productId = :productId",
            ["crrctd" => $crrctd, "usercod" => $usercod, "productId" => $productId]
        );
    }

    public static function removeFromCarretilla(int $usercod, int $productId)
    {
        return self::executeNonQuery(
            "DELETE FROM carretilla WHERE usercod = :usercod AND productId = :productId",
            ["usercod" => $usercod, "productId" => $productId]
        );
    }
}