<h1>Trabajar con Roles</h1>

<section class="grid">
  <div class="row">
    <form class="col-12 col-m-8" action="index.php" method="get">
      <input type="hidden" name="page" value="Roles_Roles">
      <div class="flex align-center">
        <div class="col-8 row">

          <label class="col-3" for="partialName">Buscar</label>
          <input class="col-9" type="text" name="partialName" id="partialName" value="{{partialName}}" />

          <label class="col-3" for="status">Estado</label>
          <select class="col-9" name="status" id="status">
              <option value="" {{status_EMP}}>Todos</option>
              <option value="ACT" {{status_ACT}}>Activo</option>
              <option value="INA" {{status_INA}}>Inactivo</option>
          </select>
        </div>

        <div class="col-4 align-end">
          <button type="submit">Filtrar</button>
        </div>
      </div>
    </form>
  </div>
</section>

<section class="WWList">
  <table>
    <thead>
      <tr>
        <th>Código</th>
        <th class="left">Descripción</th>
        <th>Estado</th>
        <th>
          <a href="index.php?page=Roles_Rol&mode=INS">Nuevo</a>
        </th>
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
          <a href="index.php?page=Roles_Rol&mode=UPD&rolescod={{rolescod}}">
            Editar
          </a>
          &nbsp;
          <a href="index.php?page=Roles_Rol&mode=DEL&rolescod={{rolescod}}">
            Eliminar
          </a>
        </td>
      </tr>
      {{endfor roles}}
    </tbody>
  </table>
  {{pagination}}
</section>