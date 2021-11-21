<section class="contenedor-creacion-autor">
    <div class="contenedor-info-creacion-autor">
        <h1 class="encabezado-info-creacion-autor">Creación de autor</h1>
        <p class="texto-info-creacion-autor">Desde aquí puedes crear una nueva autor para la biblioteca.</p>
    </div>
    @if ($errors->any())
        <div class="contenedor-errores">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="/process-author-creation" method="post">
        @csrf
        <div class="contenedor-input">
            <label for="author-name">Nombre del autor <span class="required">*</span></label>
            <input name="name" id="author-name" type="text" maxlength="100"/>
        </div>
        <div class="contenedor-input">
            <label for="author-pseudonym">Pseudónimo del autor</label>
            <input name="pseudonym" id="author-pseudonym" type="text" maxlength="100"/>
        </div>
        <div class="contenedor-input">
            <label for="author-birth-date">Fecha de nacimiento del autor <span class="required">*</span></label>
            <input name="birth-date" id="author-birth-date" type="date"/>
        </div>
        <div class="contenedor-input">
            <label for="author-death-date">Fecha de fallecimiento del autor <span class="required">*</span></label>
            <input name="death-date" id="author-death-date" type="date"/>
        </div>
        <div class="contenedor-input">
            <input class="btn-submit" type="submit" value="Crear autor"/>
        </div>
    </form>
</section>