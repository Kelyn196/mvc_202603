<section class="cart-container">
<h2>Mi Carretilla de Compras</h2>
  <div class="cart-grid">
    <div class="cart-left">
      {{if items}}
      <form action="index.php?page=Carretilla_Carretilla" method="POST">
        <input type="hidden" name="action" value="UPD">
        <table class="cart-table">
          <thead class="cart-header">
            <tr class="cart-header-row">
              <th class="cart-header-cell">Producto</th>
              <th class="cart-header-cell">Descripción</th>
              <th class="cart-header-cell">Precio</th>
              <th class="cart-header-cell">Imagen</th>
              <th class="cart-header-cell">Cantidad</th>
              <th class="cart-header-cell">Subtotal</th>
              <th class="cart-header-cell">Acción</th>
            </tr>
          </thead>

          <tbody class="cart-body">

            {{foreach items}}
            <tr class="cart-item">

              <td>
                {{productName}}
                <input type="hidden" name="items[{{productId}}][productId]" value="{{productId}}">
              </td>

              <td>
                {{productDescription}}
              </td>

              <td class="cart-price">
                L. {{crrprc}}
              </td>

              <td class="cart-image">
                <img src="{{productImgUrl}}" alt="{{productName}}" class="cart-img">
              </td>

              <td class="cart-quantity">
                <input type="number" class="cart-input" name="items[{{productId}}][crrctd]" value="{{crrctd}}" min="1">
              </td>

              <td class="cart-subtotal">
                L. {{subtotal}}
              </td>

              <td class="cart-action">
                <a href="index.php?page=Carretilla_Carretilla&action=DEL&productId={{productId}}"
                  class="cart-btn-delete" onclick="return confirm('¿Eliminar este producto?');">
                  <i class="fas fa-trash"></i>
                </a>
              </td>

            </tr>
            {{endfor items}}

          </tbody>
        </table>

        <div class="cart-actions">
          <button type="submit" class="cart-btn cart-btn-update">
            Actualizar
          </button>

          <a href="index.php?page=Products_Products" class="cart-btn cart-btn-continue">
            Seguir Comprando
          </a>
        </div>
</form>
{{endif items}}
{{ifnot items}}
<div class="cart-empty">
    <h2>Tu carretilla está vacía</h2>
    <p>Agrega algunos productos para comenzar.</p>
    <a href="index.php?page=Products_Products" class="cart-btn cart-btn-continue">Ver Productos</a>
</div>
{{endifnot items}}

    </div>

    <div class="cart-right">

      <section class="cart-summary">

        <h3 class="cart-summary-title">
          Resumen del Pedido
        </h3>

        <p class="cart-summary-line">
          Subtotal: L. {{totalGeneral}}
        </p>

        <p class="cart-summary-line">
          Envío: Gratis
        </p>

        <p class="cart-summary-line">
          Total: L. {{totalGeneral}}
        </p>

        <a href="#" class="cart-btn cart-btn-pay">
          Proceder al Pago
        </a>

        <p class="cart-safe">
          Pago 100% seguro
        </p>

      </section>

    </div>

  </div>
</section>