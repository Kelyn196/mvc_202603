<h1>Lacteos Laxume</h1>
<section class="grid">
  <div class="row">
    <form class="col-12 col-m-8" action="index.php" method="get">
      <div class="flex align-center">
        <div class="col-8 row">
          <input type="hidden" name="page" value="Products_Products">
          <label class="col-3" for="partialName">Nombre</label>
          <input class="col-9" type="text" name="partialName" id="partialName" value="{{partialName}}" />
          <label class="col-3" for="status">Estado</label>
          <select class="col-9" name="status" id="status">
              <option value="ACT" {{status_DISP}}>Activo</option>
              <option value="INA" {{status_AGO}}>Inactivo</option>
          </select>
        </div>
        <div class="col-4 align-end">
          <button type="submit">Filtrar</button>
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
        <th><a href="index.php?page=Products_Product&mode=INS">Nuevo</a></th>
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
          <a href="index.php?page=Products_Product&mode=DSP&productId={{productId}}">Ver</a>
          &nbsp;
          <a href="index.php?page=Products_Product&mode=UPD&productId={{productId}}">Editar</a>
          &nbsp;
          <a href="index.php?page=Products_Product&mode=DEL&productId={{productId}}">Eliminar</a>
        </td>
      </tr>
      {{endfor products}}
    </tbody>
  </table>
  {{pagination}}
</section>