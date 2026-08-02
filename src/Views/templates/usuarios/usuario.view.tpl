<section class="container-m row px-4 py-4">
    <h1>{{FormTitle}}</h1>
</section>

<section class="container-m row px-4 py-4" style="min-height: 60vh;">

    <form action="index.php?page=Usuarios_Usuario&mode={{~mode}}" method="POST" class="col-12 col-m-8 offset-m-2">

        <input type="hidden" name="usercod" value="{{usercod}}">
        <input type="hidden" name="mode" value="{{~mode}}">
        <input type="hidden" name="usuario_xss_token" value="{{usuario_xss_token}}">

        <div class="row my-2 align-center">
            <label class="col-12 col-m-3">Código</label>
            <input class="col-12 col-m-9" type="text" value="{{usercod}}" readonly>
        </div>

        <div class="row my-2 align-center">
            <label class="col-12 col-m-3">Correo Electrónico</label>

            <input class="col-12 col-m-9"
                   type="email"
                   name="useremail"
                   value="{{useremail}}"
                   {{readonly}}>

            {{if useremail_error}}
            <div class="error col-12 col-m-9 offset-m-3">
                {{useremail_error}}
            </div>
            {{endif useremail_error}}
        </div>

        <div class="row my-2 align-center">
            <label class="col-12 col-m-3">Nombre de Usuario</label>

            <input class="col-12 col-m-9"
                   type="text"
                   name="username"
                   value="{{username}}"
                   {{readonly}}>

            {{if username_error}}
            <div class="error col-12 col-m-9 offset-m-3">
                {{username_error}}
            </div>
            {{endif username_error}}
        </div>

        <div class="row my-2 align-center">
            <label class="col-12 col-m-3">Contraseña</label>

            <input class="col-12 col-m-9"
                   type="password"
                   name="userpswd"
                   value="{{userpswd}}"
                   {{readonly}}>

            {{if userpswd_error}}
            <div class="error col-12 col-m-9 offset-m-3">
                {{userpswd_error}}
            </div>
            {{endif userpswd_error}}
        </div>

        <div class="row my-2 align-center">
            <label class="col-12 col-m-3">Estado</label>

            <select class="col-12 col-m-9"
                    name="userest"
                    {{if readonly}}disabled{{endif readonly}}>
                <option value="ACT" {{userest_ACT}}>Activo</option>
                <option value="INA" {{userest_INA}}>Inactivo</option>
            </select>
        </div>

        <div class="row my-2 align-center">
            <label class="col-12 col-m-3">Tipo de Usuario</label>

            <select class="col-12 col-m-9"
                    name="usertipo"
                    {{if readonly}}disabled{{endif readonly}}>
                <option value="NOR" {{usertipo_NOR}}>Administrador</option>
                <option value="CON" {{usertipo_CON}}>Supervisor</option>
                <option value="CLI" {{usertipo_CLI}}>Cliente</option>
            </select>
        </div>

        <div class="row my-4 align-center flex-end">

            {{if showCommitBtn}}
            <button class="btn-brown" type="submit" name="btnConfirmar">
                Confirmar
            </button>
            {{endif showCommitBtn}}

            <!-- TEXTO CAMBIADO A "Regresar" -->
            <button class="btn-brown" type="button" id="btnCancelar">
                Regresar
            </button>

        </div>

    </form>

</section>

<script>
document.addEventListener("DOMContentLoaded", () => {
    document.getElementById("btnCancelar").addEventListener("click", () => {
        window.location = "index.php?page=Usuarios_Usuarios";
    });
});
</script>