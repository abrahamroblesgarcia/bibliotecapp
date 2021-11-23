<section class="contenedor-ver-autores">
    <div class="contenedor-avisos">
        @if(session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif
    </div>
    <div class="contenedor-info-ver-autores">
        <h1 class="encabezado-info-ver-autores">Listado de autores</h1>
        <p class="texto-info-ver-autores">Desde aquí puedes ver todos los autores que hay</p>
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
    <div class="contendor-autores">
        @foreach ($authors as $author)
            <div class="autor">
                <p>Nombre: {{ $author->name }}</p>
                <p>Pseudónimo: {{ $author->pseudonym }}</p>
                <p>Fecha de nacimiento: {{ $author->birth_date }}</p>
                <p>Fecha de fallecimiento: {{ $author->death_date }}</p>
                <p><a href="/edit-author/{{ $author->id }}">Editar</a></p>
                <p><a href="/delete-author/{{ $author->id }}">Borrar</a></p>
            </div>
            <hr/>
        @endforeach
    </div>
</section>