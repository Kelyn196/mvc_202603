<h1>Trabajar con Productos</h1>

<section class="grid">
    <div class="row">
        <form class="col-12 col-m-8" action="index.php" method="get">

            <div class="flex align-center">

                <div class="col-8 row">

                    <input type="hidden" name="page" value="Products_Products">

                    <label class="col-3" for="partialName">
                        Nombre
                    </label>

                    <input class="col-9" type="text" name="partialName" id="partialName" value="{{partialName}}" />

                    <label class="col-3" for="categoria">
                        Categoría
                    </label>

                    <input class="col-9" type="text" name="categoria" id="categoria" value="{{categoria}}" />

                </div>

                <div class="col-4 align-end">
                    <button type="submit">
                        Filtrar
                    </button>
                </div>

            </div>

        </form>
    </div>
</section>

<section class="WWList">

    <table>

        <thead>

            <tr>

                <th>

                    {{ifnot OrderById_producto}}
                    <a href="index.php?page=Products_Products&orderBy=id_producto&orderDescending=0">
                        Código <i class="fas fa-sort"></i>
                    </a>
                    {{endifnot OrderById_producto}}

                    {{if OrderId_productoDesc}}
                    <a href="index.php?page=Products_Products&orderBy=clear&orderDescending=0">
                        Código <i class="fas fa-sort-down"></i>
                    </a>
                    {{endif OrderId_productoDesc}}

                    {{if OrderId_producto}}
                    <a href="index.php?page=Products_Products&orderBy=id_producto&orderDescending=1">
                        Código <i class="fas fa-sort-up"></i>
                    </a>
                    {{endif OrderId_producto}}

                </th>


                <th>

                    {{ifnot OrderByNombre}}
                    <a href="index.php?page=Products_Products&orderBy=nombre&orderDescending=0">
                        Nombre <i class="fas fa-sort"></i>
                    </a>
                    {{endifnot OrderByNombre}}

                    {{if OrderNombreDesc}}
                    <a href="index.php?page=Products_Products&orderBy=clear&orderDescending=0">
                        Nombre <i class="fas fa-sort-down"></i>
                    </a>
                    {{endif OrderNombreDesc}}

                    {{if OrderNombre}}
                    <a href="index.php?page=Products_Products&orderBy=nombre&orderDescending=1">
                        Nombre <i class="fas fa-sort-up"></i>
                    </a>
                    {{endif OrderNombre}}

                </th>


                <th>

                    {{ifnot OrderByPrecio_menor}}
                    <a href="index.php?page=Products_Products&orderBy=precio_menor&orderDescending=0">
                        Precio Menor <i class="fas fa-sort"></i>
                    </a>
                    {{endifnot OrderByPrecio_menor}}

                    {{if OrderPrecio_menorDesc}}
                    <a href="index.php?page=Products_Products&orderBy=clear&orderDescending=0">
                        Precio Menor <i class="fas fa-sort-down"></i>
                    </a>
                    {{endif OrderPrecio_menorDesc}}

                    {{if OrderPrecio_menor}}
                    <a href="index.php?page=Products_Products&orderBy=precio_menor&orderDescending=1">
                        Precio Menor <i class="fas fa-sort-up"></i>
                    </a>
                    {{endif OrderPrecio_menor}}

                </th>


                <th>

                    {{ifnot OrderByPrecio_mayor}}
                    <a href="index.php?page=Products_Products&orderBy=precio_mayor&orderDescending=0">
                        Precio Mayor <i class="fas fa-sort"></i>
                    </a>
                    {{endifnot OrderByPrecio_mayor}}

                    {{if OrderPrecio_mayorDesc}}
                    <a href="index.php?page=Products_Products&orderBy=clear&orderDescending=0">
                        Precio Mayor <i class="fas fa-sort-down"></i>
                    </a>
                    {{endif OrderPrecio_mayorDesc}}

                    {{if OrderPrecio_mayor}}
                    <a href="index.php?page=Products_Products&orderBy=precio_mayor&orderDescending=1">
                        Precio Mayor <i class="fas fa-sort-up"></i>
                    </a>
                    {{endif OrderPrecio_mayor}}

                </th>

                <th>Stock</th>

                <th>Categoría</th>

                <th>
                    <a href="index.php?page=Products_Product&mode=INS">
                        Nuevo
                    </a>
                </th>

            </tr>

        </thead>

        <tbody>

            {{foreach products}}

            <tr>

                <td>
                    {{id_producto}}
                </td>

                <td>

                    <a class="link" href="index.php?page=Products_Product&mode=DSP&id_producto={{id_producto}}">

                        {{nombre}}

                    </a>

                </td>

                <td class="right">
                    L. {{precio_menor}}
                </td>

                <td class="right">
                    L. {{precio_mayor}}
                </td>

                <td class="center">
                    {{stock}}
                </td>

                <td>
                    {{categoria}}
                </td>

                <td class="center">

                    <a href="index.php?page=Products_Product&mode=UPD&id_producto={{id_producto}}">
                        Editar
                    </a>

                    &nbsp;

                    <a href="index.php?page=Products_Product&mode=DEL&id_producto={{id_producto}}">
                        Eliminar
                    </a>

                </td>

            </tr>

            {{endfor products}}

        </tbody>

    </table>

    {{pagination}}

</section>