<section class="container-m py-5">
  <!-- Header -->
  <div class="d-flex align-items-center mb-4 header-cart">
    <div>
      <h1>Carretilla de Compras</h1>
      <p>
        {{if items}}Tienes {{countItems}} producto(s) en tu carretilla{{endif items}}
      </p>
    </div>  </div>
  {{if items}}
  <div class="row cart-content" style="display: flex; gap: 25px;">
    <div class="col-lg-8">
      <form action="index.php?page=Carretilla_Carretilla" method="POST">
        <input type="hidden" name="action" value="UPD">
        <div class="cart-table">
          <table>
            <thead>
              <tr>
                <th>Producto</th>
                <th class="right">Precio</th>
                <th class="center">Cantidad</th>
                <th class="right">Subtotal</th>
                <th class="center"></th>
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
                      <strong>{{productName}}</strong>
                      <small>{{productDescription}}</small>
                    </div>
                    <input type="hidden" name="items[{{productId}}][productId]" value="{{productId}}">
                  </div>
                </td>
                <td class="right">L. {{crrprc}}</td>
                <td class="center">
                  <div class="cart-qty">
                    <input type="number" name="items[{{productId}}][crrctd]" value="{{crrctd}}" min="1" />
                  </div>
                </td>
                <td class="right">
                  <strong>L. {{subtotal}}</strong>
                </td>
                <td class="center">
                  <a href="index.php?page=Carretilla_Carretilla&action=DEL&productId={{productId}}" 
                     onclick="return confirm('¿Estás seguro de eliminar este producto de la carretilla?');" 
                     class="btn-delete"
                     title="Eliminar producto">
                    <i class="fas fa-trash-alt"></i>
                  </a>
                </td>
              </tr>
              {{endfor items}}
            </tbody>
          </table>
        </div>
        <div class="cart-actions">
          <a href="index.php?page=Products_Products" class="btn-secondary">
            <i class="fas fa-arrow-left"></i> Seguir Comprando
          </a>
          <button type="submit" class="btn-primary">
            <i class="fas fa-sync-alt"></i> Actualizar Cantidades
          </button>
        </div>
      </form>
    </div>
    <div class="col-lg-4">
      <div class="resumen-pedido">
        <h3>
          <i class="fas fa-receipt"></i> Resumen del Pedido
        </h3>
        <div class="resumen-detalles">
          <div class="d-flex justify-content-between">
            <span>Subtotal</span>
            <span>L. {{totalGeneral}}</span>
          </div>
          <div class="d-flex justify-content-between">
            <span>Envío</span>
            <span class="envio">Gratis</span>
          </div>
        </div>
        <div class="resumen-total">
          <div class="d-flex justify-content-between align-items-center">
            <strong>Total</strong>
            <strong class="total">L. {{totalGeneral}}</strong>
          </div>
        </div>
        <a href="index.php?page=Checkout_Checkout" class="btn-checkout">
          <i class="fas fa-lock"></i> Proceder al Pago
        </a>
        <div class="resumen-seguro">
          <small>
            <i class="fas fa-shield-alt"></i> Pago 100% seguro
          </small>
        </div>
      </div>
    </div>
  </div>
  {{else}}
  <div class="center py-5">
    <h2>Tu carretilla está vacía</h2>
    <p>¡Agrega algunos productos para comenzar!</p>
    <a href="index.php?page=Products_Products" class="btn-primary">
      <i class="fas fa-shopping-cart"></i> Ver Productos
    </a>
  </div>
  {{endif items}}
</section>

