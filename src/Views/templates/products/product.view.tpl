<section class="container-m row px-4 py-4">
    <h1>{{FormTitle}}</h1>
</section>

<section class="container-m row px-4 py-4">
{{with product}}

<form action="index.php?page=Products_Product&mode={{~mode}}&id_producto={{id_producto}}" method="POST" class="col-12 col-m-8 offset-m-2">

    <div class="row my-2 align-center">
        <label class="col-12 col-m-3">Código</label>

        <input
            class="col-12 col-m-9"
            readonly
            disabled
            type="text"
            value="{{id_producto}}">

        <input type="hidden" name="mode" value="{{~mode}}">
        <input type="hidden" name="id_producto" value="{{id_producto}}">
        <input type="hidden" name="product_xss_token" value="{{~product_xss_token}}">
    </div>


    <div class="row my-2 align-center">
        <label class="col-12 col-m-3">Nombre</label>

        <input
            class="col-12 col-m-9"
            {{~readonly}}
            type="text"
            name="nombre"
            value="{{nombre}}">

        {{if nombre_error}}
        <div class="col-12 col-m-9 offset-m-3 error">
            {{nombre_error}}
        </div>
        {{endif nombre_error}}
    </div>


    <div class="row my-2 align-center">
        <label class="col-12 col-m-3">Descripción</label>

        <textarea
            class="col-12 col-m-9"
            name="descripcion"
            {{~readonly}}>{{descripcion}}</textarea>

        {{if descripcion_error}}
        <div class="col-12 col-m-9 offset-m-3 error">
            {{descripcion_error}}
        </div>
        {{endif descripcion_error}}
    </div>


    <div class="row my-2 align-center">
        <label class="col-12 col-m-3">Precio Menor</label>

        <input
            class="col-12 col-m-9"
            {{~readonly}}
            type="number"
            step="0.01"
            name="precio_menor"
            value="{{precio_menor}}">

        {{if precio_menor_error}}
        <div class="col-12 col-m-9 offset-m-3 error">
            {{precio_menor_error}}
        </div>
        {{endif precio_menor_error}}
    </div>


    <div class="row my-2 align-center">
        <label class="col-12 col-m-3">Precio Mayor</label>

        <input
            class="col-12 col-m-9"
            {{~readonly}}
            type="number"
            step="0.01"
            name="precio_mayor"
            value="{{precio_mayor}}">

        {{if precio_mayor_error}}
        <div class="col-12 col-m-9 offset-m-3 error">
            {{precio_mayor_error}}
        </div>
        {{endif precio_mayor_error}}
    </div>


    <div class="row my-2 align-center">
        <label class="col-12 col-m-3">Stock</label>

        <input
            class="col-12 col-m-9"
            {{~readonly}}
            type="number"
            name="stock"
            value="{{stock}}">

        {{if stock_error}}
        <div class="col-12 col-m-9 offset-m-3 error">
            {{stock_error}}
        </div>
        {{endif stock_error}}
    </div>


    <div class="row my-2 align-center">
        <label class="col-12 col-m-3">Imagen</label>

        <input
            class="col-12 col-m-9"
            {{~readonly}}
            type="text"
            name="imagen"
            value="{{imagen}}">

        {{if imagen_error}}
        <div class="col-12 col-m-9 offset-m-3 error">
            {{imagen_error}}
        </div>
        {{endif imagen_error}}
    </div>


    <div class="row my-2 align-center">
        <label class="col-12 col-m-3">Categoría</label>

        <input
            class="col-12 col-m-9"
            {{~readonly}}
            type="text"
            name="categoria"
            value="{{categoria}}">

        {{if categoria_error}}
        <div class="col-12 col-m-9 offset-m-3 error">
            {{categoria_error}}
        </div>
        {{endif categoria_error}}
    </div>

{{endwith product}}

    <div class="row my-4 align-center flex-end">

        {{if showCommitBtn}}
        <button class="primary col-12 col-m-2"
            type="submit">
            Confirmar
        </button>
        &nbsp;
        {{endif showCommitBtn}}

        <button
            class="col-12 col-m-2"
            type="button"
            id="btnCancelar">

            {{if showCommitBtn}}
                Cancelar
            {{endif showCommitBtn}}

            {{ifnot showCommitBtn}}
                Regresar
            {{endifnot showCommitBtn}}

        </button>

    </div>

</form>

</section>

<script>
document.addEventListener("DOMContentLoaded", ()=>{

    document.getElementById("btnCancelar")
    .addEventListener("click",(e)=>{
        e.preventDefault();
        e.stopPropagation();

        window.location.assign(
            "index.php?page=Products_Products"
        );
    });

});
</script>