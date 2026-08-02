<section class="container-m row px-4 py-4">
    <h1>{{FormTitle}}</h1>
</section>

<section class="container-m row px-4 py-4" style="min-height: 60vh;">
    <form action="index.php?page=Funciones_Funcion&mode={{~mode}}&fncod={{fncod}}" method="POST"
        class="col-12 col-m-8 offset-m-2">
        
        <div class="row my-2 align-center">
            <label class="col-12 col-m-3">Código</label>
            <input class="col-12 col-m-9" type="text" name="fncod" value="{{fncod}}" {{readonly}} />
            {{if fncod_error}}
            <div class="error col-12 col-m-9 offset-m-3">
                {{fncod_error}}
            </div>
            {{endif fncod_error}}
        </div>

        <div class="row my-2 align-center">
            <label class="col-12 col-m-3">Descripción</label>
            <input class="col-12 col-m-9" type="text" name="fndsc" value="{{fndsc}}" {{readonly}} />
            {{if fndsc_error}}
            <div class="error col-12 col-m-9 offset-m-3">
                {{fndsc_error}}
            </div>
            {{endif fndsc_error}}
        </div>

        <div class="row my-2 align-center">
            <label class="col-12 col-m-3">Estado</label>
            <select class="col-12 col-m-9" name="fnest" {{if readonly}}disabled{{endif readonly}}>
                <option value="ACT" {{fnest_ACT}}>Activo</option>
                <option value="INA" {{fnest_INA}}>Inactivo</option>
            </select>
        </div>

        <div class="row my-2 align-center">
            <label class="col-12 col-m-3">Tipo</label>
            <select class="col-12 col-m-9" name="fntyp" {{if readonly}}disabled{{endif readonly}}>
                <option value="MEN" {{fntyp_MEN}}>Menú</option>
                <option value="API" {{fntyp_API}}>API</option>
            </select>
        </div>

        <div class="row my-4 align-center flex-end">
    {{if showCommitBtn}}
    <!-- Cambiamos "primary" por "btn-brown" -->
    <button class="btn-brown" type="submit" name="btnConfirmar">
        Confirmar
    </button>
    {{endif showCommitBtn}}

    <button class="btn-brown" type="button" id="btnCancelar">
        Cancelar
    </button>
</div>
    </form>
</section>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        document.getElementById("btnCancelar").addEventListener("click", () => {
            window.location = "index.php?page=Funciones_Funciones";
        });
    });
</script>