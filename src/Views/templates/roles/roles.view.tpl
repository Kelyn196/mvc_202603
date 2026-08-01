<h1>Trabajar con Roles</h1>

<section>
  <form action="index.php" method="get">

    <input type="hidden" name="page" value="Roles_Roles">

    <div class="filtros-grid">

      <div class="filtros-campos">

        <div>
          <label for="partialName">Codigo</label>
          <input type="text" id="partialName" name="partialName" value="{{partialName}}">
        </div>

        <div>
          <label for="status">Estado</label>
          <select id="status" name="status">
            <option value="EMP" {{status_EMP}}>Todos</option>
            <option value="ACT" {{status_ACT}}>Activo</option>
            <option value="INA" {{status_INA}}>Inactivo</option>
          </select>
        </div>

      </div>

      <div class="filtros-botones">

        <button type="submit" class="btnop">
          Filtrar
        </button>

        <a href="index.php?page=Roles_Rol&mode=INS" class="btnop">
          Nuevo
        </a>

      </div>

    </div>

  </form>
</section>

<section class="WWList">
  <table>
    <thead>
      <tr>
        <th>Código</th>
        <th class="left">Descripción</th>
        <th>Estado</th>
        <th class="center">Acciones</th>
      </tr>
    </thead>
    <tbody>
      {{foreach roles}}
      <tr>
        <td>{{rolescod}}</td>
        <td>
          <a class="link" href="index.php?page=Roles_Rol&mode=DSP&rolescod={{rolescod}}">
            {{rolesdsc}}
          </a>
        </td>
        <td>{{rolesestDsc}}</td>
        <td class="center">
          <div class="acciones">

            <a href="index.php?page=Roles_Rol&mode=DSP&rolescod={{rolescod}}" class="action-btn" title="Ver">
              <i class="fa-solid fa-eye"></i>
            </a>

            <a href="index.php?page=Roles_Rol&mode=UPD&rolescod={{rolescod}}" class="action-btn" title="Editar">
              <i class="fa-solid fa-pen-to-square"></i>
            </a>

            <a href="index.php?page=Roles_Rol&mode=DEL&rolescod={{rolescod}}" class="action-btn" title="Eliminar">
              <i class="fa-solid fa-trash"></i>
            </a>

          </div>
        </td>
      </tr>
      {{endfor roles}}
    </tbody>
  </table>
  {{pagination}}
</section>