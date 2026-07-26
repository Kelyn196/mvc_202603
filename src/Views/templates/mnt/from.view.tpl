<section class="depth-1 px-4 mb-4">
    <h2>{{modeDsc}}</h2>
</section>
<section class="row my-4">
    {{if error_global}}
    <ul class="error">
        {{foreach error_global}}
        <li class="error">{{this}}</li>
        {{endfor error_global}}
    </ul>
    {{endif error_global}}
    {{with producto}}
    <form class="col-12 col-m-6 offset-m-3 depth-1 px-4 py-4"
        action="index.php?page=Mnt_ProductForm&mode={{~mode}}&productId={{productId}}" method="POST" novalidate>
        <div class="row py-2 align-center">
            <label class="col-12 col-m-3">Nombre:</label>
            <input type="text" name="productName" required class="col-12 col-m-9" value="{{productName}}" {{~readonly}}>
        </div>

        <div class="row py-2 align-center">
            <label class="col-12 col-m-3">Descripción:</label>
            <textarea name="productDescription" required class="col-12 col-m-9"{{~readonly}}>{{productDescription}}</textarea>
        </div>
        <div class="row py-2 align-center">
            <label class="col-12 col-m-3">Precio:</label>
            <input type="number" name="productPrice" required class="col-12 col-m-9" value="{{productPrice}}"
                {{~readonly}}>

        </div>
        <div class="row py-2 align-center">
            <label class="col-12 col-m-3">Stock:</label>
            <input type="number" name="productStock" required class="col-12 col-m-9" value="{{productStock}}"
                {{~readonly}}>
        </div>
        <div class="row py-2 align-center">
            <label class="col-12 col-m-3">Imagen:</label>
            <input type="text" name="productImgUrl" class="col-12 col-m-9" value="{{productImgUrl}}" {{~readonly}}>

        </div>
        <div class="row py-2 align-center">
            <label class="col-12 col-m-3">
                Estado:
            </label>
            <select name="productStatus" class="col-12 col-m-9" {{if ~readonly}} disabled {{endif ~readonly}}>
                <option value="DISPO">
                    Disponible
                </option>
                <option value="AGO">
                    Agotado
                </option>
            </select>
        </div>
        <div class="row py-2 align-center my-2 flex-end">
            <input type="hidden" name="productId" value="{{productId}}">
            <input type="hidden" name="mode" value="{{~mode}}">
            <input type="hidden" name="xssToken" value="{{~xssToken}}">
            {{if ~editable}}
            <button type="submit">
                Guardar
            </button>
            {{endif ~editable}}
            <button type="button" id="returnBtn" class="mx-4">
                Cancelar
            </button>
        </div>
    </form>
    {{endwith producto}}
</section>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        document.getElementById("returnBtn")
            .addEventListener("click", (e) => {
                e.preventDefault();
                window.location.assign(
                    "index.php?page=Mnt_ResultList"
                );
            });
    });
</script>