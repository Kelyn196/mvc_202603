
<section class="grid">

  <h2 class="text-center">NUESTROS PRODUCTOS</h2>
  <div class="row filtros">
    <form class="col-12 col-m-8" action="index.php" method="get">

      <input type="hidden" name="page" value="Products_Products">

      <div class="filtros-grid">
        <div class="filtros-campos">
          <label for="partialName">Nombre</label>
          <input type="text" name="partialName" id="partialName" value="{{partialName}}" />

          <label for="status">Estado</label>
          <select name="status" id="status">
            <option value="" {{status_EMP}}>Todos</option>
            <option value="DISPO" {{status_DISPO}}>Disponible</option>
            <option value="AGO" {{status_AGO}}>Agotado</option>
          </select>
        </div>

        <div class="filtros-botones">
          <button type="submit" class="btnop btnop-primary">Filtrar</button>
          <a href="index.php?page=Products_Product&mode=INS" class="btnop btnop-success">Nuevo</a>
        </div>
      </div>
    </form>
  </div>
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
        <th class="center">Carretilla</th>
      </tr>
    </thead>
    <tbody>
      {{foreach products}}
      <tr>
        <td>{{productId}}</td>
        <td>{{productName}}</td>
        <td>{{productDescription}}</td>
        <td class="right">{{productPrice}}</td>
        <td class="center">
          <img src="{{productImgUrl}}" alt="{{productName}}" width="80" height="60" />
        </td>
        <td class="center">{{productStock}}</td>
        <td class="center">{{productStatusDsc}}</td>
        <td class="center">
          <a href="index.php?page=Products_Product&mode=DSP&productId={{productId}}" class="btn btn-info" title="Ver">
            <i class="fa-solid fa-eye"></i>
          </a>
          <a href="index.php?page=Products_Product&mode=UPD&productId={{productId}}" class="btn btn-warning" title="Editar">
            <i class="fa-solid fa-edit"></i>
          </a>
          <a href="index.php?page=Products_Product&mode=DEL&productId={{productId}}" class="btn btn-danger" title="Eliminar" onclick="return confirm('¿Seguro que deseas eliminar este registro?');">
            <i class="fa-solid fa-trash"></i>
          </a>
        </td>
        <td class="center">
          <form action="index.php?page={{~cartPage}}" method="POST" style="display:inline;">
            <input type="hidden" name="action" value="ADD">
            <input type="hidden" name="productId" value="{{productId}}">
            <input type="hidden" name="crrctd" value="1">
            <button type="submit" class="btn btn-success" title="Agregar a carretilla">
              <i class="fa-solid fa-cart-plus"></i>
            </button>
          </form>
        </td>
      </tr>
      {{endfor products}}
    </tbody>
  </table>
  {{pagination}}
</section>