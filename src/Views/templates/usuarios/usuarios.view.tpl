<h1>Trabajar con Usuarios</h1>

<section>
    <form action="index.php" method="get">

        <input type="hidden" name="page" value="Usuarios_Usuarios">

        <div class="filtros-grid">

            <div class="filtros-campos">

                <div>
                    <label for="partialName">Buscar</label>
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
                <button type="submit" class="btnop">Filtrar</button>
                <a href="index.php?page=Usuarios_Usuario&mode=INS" class="btnop">
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
        <th>Correo Electrónico</th>
        <th>Nombre de Usuario</th>
        <th>Contraseña</th>
        <th>Estado</th>
        <th>Tipo</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      {{foreach usuarios}}
      <tr>
        <td>{{usercod}}</td>
        <td>{{useremail}}</td>
        <td>
          <a class="link" href="index.php?page=Usuarios_Usuario&mode=DSP&usercod={{usercod}}">
            {{username}}
          </a>
        </td>
        <td>{{userpswd}}</td>
        <td class="center">{{userestDsc}}</td>
        <td class="center">{{usertipo}}</td>
        <td class="center">
          <a href="index.php?page=Usuarios_Usuario&mode=DSP&usercod={{usercod}}" class="btn btn-info" title="Ver">
            <i class="fa-solid fa-eye"></i>
          </a>
          <a href="index.php?page=Usuarios_Usuario&mode=UPD&usercod={{usercod}}" class="btn btn-warning" title="Editar">
            <i class="fa-solid fa-edit"></i>
          </a>
          <a href="index.php?page=Usuarios_Usuario&mode=DEL&usercod={{usercod}}" class="btn btn-danger" title="Eliminar" onclick="return confirm('¿Seguro que deseas eliminar este registro?');">
            <i class="fa-solid fa-trash"></i>
          </a>
        </td>
      </tr>
      {{endfor usuarios}}
    </tbody>
  </table>
  {{pagination}}
</section>