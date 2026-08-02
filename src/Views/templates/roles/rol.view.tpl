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
            <label class="col-12 col-m-3">Código</label>
            <!-- SE AGREGA name="rolescod" Y {{readonly}} -->
            <input class="col-12 col-m-9" name="rolescod" value="{{rolescod}}" {{readonly}}>
            
            {{if rolescod_error}}
            <div class="error">{{rolescod_error}}</div>
            {{endif rolescod_error}}
        </div>

        <div class="row my-2">
            <label class="col-12 col-m-3">Descripción</label>
            <input class="col-12 col-m-9"
                   name="rolesdsc"
                   value="{{rolesdsc}}"
                   {{readonly}}>

            {{if rolesdsc_error}}
            <div class="error">{{rolesdsc_error}}</div>
            {{endif rolesdsc_error}}
        </div>

        <div class="row my-2">
            <label class="col-12 col-m-3">Estado</label>
            <select class="col-12 col-m-9" name="rolesest" {{disabled}}>
                <option value="ACT" {{rolesest_act}}>Activo</option>
                <option value="INA" {{rolesest_ina}}>Inactivo</option>
            </select>
        </div>
        
        <div class="row my-4 flex-end">
            <div class="form-actions">
                {{if showCommitBtn}}
                    <button class="btn-brown" type="submit" name="btnConfirmar">
                        Confirmar
                    </button>
                {{endif showCommitBtn}}

                <button class="btn-brown" type="button" id="btnCancelar">
                    {{if showCommitBtn}}Cancelar{{endif showCommitBtn}}
                </button>
            </div>
        </div> <!-- SE CIERRA EL DIV QUE FALTABA -->
    </form>
</section>

<script>
document.addEventListener("DOMContentLoaded", () => {
    document.getElementById("btnCancelar").addEventListener("click", () => {
        window.location.href = "index.php?page=Roles_Roles";
    });
});
</script>