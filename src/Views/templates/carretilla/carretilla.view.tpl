<section class="container-m py-5">
  <!-- Header -->
  <div class="d-flex align-items-center mb-4" style="gap: 15px;">
    <div>
      <h1 style="margin: 0; font-size: 1.8rem; font-weight: 700; color: #2c3e50;">Mi Carretilla de Compras</h1>
      <p style="margin: 0; color: #7f8c8d; font-size: 0.95rem;">
        {{if items}}Tienes {{countItems}} producto(s) en tu carretilla{{endif items}}
      </p>
    </div>
  </div>

  {{if items}}
  <div class="row" style="gap: 25px;">
    
    <!-- Lista de productos -->
    <div class="col-lg-8">
      <form action="index.php?page=Carretilla_Carretilla" method="POST">
        <input type="hidden" name="action" value="UPD">
        
        <div style="background: white; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,0.06); overflow: hidden;">
          <table style="width: 100%; border-collapse: collapse;">
            <thead>
              <tr style="background: #f8f9fa; border-bottom: 2px solid #e9ecef;">
                <th style="padding: 15px 20px; text-align: left; font-weight: 600; color: #495057; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.5px;">Producto</th>
                <th style="padding: 15px 20px; text-align: right; font-weight: 600; color: #495057; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.5px;">Precio</th>
                <th style="padding: 15px 20px; text-align: center; font-weight: 600; color: #495057; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.5px;">Cantidad</th>
                <th style="padding: 15px 20px; text-align: right; font-weight: 600; color: #495057; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.5px;">Subtotal</th>
                <th style="padding: 15px 20px; text-align: center; font-weight: 600; color: #495057; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.5px;"></th>
              </tr>
            </thead>
            <tbody>
              {{foreach items}}
              <tr class="cart-item" style="border-bottom: 1px solid #f0f0f0; transition: background 0.2s;">
                <td style="padding: 20px;">
                  <div style="display: flex; align-items: center; gap: 15px;">
                    <div style="flex-shrink: 0; width: 70px; height: 70px; border-radius: 8px; overflow: hidden; background: #f8f9fa;">
                      <img src="{{productImgUrl}}" alt="{{productName}}" style="width: 100%; height: 100%; object-fit: cover;" />
                    </div>
                    <div>
                      <strong style="display: block; color: #2c3e50; font-size: 1rem; margin-bottom: 4px;">{{productName}}</strong>
                      <small style="color: #7f8c8d; font-size: 0.85rem;">{{productDescription}}</small>
                    </div>
                    <input type="hidden" name="items[{{productId}}][productId]" value="{{productId}}">
                  </div>
                </td>
                <td style="padding: 20px; text-align: right; color: #495057; font-weight: 500;">
                  L. {{crrprc}}
                </td>
                <td style="padding: 20px; text-align: center;">
                  <div style="display: inline-flex; align-items: center; border: 1px solid #dee2e6; border-radius: 6px; overflow: hidden;">
                    <input type="number" name="items[{{productId}}][crrctd]" value="{{crrctd}}" min="1" 
                           style="width: 60px; text-align: center; border: none; padding: 8px; font-weight: 600; outline: none;" />
                  </div>
                </td>
                <td style="padding: 20px; text-align: right;">
                  <strong style="color: #2b8251; font-size: 1.05rem;">L. {{subtotal}}</strong>
                </td>
                <td style="padding: 20px; text-align: center;">
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

        <!-- Botones de acción -->
        <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap" style="gap: 15px;">
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
      <div style="background: white; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,0.06); padding: 25px; position: sticky; top: 20px;">
        <h3 style="margin: 0 0 20px 0; font-size: 1.2rem; font-weight: 700; color: #2c3e50; padding-bottom: 15px; border-bottom: 2px solid #f0f0f0;">
          <i class="fas fa-receipt" style="color: #2b8251; margin-right: 8px;"></i>
          Resumen del Pedido
        </h3>
        
        <div style="display: flex; flex-direction: column; gap: 12px; margin-bottom: 20px;">
          <div class="d-flex justify-content-between" style="color: #6c757d;">
            <span>Subtotal</span>
            <span>L. {{totalGeneral}}</span>
          </div>
          <div class="d-flex justify-content-between" style="color: #6c757d;">
            <span>Envío</span>
            <span style="color: #2b8251; font-weight: 500;">Gratis</span>
          </div>
        </div>

        <div style="padding: 15px 0; border-top: 2px dashed #e9ecef; margin-bottom: 20px;">
          <div class="d-flex justify-content-between align-items-center">
            <strong style="font-size: 1.1rem; color: #2c3e50;">Total</strong>
            <strong style="font-size: 1.5rem; color: #2b8251;">L. {{totalGeneral}}</strong>
          </div>
        </div>

        <a href="index.php?page=Checkout_Checkout" class="btn-checkout">
          <i class="fas fa-lock"></i> Proceder al Pago
        </a>

        <div style="margin-top: 20px; padding-top: 15px; border-top: 1px solid #f0f0f0; text-align: center;">
          <small style="color: #95a5a6;">
            <i class="fas fa-shield-alt" style="margin-right: 5px;"></i>
            Pago 100% seguro
          </small>
        </div>
      </div>
    </div>
  </div>

  {{else}}
  

  {{endif items}}
</section>

<style>
  .cart-item:hover {
    background: #fafbfc;
  }
  
  .btn-delete {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    border-radius: 8px;
    background: #fff5f5;
    color: #c21010;
    text-decoration: none;
    transition: all 0.2s;
  }
  
  .btn-delete:hover {
    background: #c21010;
    color: white;
    transform: scale(1.05);
  }
  
  .btn-primary {
    background: linear-gradient(135deg, #2b8251, #3aa868);
    color: white;
    padding: 12px 24px;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
  }
  
  .btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(43, 130, 81, 0.3);
  }
  
  .btn-secondary {
    background: #f8f9fa;
    color: #495057;
    padding: 12px 24px;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
  }
  
  .btn-secondary:hover {
    background: #e9ecef;
    border-color: #ced4da;
  }
  
  .btn-checkout {
    display: block;
    width: 100%;
    background: linear-gradient(135deg, #2b8251, #3aa868);
    color: white;
    padding: 15px;
    border-radius: 8px;
    text-align: center;
    text-decoration: none;
    font-weight: 700;
    font-size: 1.05rem;
    transition: all 0.2s;
    box-shadow: 0 2px 8px rgba(43, 130, 81, 0.2);
  }
  
  .btn-checkout:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 16px rgba(43, 130, 81, 0.35);
    color: white;
  }
  
  /* Responsive */
  @media (max-width: 768px) {
    .cart-item td {
      display: block;
      padding: 10px 15px !important;
      text-align: right !important;
    }
    
    .cart-item td:first-child {
      text-align: left !important;
      border-bottom: 1px solid #f0f0f0;
    }
    
    .cart-item td:before {
      content: attr(data-label);
      float: left;
      font-weight: 600;
      color: #495057;
    }
  }
</style>