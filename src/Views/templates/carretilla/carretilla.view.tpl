<section class="container-m row px-4 py-4">
  <h1>Mi Carretilla de Compras</h1>
  
  {{if items}}
  <section class="WWList">
    <form action="index.php?page=Carretilla_Carretilla" method="POST">
      <input type="hidden" name="action" value="UPD">
      <table>
        <thead>
          <tr>
            <th>Producto</th>
            <th>Precio Unitario</th>
            <th class="center">Cantidad</th>
            <th class="right">Subtotal</th>
            <th class="center">Acciones</th>
          </tr>
        </thead>
        <tbody>
          {{foreach items}}
          <tr>
            <td>
              <div style="display: flex; align-items: center; gap: 10px;">
                <img src="{{productImgUrl}}" alt="{{productName}}" width="60" height="60" style="object-fit: cover; border-radius: 4px;" />
                <div>
                  <strong>{{productName}}</strong><br/>
                  <small>{{productDescription}}</small>
                </div>
              </div>
              <input type="hidden" name="items[{{productId}}][productId]" value="{{productId}}">
            </td>
            <td class="right">L. {{crrprc}}</td>
            <td class="center">
              <input type="number" name="items[{{productId}}][crrctd]" value="{{crrctd}}" min="1" style="width: 60px; text-align: center; padding: 5px;" />
            </td>
            <td class="right"><strong>L. {{subtotal}}</strong></td>
            <td class="center">
              <a href="index.php?page=Carretilla_Carretilla&action=DEL&productId={{productId}}" 
                 onclick="return confirm('¿Estás seguro de eliminar este producto de la carretilla?');" 
                 style="color: #c21010; text-decoration: none; font-weight: bold;">
                <i class="fas fa-trash"></i> Eliminar
              </a>
            </td>
          </tr>
          {{endfor items}}
        </tbody>
        <tfoot>
          <tr>
            <td colspan="3" class="right" style="padding: 15px;"><strong style="font-size: 1.2rem;">Total General:</strong></td>
            <td class="right" style="padding: 15px;"><strong style="font-size: 1.2rem; color: #2b8251;">L. {{totalGeneral}}</strong></td>
            <td></td>
          </tr>
        </tfoot>
      </table>
      <div class="row my-4 flex-end" style="gap: 10px;">
        <button type="submit" class="primary">Actualizar Cantidades</button>
        <a href="index.php?page=Products_Products" class="btn" style="background: #6c757d; color: white; padding: 10px 15px; border-radius: 4px; text-decoration: none;">Seguir Comprando</a>
      </div>
    </form>
  </section>
  {{else}}
  <div class="center py-5">
    <h2>Tu carretilla está vacía</h2>
    <p>¡Agrega algunos productos para comenzar!</p>
    <a href="index.php?page=Products_Products" class="btn primary" style="padding: 10px 20px; text-decoration: none; color: white;">Ver Productos</a>
  </div>
  {{endif items}}
</section>