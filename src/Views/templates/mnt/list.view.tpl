<section>
    <h1>Gestión de Productos Lacteos Laxume</h1>
</section>
<section class="WWList">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Imagen</th>
                <th>Stock</th>
                <th>Estado</th>
                <th>
                <a href="index.php?page=Mnt_ProductForm&mode=INS">Nuevo</a>
            </th>
            </tr>
        </thead>
        <tbody>
            {{foreach products}}
            <tr>
                <td>{{productId}}</td>
                <td>{{productName}}</td>
                <td>{{productDescription}}</td>
                <td>{{productPrice}}</td>
                <td>

                    <img src="{{productImgUrl}}" width="80" height="60">

                </td>
                <td>{{productStock}}</td>
                <td>{{productStatusDsc}}</td>
                <td>
                    {{if ~PRODUCT_DSP_MODE}}
                    <a href="index.php?page=Mnt_ProductForm&mode=DSP&id={{productId}}">
                        Ver
                    </a>
                    {{endif ~PRODUCT_DSP_MODE}}

                    {{if ~PRODUCT_UPD_MODE}}
                    <a href="index.php?page=Mnt_ProductForm&mode=UPD&id={{productId}}">
                        Editar
                    </a>
                    {{endif ~PRODUCT_UPD_MODE}}

                    {{if ~PRODUCT_DEL_MODE}}
                    <a href="index.php?page=Mnt_ProductForm&mode=DEL&id={{productId}}">
                        Eliminar
                    </a>
                    {{endif ~PRODUCT_DEL_MODE}}
                </td>
            </tr>
            {{endfor products}}
        </tbody>
    </table>
</section>