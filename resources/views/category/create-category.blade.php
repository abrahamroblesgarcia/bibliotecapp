@section('content')
<section class="contenedor-creacion-categoria">
    <div class="contenedor-info-creacion-categoria">
        <h1 class="encabezado-info-creacion-categoria">Creación de categoría</h1>
        <p class="texto-info-creacion-categoria">Desde aquí puedes crear una nueva categoría de la biblioteca.</p>
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
    <form action="/process-category-creation" method="post">
        @csrf
        <div class="contenedor-input">
            <label for="category-name">Nombre de la categoría <span class="required">*</span></label>
            <input name="name" id="category-name" type="text" maxlength="100"/>
        </div>
        <div class="contenedor-input">
            <label for="category-description">Descripción de la categoría</label>
            <textarea name="description" id="category-description"></textarea>
        </div>
        <div class="contenedor-input">
            <input class="btn-submit" type="submit" value="Crear categoría"/>
        </div>
    </form>
</section>
@endsection
@include('dashboard')