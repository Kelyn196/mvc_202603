<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{SITE_TITLE}}</title>
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{BASE_DIR}}/public/css/appstyle.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <script src="https://kit.fontawesome.com/{{FONT_AWESOME_KIT}}.js" crossorigin="anonymous"></script>
</head>
<body>
  <header>
    <input type="checkbox" class="menu_toggle" id="menu_toggle" />
    <label for="menu_toggle" class="menu_toggle_icon">
      <div class="hmb dgn pt-1"></div>
      <div class="hmb hrz"></div>
      <div class="hmb dgn pt-2"></div>
    </label>
    <h1>{{SITE_TITLE}}</h1>
    <nav id="menu">
      <ul>
        <li><a href="index.php?page={{PUBLIC_DEFAULT_CONTROLLER}}"><i class="fas fa-home"></i>&nbsp;Inicio</a></li>
        {{foreach PUBLIC_NAVIGATION}}
          <li><a href="{{nav_url}}">{{nav_label}}</a></li>
        {{endfor PUBLIC_NAVIGATION}}
      </ul>
    </nav>
  </header>
  <main>
    <section class="index-container">
        <header>
            <input type="checkbox" class="menu_toggle" id="menu_toggle" />
            <label for="menu_toggle" class="menu_toggle_icon" >
            <div class="hmb dgn pt-1"></div>
            <div class="hmb hrz"></div>
            <div class="hmb dgn pt-2"></div>
            </label>
            <h1>{{SITE_TITLE}}</h1>
            <nav id="menu">
            <ul>
                <li><a href="index.php?page={{PUBLIC_DEFAULT_CONTROLLER}}"><i class="fas fa-home"></i>&nbsp;Inicio</a></li>
                {{foreach PUBLIC_NAVIGATION}}
                    <li><a href="{{nav_url}}">{{nav_label}}</a></li>
                {{endfor PUBLIC_NAVIGATION}}
            </ul>
            </nav>
        </header>
      </header>
      <section class="productos-nuevos">
        <h2>Productos Nuevos</h2>
        <div class="scroll-productos">
          {{foreach productosNuevos}}
          <div class="producto-card">
            <img src="{{productImgUrl}}" alt="{{productName}}">
            <h3>{{productName}}</h3>
            <p>{{productDescription}}</p>
            <span class="precio">L. {{productPrice}}</span>
            <button class="btnop btnop-success agregar-carrito" data-id="{{productId}}">
              Agregar
            </button>
          </div>
          {{endfor productosNuevos}}
        </div>
      </section>
      <section class="distribucion">
        <h2>Distribución Artesanal</h2>
        <p>
          Además de nuestros lácteos, hemos integrado una variedad de productos hondureños
          elaborados artesanalmente: frijoles, pan tradicional, plátanos, aguacates,
          tortillas de harina caseras, chorizo suelto y encurtidos.
        </p>
        <p>
          Todos estos productos son distribuidos con el mismo compromiso de calidad y cercanía
          que caracteriza a Lácteos Axume.
        </p>
      </section>
      <section class="calidad-leche">
        <h2>Nuestra Calidad</h2>
        <p>
          Garantizamos leche fresca, pura y local, proveniente de productores hondureños
          comprometidos con la excelencia. Cada producto pasa por rigurosos controles
          para asegurar su sabor auténtico.
        </p>
      <section class="historia-marca">
        <h2>Nuestra Historia</h2>
        <p>
          Desde nuestros inicios, Lácteos Axume ha sido sinónimo de tradición y confianza.
          Hoy, además de lácteos, llevamos a tu mesa productos hondureños elaborados con
          recetas artesanales que preservan nuestra identidad cultural.
        </p>
      </section>
    </section>
  </main>
</body>
</html>
