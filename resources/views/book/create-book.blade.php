<section class="contenedor-creacion-libro">
    <div class="contenedor-info-creacion-libro">
        <h1 class="encabezado-info-creacion-libro">Creación de libro</h1>
        <p class="texto-info-creacion-libro">Desde aquí puedes crear un nuevo libro para la biblioteca.</p>
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
    <form action="/process-book-creation" method="post">
        @csrf
        <div class="contenedor-input">
            <label for="book-name">Título del libro <span class="required">*</span></label>
            <input name="title" id="book-name" type="text" maxlength="100"/>
        </div>
        <div class="contenedor-input">
            <label for="book-ISBN">ISBN <span class="required">*</span></label>
            <input name="ISBN" id="book-ISBN" type="text" maxlength="100"/>
        </div>
        <div class="contenedor-input">
            <label for="book-description">Descripción del libro</label>
            <textarea id="book-description" name="description"></textarea>
        </div>
        <div class="contenedor-input">
            <input class="btn-submit" type="submit" value="Crear libro"/>
        </div>
    </form>
</section>