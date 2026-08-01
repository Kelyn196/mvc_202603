<section class="index-container">

  <section class="productos-nuevos">
    <h2>Productos Nuevos</h2>

    <div class="scroll-productos">
      {{foreach productosNuevos}}
      <div class="producto-card">
        <img src="{{productImgUrl}}" alt="{{productName}}">
        <h3>{{productName}}</h3>
        <p>{{productDescription}}</p>
        <span class="precio">L. {{productPrice}}</span>

        <button
          class="btnop btnop-success agregar-carrito"
          data-id="{{productId}}">
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
  </section>

  <section class="historia-marca">
    <h2>Nuestra Historia</h2>

    <p>
      Desde nuestros inicios, Lácteos Axume ha sido sinónimo de tradición y confianza.
      Hoy, además de lácteos, llevamos a tu mesa productos hondureños elaborados con
      recetas artesanales que preservan nuestra identidad cultural.
    </p>
  </section>

</section>