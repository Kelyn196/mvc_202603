<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $SITE_TITLE ?></title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="<?= $BASE_DIR ?>/public/css/appstyle.css">
</head>
<body>
  <!-- Hero Panel con imagen local y logo -->
 <section class="text-white text-center py-5" style="background: url('public/imgs/fondo1.jpg') center/cover no-repeat;">
    <div class="container bg-dark bg-opacity-50 p-4 rounded">
      <img src="/negociosWeb/Proyecto/mvc_202603/public/imgs/logolacteos.png" 
          alt="Lácteos Axume" 
          class="mb-3" 
          style="width: 160px; filter: drop-shadow(2px 2px 4px rgba(0,0,0,0.5));">
      <h1 class="display-4 fw-bold">LÁCTEOS AXUME</h1>
      <p class="lead">Elaboramos nuestros lácteos con ingredientes cuidadosamente seleccionados para ofrecer un sabor auténtico que acompaña a tu familia en cada momento.</p>
      <a href="index.php?page=Products_Products" class="btn btn-light btn-lg mt-3">Explorar Productos</a>
    </div>
  </section>


  <!-- Carrusel de productos -->
  <section class="container my-5">
    <h2 class="mb-4 text-center">Nuestros productos destacados</h2>

    <div id="axumeCarousel" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner">

        <!-- Producto 1 -->
        <div class="carousel-item active">
          <img src="https://images.unsplash.com/photo-1608198093002-0f6f3f3c3e2a" class="d-block w-100 rounded" alt="Pan artesanal hondureño">
          <div class="carousel-caption bg-dark bg-opacity-50 rounded p-3">
            <h5>Pan artesanal hondureño</h5>
            <p>Receta tradicional, sabor auténtico y elaborado con ingredientes locales.</p>
            <a href="index.php?page=Carretilla_Add&productId=1" class="btn btn-primary btn-sm">Agregar al carrito</a>
          </div>
        </div>

        <!-- Producto 2 -->
        <div class="carousel-item">
          <img src="https://images.unsplash.com/photo-1604908177522-3f3a6e6f3c3d" class="d-block w-100 rounded" alt="Frijoles">
          <div class="carousel-caption bg-dark bg-opacity-50 rounded p-3">
            <h5>Frijoles</h5>
            <p>Cultivados localmente, frescos y nutritivos, ideales para acompañar tus comidas.</p>
            <a href="index.php?page=Carretilla_Add&productId=2" class="btn btn-primary btn-sm">Agregar al carrito</a>
          </div>
        </div>

        <!-- Producto 3 -->
        <div class="carousel-item">
          <img src="https://images.unsplash.com/photo-1567306226416-28f0efdc88ce" class="d-block w-100 rounded" alt="Aguacates">
          <div class="carousel-caption bg-dark bg-opacity-50 rounded p-3">
            <h5>Aguacates</h5>
            <p>Verdes, cremosos y llenos de sabor, provenientes de fincas hondureñas.</p>
            <a href="index.php?page=Carretilla_Add&productId=3" class="btn btn-primary btn-sm">Agregar al carrito</a>
          </div>
        </div>

        <!-- Producto 4 -->
        <div class="carousel-item">
          <img src="https://images.unsplash.com/photo-1604908550032-3f3a6e6f3c3d" class="d-block w-100 rounded" alt="Tortillas de harina">
          <div class="carousel-caption bg-dark bg-opacity-50 rounded p-3">
            <h5>Tortillas de harina</h5>
            <p>Suaves y perfectas para acompañar nuestros productos lácteos.</p>
            <a href="index.php?page=Carretilla_Add&productId=4" class="btn btn-primary btn-sm">Agregar al carrito</a>
          </div>
        </div>

        <!-- Producto 5 -->
        <div class="carousel-item">
          <img src="https://images.unsplash.com/photo-1580910051074-7c2c7f3e3e2a" class="d-block w-100 rounded" alt="Queso fresco">
          <div class="carousel-caption bg-dark bg-opacity-50 rounded p-3">
            <h5>Queso fresco</h5>
            <p>Hecho con leche local, sabor auténtico y textura suave. Apoyamos a pequeños productores.</p>
            <a href="index.php?page=Carretilla_Add&productId=5" class="btn btn-primary btn-sm">Agregar al carrito</a>
          </div>
        </div>

      </div>

      <!-- Controles -->
      <button class="carousel-control-prev" type="button" data-bs-target="#axumeCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Anterior</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#axumeCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Siguiente</span>
      </button>
    </div>
  </section>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
