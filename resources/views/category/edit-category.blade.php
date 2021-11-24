@section('content')
<section class="contenedor-edicion-categoria">
    <div class="contenedor-avisos">
        @if(session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif
    </div>
    <div class="contenedor-info-edicion-categoria">
        <h1 class="encabezado-info-edicion-categoria">Edición de la categoría: {{ $category->name }}</h1>
        <p class="texto-info-edicion-categoria">Desde aquí editar una categoría.</p>
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
    <form action="/process-category-update" method="post">
        @csrf
        <div class="contenedor-input">
            <label for="category-name">Nombre de la categoría <span class="required">*</span></label>
            <input name="name" id="category-name" type="text" maxlength="100" value="{{ $category->name }}"/>
        </div>
        <div class="contenedor-input">
            <label for="category-description">Descripción de la categoría</label>
            <textarea name="description" id="category-description">{{ $category->description }}</textarea>
        </div>
        <div class="campos-ocultos">
            <input type="hidden" name="id" value="{{ $category->id }}"/>
        </div>
        <div class="contenedor-input">
            <input class="btn-submit" type="submit" value="Editar categoría"/>
        </div>
    </form>
</section>
@endsection
@include('dashboard')