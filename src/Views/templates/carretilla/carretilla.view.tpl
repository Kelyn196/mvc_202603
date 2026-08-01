<section class="cart-container">
  <div class="cart-grid">
    <div class="cart-left">
      <table class="cart-table">
        <thead class="cart-header">
          <tr class="cart-header-row">
            <th class="cart-header-cell">Producto</th>
            <th class="cart-header-cell">Precio</th>
            <th class="cart-header-cell">Cantidad</th>
            <th class="cart-header-cell">Subtotal</th>
            <th class="cart-header-cell">Acción</th>
          </tr>
        </thead>
        <tbody class="cart-body">
          <tr class="cart-item">
            <td class="cart-product">
              <img src="img/queso.jpg" alt="Queso Semi Seco" class="cart-img">
              <span class="cart-name">Queso Semi Seco</span>
            </td>
            <td class="cart-price">L. 45.00</td>
            <td class="cart-quantity">
              <input type="number" value="2" class="cart-input">
            </td>
            <td class="cart-subtotal">L. 90</td>
            <td class="cart-action">
              <button class="cart-btn-delete" title="Eliminar producto">
                <i class="fas fa-trash"></i>
              </button>
            </td>
          </tr>
        </tbody>
      </table>
      <div class="cart-actions">
        <button class="cart-btn cart-btn-update">Actualizar Cantidades</button>
        <button class="cart-btn cart-btn-continue">Seguir Comprando</button>
      </div>
    </div>
    <div class="cart-right">
      <section class="cart-summary">
        <h3 class="cart-summary-title">Resumen del Pedido</h3>
        <p class="cart-summary-line">Subtotal: L. 90</p>
        <p class="cart-summary-line">Envío: Gratis</p>
        <p class="cart-summary-line">Total: L. 90</p>
        <a href="#" class="cart-btn cart-btn-pay">Proceder al Pago</a>
        <p class="cart-safe">Pago 100% seguro</p>
      </section>
    </div>
  </div>
</section>