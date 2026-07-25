<section class="container-m row px-4 py-4">
    <h1>{{FormTitle}}</h1>
</section>

<section class="container-m row px-4 py-4">
    <form action="index.php?page=Roles_Rol&mode={{~mode}}&rolescod={{rolescod}}"
        method="POST"
        class="col-12 col-m-8 offset-m-2">

        <input type="hidden" name="rolescod" value="{{rolescod}}">
        <input type="hidden" name="mode" value="{{~mode}}">
        <input type="hidden" name="token" value="{{~rol_xss_token}}">

        <div class="row my-2">
            <label class="col-12 col-m-3" for="rolescod">Código</label>
            {{if isInsert}}
            <input class="col-12 col-m-9" type="text" id="rolescod" name="rolescod" value="{{rolescod}}" placeholder="Ej: ADMIN" required />
            {{else isInsert}}
            <input class="col-12 col-m-9" type="text" id="rolescod" name="rolescod" value="{{rolescod}}" readonly />
            {{endif isInsert}}

            {{if rolescod_error}}
            <div class="error col-12 offset-m-3">{{rolescod_error}}</div>
            {{endif rolescod_error}}
        </div>

        <div class="row my-2">
            <label class="col-12 col-m-3" for="rolesdsc">Descripción</label>
            <input class="col-12 col-m-9" type="text" id="rolesdsc" name="rolesdsc" value="{{rolesdsc}}" {{readonly}} />

            {{if rolesdsc_error}}
            <div class="error col-12 offset-m-3">{{rolesdsc_error}}</div>
            {{endif rolesdsc_error}}
        </div>

        <div class="row my-2">
            <label class="col-12 col-m-3" for="rolesest">Estado</label>
            <select class="col-12 col-m-9" name="rolesest" id="rolesest" {{readonly}}>
                <option value="ACT" {{rolesest_act}}>Activo</option>
                <option value="INA" {{rolesest_ina}}>Inactivo</option>
            </select>
        </div>

        <div class="row my-4 flex-end">
            {{if showCommitBtn}}
            <button class="primary col-12 col-m-2" type="submit">
                Confirmar
            </button>
            &nbsp;
            {{endif showCommitBtn}}

            <button class="col-12 col-m-2" type="button" id="btnCancelar">
                Cancelar
            </button>
        </div>
    </form>
</section>

<script>
document.addEventListener("DOMContentLoaded", () => {
    document.getElementById("btnCancelar").addEventListener("click", (e) => {
        e.preventDefault();
        window.location.href = "index.php?page=Roles_Roles";
    });
});
</script>