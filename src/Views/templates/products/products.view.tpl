<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{SITE_TITLE}}</title>
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{BASE_DIR}}/public/css/appstyle.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <script src="https://kit.fontawesome.com/{{FONT_AWESOME_KIT}}.js" crossorigin="anonymous"></script>
  {{foreach SiteLinks}}
    <link rel="stylesheet" href="{{~BASE_DIR}}/{{this}}" />
  {{endfor SiteLinks}}
  {{foreach BeginScripts}}
    <script src="{{~BASE_DIR}}/{{this}}"></script>
  {{endfor BeginScripts}}
</head>
<h1>Nuestros Productos</h1>

<section class="grid">
  <div class="row filtros">
  <form class="col-12 col-m-8" action="index.php" method="get">
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
            <i class="fas fa-eye"></i>
          </a>
          <a href="index.php?page=Products_Product&mode=UPD&productId={{productId}}" class="btn btn-warning" title="Editar">
            <i class="fas fa-edit"></i>
          </a>
          <a href="index.php?page=Products_Product&mode=DEL&productId={{productId}}" class="btn btn-danger" title="Eliminar" onclick="return confirm('¿Seguro que deseas eliminar este registro?');">
            <i class="fas fa-trash-alt"></i>
          </a>
        </td>
        <td class="center">
          <form action="index.php?page=Carretilla_Carretilla" method="POST" style="display:inline;">
            <input type="hidden" name="action" value="ADD">
            <input type="hidden" name="productId" value="{{productId}}">
            <input type="hidden" name="crrctd" value="1">
            <button type="submit" class="btn btn-success" title="Agregar a carretilla">
              <i class="fas fa-cart-plus"></i>
            </button>
          </form>
        </td>
      </tr>
      {{endfor products}}
    </tbody>
  </table>
  {{pagination}}
</section>
