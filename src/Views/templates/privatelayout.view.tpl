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

  {{foreach SiteLinks}}
  <link rel="stylesheet" href="{{~BASE_DIR}}/{{this}}" />
  {{endfor SiteLinks}}

  {{foreach BeginScripts}}
  <script src="{{~BASE_DIR}}/{{this}}"></script>
  {{endfor BeginScripts}}
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

    {{with login}}
    <span class="username">
      {{userName}}
      <a href="index.php?page=sec_logout">
        <i class="fas fa-sign-out-alt"></i>
      </a>
    </span>
    {{endwith login}}

    <nav id="menu">
      <ul>

        <li>
          <a href="index.php?page={{PUBLIC_DEFAULT_CONTROLLER}}">
            <i class="fas fa-home"></i>&nbsp;Inicio
          </a>
        </li>

        {{foreach PUBLIC_NAVIGATION}}
        <li>
          <a href="{{nav_url}}">{{nav_label}}</a>
        </li>
        {{endfor PUBLIC_NAVIGATION}}

        {{with login}}
        <li>
          <a href="index.php?page=sec_logout">
            <i class="fas fa-sign-out-alt"></i>&nbsp;Salir
          </a>
        </li>
        {{endwith login}}

      </ul>
    </nav>

  </header>

  <main>
    {{{page_content}}}
  </main>

  <footer class="footer-axume">
    <div class="footer-container">

      <div class="footer-section">
        <h3>LÁCTEOS AXUME</h3>
        <p>
          Somos una empresa familiar comprometida con ofrecer productos lácteos
          frescos y de calidad. Elaboramos nuestros productos todos los días con
          leche local que llega directamente desde las fincas de la zona.
        </p>
        <p>Dirección: Morocelí, El Paraíso, Honduras</p>
      </div>

      <div class="footer-section">
        <h3>INFORMACIÓN DE CONTACTO</h3>
        <p>Teléfono: (+504) 0000-0000</p>
        <p>Correo: saxume@gmail.com</p>
      </div>

      <div class="footer-section marca">
        <h3>SOMOS UNA MARCA DE TRADICIÓN</h3>
        <img src="{{BASE_DIR}}/public/img/logolacteos.png" alt="Lácteos Axume" class="logo-footer">
        <p>Hechos con leche 100% local.</p>
      </div>

    </div>

    <div class="footer-bottom">
      <p>TODOS LOS DERECHOS RESERVADOS {{~CURRENT_YEAR}}</p>
    </div>
  </footer>

</body>

</html>