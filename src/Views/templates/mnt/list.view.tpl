<section>
    <h2>Gestión de Productos</h2>
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
                <th>Acciones</th>
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
                <td>
                    {{if productStatus_DISPO}}
                    Disponible
                    {{endif productStatus_DISPO}}
                    {{if productStatus_AGO}}
                    Agotado
                    {{endif productStatus_AGO}}
                </td>
                <td>
                    {{if ~PRODUCT_DSP_MODE}}
                    <a href="index.php?page=Mnt_ProductForm&mode=DSP&productId={{productId}}">
                        Ver
                    </a>
                    <br>
                    {{endif ~PRODUCT_DSP_MODE}}
                    {{if ~PRODUCT_UPD_MODE}}
                    <a href="index.php?page=Mnt_ProductForm&mode=UPD&productId={{productId}}">
                        Editar
                    </a>
                    <br>
                    {{endif ~PRODUCT_UPD_MODE}}
                    {{if ~PRODUCT_DEL_MODE}}
                    <a href="index.php?page=Mnt_ProductForm&mode=DEL&productId={{productId}}">
                        Eliminar
                    </a>
                    {{endif ~PRODUCT_DEL_MODE}}
                </td>
            </tr>
            {{endfor products}}
        </tbody>
    </table>
</section>