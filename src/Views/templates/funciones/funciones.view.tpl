<h1>Trabajar con Funciones</h1>

<section>
    <form action="index.php" method="get">

        <input type="hidden" name="page" value="Funciones_Funciones">

        <div class="filtros-grid">

            <div class="filtros-campos">

                <div>
                    <label for="partialName">Descripción</label>
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

                <a href="index.php?page=Funciones_Funcion&mode=INS" class="btnop">
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
                <th>Descripción</th>
                <th>Tipo</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            {{foreach funciones}}
            <tr>
                <td>{{fncod}}</td>
                <td>
                    <a class="link" href="index.php?page=Funciones_Funcion&mode=DSP&fncod={{fncod}}">
                        {{fndsc}}
                    </a>
                </td>

                <td>{{fntyp}}</td>

                <td class="center">
                    {{fnestDsc}}
                </td>

                <td class="center">

                    <a href="index.php?page=Funciones_Funcion&mode=DSP&fncod={{fncod}}" 
                       class="btn btn-info" 
                       title="Ver">
                        <i class="fa-solid fa-eye"></i>
                    </a>

                    <a href="index.php?page=Funciones_Funcion&mode=UPD&fncod={{fncod}}" 
                       class="btn btn-warning" 
                       title="Editar">
                        <i class="fa-solid fa-edit"></i>
                    </a>

                    <a href="index.php?page=Funciones_Funcion&mode=DEL&fncod={{fncod}}" 
                       class="btn btn-danger" 
                       title="Eliminar"
                       onclick="return confirm('¿Seguro que deseas eliminar este registro?');">
                        <i class="fa-solid fa-trash"></i>
                    </a>

                </td>

            </tr>

            {{endfor funciones}}

        </tbody>

    </table>

    {{pagination}}

</section>