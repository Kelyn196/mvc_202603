<section class="container-m py-5">
  <!-- Header -->
  <div class="d-flex align-items-center mb-4 header-cart">
    <div>
      <h1 class="title-cart">Mi Carretilla de Compras</h1>
      <p class="subtitle-cart">
        {{if items}}Tienes {{countItems}} producto(s) en tu carretilla{{endif items}}
      </p>
    </div>
  </div>

  {{if items}}
  <div class="row cart-row">
    <div class="col-lg-8">
      <form action="index.php?page=Carretilla_Carretilla" method="POST">
        <input type="hidden" name="action" value="UPD">

        <div class="cart-box">
          <table class="cart-table">
            <thead>
              <tr>
                <th>Producto</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Subtotal</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              {{foreach items}}
              <tr class="cart-item">
                <td>
                  <div class="cart-product">
                    <div class="cart-img">
                      <img src="{{productImgUrl}}" alt="{{productName}}" />
                    </div>
                    <div>
                      <strong class="product-name">{{productName}}</strong>
                      <small class="product-desc">{{productDescription}}</small>
                    </div>
                    <input type="hidden" name="items[{{productId}}][productId]" value="{{productId}}">
                  </div>
                </td>
                <td class="text-right">L. {{crrprc}}</td>
                <td class="text-center">
                  <div class="quantity-box">
                    <input type="number" name="items[{{productId}}][crrctd]" value="{{crrctd}}" min="1" />
                  </div>
                </td>
                <td class="text-right">
                  <strong class="subtotal">L. {{subtotal}}</strong>
                </td>
                <td class="text-center">
                  <a href="index.php?page=Carretilla_Carretilla&action=DEL&productId={{productId}}" 
                     onclick="return confirm('¿Estás seguro de eliminar este producto de la carretilla?');" 
                     class="btn-delete" title="Eliminar producto">
                    <i class="fas fa-trash-alt"></i>
                  </a>
                </td>
              </tr>
              {{endfor items}}
            </tbody>
          </table>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap cart-actions">
          <a href="index.php?page=Products_Products" class="btn-secondary">
            <i class="fas fa-arrow-left"></i> Seguir Comprando
          </a>
          <button type="submit" class="btn-primary">
            <i class="fas fa-sync-alt"></i> Actualizar Cantidades
          </button>
        </div>
      </form>
    </div>

    <!-- Resumen del pedido -->
    <div class="col-lg-4">
      <div class="summary-box">
        <h3 class="summary-title">
          <i class="fas fa-receipt"></i> Resumen del Pedido
        </h3>
        
        <div class="summary-details">
          <div class="d-flex justify-content-between">
            <span>Subtotal</span>
            <span>L. {{totalGeneral}}</span>
          </div>
          <div class="d-flex justify-content-between">
            <span>Envío</span>
            <span class="free-shipping">Gratis</span>
          </div>
        </div>

        <div class="summary-total">
          <div class="d-flex justify-content-between align-items-center">
            <strong>Total</strong>
            <strong class="total-price">L. {{totalGeneral}}</strong>
          </div>
        </div>

        <a href="index.php?page=Checkout_Checkout" class="btn-checkout">
          <i class="fas fa-lock"></i> Proceder al Pago
        </a>

        <div class="secure-payment">
          <small>
            <i class="fas fa-shield-alt"></i> Pago 100% seguro
          </small>
        </div>
      </div>
    </div>
  </div>
  {{else}}
  {{endif items}}
</section>
