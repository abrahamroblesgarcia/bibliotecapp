<section class="contenedor-ver-libros">
    <div class="contenedor-avisos">
        @if(session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif
    </div>
    <div class="contenedor-info-ver-libros">
        <h1 class="encabezado-info-ver-libros">Listado de libros</h1>
        <p class="texto-info-ver-libros">Desde aquí puedes ver todos los libros que hay</p>
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
    <div class="contendor-libros">
        @foreach ($books as $book)
            <div class="libro">
                <p>Título: {{ $book->title }}</p>
                <p>ISBN: {{ $book->ISBN }}</p>
                <p>Descripción: {{ $book->description }}</p>
                <p><a href="/edit-book/{{ $book->id }}">Editar</a></p>
                <p><a href="/delete-book/{{ $book->id }}">Borrar</a></p>
            </div>
            <hr/>
        @endforeach
    </div>
</section>