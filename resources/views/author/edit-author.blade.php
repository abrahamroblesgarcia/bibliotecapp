<section class="contenedor-edicion-autor">
    <div class="contenedor-avisos">
        @if(session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif
    </div>
    <div class="contenedor-info-edicion-autor">
        <h1 class="encabezado-info-edicion-autor">Edición del autor: {{ $author->name }}</h1>
        <p class="texto-info-edicion-autor">Desde aquí editar un autor.</p>
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
    <form action="/process-author-update" method="post">
        @csrf
        <div class="contenedor-input">
            <label for="author-name">Nombre del autor <span class="required">*</span></label>
            <input name="name" id="author-name" type="text" maxlength="100" value="{{ $author->name }}"/>
        </div>
        <div class="contenedor-input">
            <label for="author-pseudonym">Descripción de la autor</label>
            <textarea name="pseudonym" id="author-pseudonym">{{ $author->pseudonym }}</textarea>
        </div>
        <div class="contenedor-input">
            <label for="author-birth-date">Fecha de nacimiento del autor <span class="required">*</span></label>
            <input name="birth_date" id="author-birth-date" value="{{ $author->birth_date }}" type="date"/>
        </div>
        <div class="contenedor-input">
            <label for="author-death-date">Fecha de fallecimiento del autor <span class="required">*</span></label>
            <input name="death_date" id="author-death-date" value="{{ $author->death_date }}" type="date"/>
        </div>
        <div class="campos-ocultos">
            <input type="hidden" name="id" value="{{ $author->id }}"/>
        </div>
        <div class="contenedor-input">
            <input class="btn-submit" type="submit" value="Editar autor"/>
        </div>
    </form>
</section>