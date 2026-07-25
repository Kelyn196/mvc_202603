<?php

namespace Dao\Mantenimientos;

use Dao\Table;

class Productos extends Table
{
    // Obtener todos los productos
    public static function getAll(): array
    {
        $sqlstr = "SELECT * FROM productos;";
        return self::obtenerRegistros($sqlstr, []);
    }

    // Obtener un producto por ID
    public static function getById(int $id_producto): array
    {
        $sqlstr = "SELECT * FROM productos WHERE id_producto = :id_producto;";
        return self::obtenerUnRegistro(
            $sqlstr,
            ["id_producto" => $id_producto]
        );
    }

    // Insertar
    public static function create(
        string $nombre,
        string $descripcion,
        float $precio_menor,
        float $precio_mayor,
        int $stock,
        string $imagen,
        string $categoria
    ) {

        $sqlIns = "INSERT INTO productos
        (
            nombre,
            descripcion,
            precio_menor,
            precio_mayor,
            stock,
            imagen,
            categoria
        )
        VALUES
        (
            :nombre,
            :descripcion,
            :precio_menor,
            :precio_mayor,
            :stock,
            :imagen,
            :categoria
        );";

        $params = [
            "nombre" => $nombre,
            "descripcion" => $descripcion,
            "precio_menor" => $precio_menor,
            "precio_mayor" => $precio_mayor,
            "stock" => $stock,
            "imagen" => $imagen,
            "categoria" => $categoria
        ];

        return self::executeNonQuery($sqlIns, $params);
    }

    // Actualizar
    public static function update(
        int $id_producto,
        string $nombre,
        string $descripcion,
        float $precio_menor,
        float $precio_mayor,
        int $stock,
        string $imagen,
        string $categoria
    ) {

        $sqlUpd = "UPDATE productos SET

            nombre = :nombre,
            descripcion = :descripcion,
            precio_menor = :precio_menor,
            precio_mayor = :precio_mayor,
            stock = :stock,
            imagen = :imagen,
            categoria = :categoria

        WHERE id_producto = :id_producto;";

        $params = [
            "id_producto" => $id_producto,
            "nombre" => $nombre,
            "descripcion" => $descripcion,
            "precio_menor" => $precio_menor,
            "precio_mayor" => $precio_mayor,
            "stock" => $stock,
            "imagen" => $imagen,
            "categoria" => $categoria
        ];

        return self::executeNonQuery($sqlUpd, $params);
    }

    // Eliminar
    public static function delete(int $id_producto)
    {
        $sqlstr = "DELETE FROM productos
                   WHERE id_producto = :id_producto;";

        return self::executeNonQuery(
            $sqlstr,
            ["id_producto" => $id_producto]
        );
    }
}
?>