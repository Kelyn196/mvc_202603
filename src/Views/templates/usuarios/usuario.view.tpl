<section class="grid">
    <h2>{{FormTitle}}</h2>
</section>

<section class="container-m row px-4 py-4" style="min-height: 60vh;">

    <form action="index.php?page=Usuarios_Usuario&mode={{~mode}}" method="POST"
          class="col-12 col-m-8 offset-m-2 user-form-card">

        <input type="hidden" name="usercod" value="{{usercod}}">
        <input type="hidden" name="mode" value="{{~mode}}">
        <input type="hidden" name="usuario_xss_token" value="{{usuario_xss_token}}">

        <div class="uf-group">
            <label class="uf-label">Código</label>
            <input class="uf-input uf-input-readonly" type="text" value="{{usercod}}" readonly>
        </div>

        <div class="uf-group">
            <label class="uf-label">Correo Electrónico</label>
            <input class="uf-input"
                   type="email"
                   name="useremail"
                   value="{{useremail}}"
                   {{readonly}}>

            {{if useremail_error}}
            <div class="uf-error">{{useremail_error}}</div>
            {{endif useremail_error}}
        </div>

        <div class="uf-group">
            <label class="uf-label">Nombre de Usuario</label>
            <input class="uf-input"
                   type="text"
                   name="username"
                   value="{{username}}"
                   {{readonly}}>

            {{if username_error}}
            <div class="uf-error">{{username_error}}</div>
            {{endif username_error}}
        </div>

        <div class="uf-group">
            <label class="uf-label">Contraseña</label>
            <input class="uf-input"
                   type="password"
                   name="userpswd"
                   value="{{userpswd}}"
                   {{readonly}}>

            {{if userpswd_error}}
            <div class="uf-error">{{userpswd_error}}</div>
            {{endif userpswd_error}}
        </div>

        <div class="uf-row-2">
            <div class="uf-group">
                <label class="uf-label">Estado</label>
                <select class="uf-input"
                        name="userest"
                        {{if readonly}}disabled{{endif readonly}}>
                    <option value="ACT" {{userest_ACT}}>Activo</option>
                    <option value="INA" {{userest_INA}}>Inactivo</option>
                </select>
            </div>

            <div class="uf-group">
                <label class="uf-label">Tipo de Usuario</label>
                <select class="uf-input"
                        name="tipousuario"
                        {{if readonly}}disabled{{endif readonly}}>
                    <option value="ADM" {{tipousuario_ADM}}>Administrador</option>
                    <option value="SUP" {{tipousuario_SUP}}>Supervisor</option>
                    <option value="EMP" {{tipousuario_EMP}}>Empleado</option>
                    <option value="CLI" {{tipousuario_CLI}}>Cliente</option>
                </select>
            </div>
        </div>
        </div>
    </form>
        <div class="uf-actions">
            {{if showCommitBtn}}
            <button class="uf-btn uf-btn-primary" type="submit" name="btnConfirmar">
                Confirmar
            </button>
            {{endif showCommitBtn}}

            <button class="uf-btn uf-btn-secondary" type="button" id="btnCancelar">
                Regresar
            </button>
</section>

<script>
document.addEventListener("DOMContentLoaded", () => {
    document.getElementById("btnCancelar").addEventListener("click", () => {
        window.location = "index.php?page=Usuarios_Usuarios";
    });
});
</script>