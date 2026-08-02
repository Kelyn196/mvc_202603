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
  <!-- Hero Panel con imagen local -->
  <section class="text-white text-center hero-banner"  style="background: url('public/imgs/fondo1.jpg') center/cover no-repeat;">
    <h1 class="display-4 fw-bold">Calidad, frescura y tradición en cada producto.</h1>
  </section>
  <section class="banner-section mt-0 mb-5">
  <img src="public/imgs/promos.png" alt="Banner Promo" class="img-fluid w-100 banner-img">
</section>

  <section class="container my-5">
    <div class="row g-4">

      <!-- Promo 1 -->
      <div class="col-md-4">
        <div class="card h-100 shadow-sm">
          <img src="public/imgs/quesadillas.jpeg" class="card-img-top" alt="Quesadillas en promoción">
          <div class="card-body text-center">
            <h5 class="card-title">Combo Quesadillas</h5>
            <p class="card-text">Lleva 3 quesadillas por solo <strong>L. 80</strong>.</p>
            <a href="index.php?page=Products_Products" class="btn btn-success">
              <i class="fa-solid fa-cart-plus"></i>
            </a>
          </div>
        </div>
      </div>

      <!-- Promo 2 -->
      <div class="col-md-4">
        <div class="card h-100 shadow-sm">
          <img src="public/imgs/rosquillas.jpeg" class="card-img-top" alt="Rosquillas en promoción">
          <div class="card-body text-center">
            <h5 class="card-title">Rosquillas Doradas</h5>
            <p class="card-text">Compra 2 bolsas y recibe la tercera <strong>gratis</strong>.</p>
            <a href="index.php?page=Products_Products" class="btn btn-success">
              <i class="fa-solid fa-cart-plus"></i>
            </a>
          </div>
        </div>
      </div>

      <!-- Promo 3 -->
      <div class="col-md-4">
        <div class="card h-100 shadow-sm">
          <img src="public/imgs/aguacate.jpg" class="card-img-top" alt="Aguacates en promoción">
          <div class="card-body text-center">
            <h5 class="card-title">Aguacates Frescos</h5>
            <p class="card-text">Lleva 5 aguacates por solo <strong>L. 150</strong>.</p>
            <a href="index.php?page=Products_Products" class="btn btn-success">
              <i class="fa-solid fa-cart-plus"></i>
            </a>
          </div>
        </div>
      </div>
    </div>


    <!-- Carrusel y Quiénes somos -->
    <div class="row mt-5">
      <!-- Carrusel a la izquierda -->
      <div class="col-md-6">
        <div id="axumeCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <img src="public/imgs/productores.jpg" class="d-block w-100 product-img">
            </div>
            <div class="carousel-item">
              <img src="public/imgs/produccionRosquillas.jpg" class="d-block w-100 product-img">
            </div>
            <div class="carousel-item">
              <img src="public/imgs/ProductoraRosqullas.jpg" class="d-block w-100 product-img">
            </div>
            <div class="carousel-item">
              <img src="public/imgs/leche.jpg" class="d-block w-100 product-img">
            </div>
          </div>

          <!-- Controles del carrusel -->
          <button class="carousel-control-prev" type="button" data-bs-target="#axumeCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Anterior</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#axumeCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Siguiente</span>
          </button>
        </div>
      </div>

      <!-- Quiénes somos a la derecha -->
      <div class="col-md-6 bg-light p-4">
        <h2 class="text-success mb-4">Quiénes Somos</h2>
        <p class="lead">
          En Lácteos Axúme nos apasiona elaborar productos que combinan calidad, frescura y tradición. Cada uno de nuestros lácteos es preparado con ingredientes cuidadosamente seleccionados y un proceso que conserva el auténtico sabor de nuestra tierra, para que disfrutes una experiencia única en cada bocado.
        </p>
        <p>
          Somos una empresa familiar orgullosamente ubicada en Morocelí, El Paraíso, dedicada a ofrecer productos lácteos y alimentos elaborados con dedicación, compromiso y altos estándares de calidad. Nuestra misión es llevar a tu mesa el verdadero sabor de Honduras, compartiendo la tradición y el cariño que nos inspiran desde nuestros inicios.
        </p>
      </div>
    </div>
    <a href="index.php?page=Products_Products" class="btn-lg mt-3">Explorar Productos</a>
  </section>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
