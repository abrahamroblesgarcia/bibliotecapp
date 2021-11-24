@section('content')
<section class="contenedor-edicion-libro">
    <div class="contenedor-avisos">
        @if(session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif
    </div>
    <div class="contenedor-info-edicion-libro">
        <h1 class="encabezado-info-edicion-libro">Edición del libro: {{ $book->name }}</h1>
        <p class="texto-info-edicion-libro">Desde aquí editar un libro.</p>
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
    <form action="/process-book-update" method="post">
        @csrf
        <div class="contenedor-input">
            <label for="book-name">Título del libro <span class="required">*</span></label>
            <input name="title" value="{{ $book->title }}" id="book-name" type="text" maxlength="100"/>
        </div>
        <div class="contenedor-input">
            <label for="book-ISBN">ISBN <span class="required">*</span></label>
            <input name="ISBN" value="{{ $book->ISBN }}" id="book-ISBN" type="text" maxlength="100"/>
        </div>
        <div class="contenedor-input">
            <label for="book-description">Descripción del libro</label>
            <textarea id="book-description" name="description">{{ $book->description }}</textarea>
        </div>
        <div class="contenedor-input">
            <label for="book-author">Autor Asociado</label>
            <select name="author_id" id="book-author">
                @foreach( $authors as $author )
                    @if( $author->id === $book->authors->id )
                        <option selected="selected" value="{{ $author->id }}">{{ $author->name }}</option>
                    @else 
                        <option value="{{ $author->id }}">{{ $author->name }}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="contenedor-input">
            <label for="book-category">Categoría Asociada</label>
            <select name="category_id[]" id="book-category" multiple>
                @foreach( $categories as $category )
                    @php 
                        if( $book->booksCategories->contains($category) )
                        {
                            $selected = 'selected="selected"';
                        }
                        else 
                        {
                            $selected = '';
                        }
                    @endphp
                    <option {{ $selected }} value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="campos-ocultos">
            <input type="hidden" name="id" value="{{ $book->id }}"/>
        </div>
        <div class="contenedor-input">
            <input class="btn-submit" type="submit" value="Crear libro"/>
        </div>
    </form>
</section>
@endsection
@include('dashboard')