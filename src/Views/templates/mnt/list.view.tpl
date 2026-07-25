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
                <th>
                    {{if PRODUCT_INS_MODE}}
                    <a href="index.php?page=Products_Product&mode=INS">Crear</a>
                    {{endif PRODUCT_INS_MODE}}
                </th>
            </tr>
        </thead>
        <tbody>
            {{foreach productos}}
            <tr>
                <td>{{productId}}</td>
                <td>{{productName}}</td>
                <td>{{productDescription}}</td>
                <td class="right">{{productPrice}}</td>
                <td class="center">
                    <img src="{{productImgUrl}}" alt="{{productName}}" width="80" height="60" />
                </td>
                <td class="center">{{productStock}}</td>
                <td class="center">
                    {{if productStatus == "ACT"}}Activo{{endif productStatus}}
                    {{if productStatus == "INA"}}Inactivo{{endif productStatus}}
                </td>
                <td>
                    {{if ~PRODUCT_DSP_MODE}}
                    <a href="index.php?page=Products_Product&mode=DSP&productId={{productId}}">Mostrar</a><br/>
                    {{endif ~PRODUCT_DSP_MODE}}
                    {{if ~PRODUCT_UPD_MODE}}
                    <a href="index.php?page=Products_Product&mode=UPD&productId={{productId}}">Editar</a><br/>
                    {{endif ~PRODUCT_UPD_MODE}}
                    {{if ~PRODUCT_DEL_MODE}}
                    <a href="index.php?page=Products_Product&mode=DEL&productId={{productId}}">Borrar</a>
                    {{endif ~PRODUCT_DEL_MODE}}
                </td>
            </tr>
            {{endfor productos}}
        </tbody>
    </table>
</section>