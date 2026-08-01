<section class="container-m row px-4 py-4">
  <h1>{{FormTitle}}</h1>
</section>

<section class="container-m row px-4 py-4">
  {{with product}}
  <form action="index.php?page=Products_Product&mode={{~mode}}&productId={{productId}}" method="POST" class="col-12 col-m-8 offset-m-2 form-product">
    <div class="form-group">
      <label for="productIdD">Código</label>
      <input readonly disabled type="text" id="productIdD" value="{{productId}}" />
      <input type="hidden" name="mode" value="{{~mode}}" />
      <input type="hidden" name="productId" value="{{productId}}" />
      <input type="hidden" name="xssToken" value="{{~product_xss_token}}" />
    </div>

    <div class="form-group">
      <label for="productName">Producto</label>
      <input {{~readonly}} type="text" name="productName" id="productName" placeholder="Nombre del Producto" value="{{productName}}" />
      {{if productName_error}}<div class="error">{{productName_error}}</div>{{endif productName_error}}
    </div>

    <div class="form-group">
      <label for="productDescription">Descripción</label>
      <textarea {{~readonly}} name="productDescription" id="productDescription" placeholder="Descripción del Producto">{{productDescription}}</textarea>
      {{if productDescription_error}}<div class="error">{{productDescription_error}}</div>{{endif productDescription_error}}
    </div>

    <div class="form-group">
      <label for="productPrice">Precio</label>
      <input {{~readonly}} type="number" name="productPrice" id="productPrice" placeholder="Precio del Producto" value="{{productPrice}}" />
      {{if productPrice_error}}<div class="error">{{productPrice_error}}</div>{{endif productPrice_error}}
    </div>

    <div class="form-group">
      <label for="productStock">Stock</label>
      <input {{~readonly}} type="number" name="productStock" id="productStock" placeholder="Cantidad en inventario" value="{{productStock}}" />
      {{if productStock_error}}<div class="error">{{productStock_error}}</div>{{endif productStock_error}}
    </div>

    <div class="form-group">
      <label for="productImgUrl">Url de Imagen (250 x 200)</label>
      <input {{~readonly}} type="text" name="productImgUrl" id="productImgUrl" placeholder="URL de la imagen" value="{{productImgUrl}}" />
      {{if productImgUrl_error}}<div class="error">{{productImgUrl_error}}</div>{{endif productImgUrl_error}}
    </div>

    <div class="form-group">
      <label for="productStatus">Estado</label>
      <select name="productStatus" id="productStatus" {{if ~readonly}}disabled{{endif ~readonly}}>
        <option value="DISPO" {{productStatus_DISPO}}>Disponible</option>
        <option value="AGO" {{productStatus_AGO}}>Agotado</option>
      </select>
    </div>

    {{endwith product}}

    <div class="form-actions">
      {{if showCommitBtn}}
      <button class="btn-brown" type="submit" name="btnConfirmar">Confirmar</button>
      {{endif showCommitBtn}}
      <button class="btn-brown" type="button" id="btnCancelar">
        {{if showCommitBtn}}Cancelar{{endif showCommitBtn}}
        {{ifnot showCommitBtn}}Regresar{{endifnot showCommitBtn}}
      </button>
    </div>
  </form>
</section>

<script>
  document.addEventListener("DOMContentLoaded", ()=>{
    const btnCancelar = document.getElementById("btnCancelar");
    btnCancelar.addEventListener("click", (e)=>{
      e.preventDefault();
      e.stopPropagation();
      window.location.assign("index.php?page=Products_Products");
    });
  });
</script>
