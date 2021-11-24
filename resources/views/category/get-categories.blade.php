@section('content')
<section class="contenedor-ver-categorias">
    <div class="contenedor-avisos">
        @if(session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif
    </div>
    <div class="contenedor-info-ver-categorias">
        <h1 class="encabezado-info-ver-categorias">Listado de categorías</h1>
        <p class="texto-info-ver-categorias">Desde aquí puedes ver todas las categorías que hay</p>
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
    <div class="contendor-categorias">
        @foreach ($categories as $category)
            <div class="categoria">
                <p>Nombre: {{ $category->name }}</p>
                <p>Descripcion: {{ $category->description }}</p>
                <p><a href="/edit-category/{{ $category->id }}">Editar</a></p>
                <p><a href="/delete-category/{{ $category->id }}">Borrar</a></p>
            </div>
            <hr/>
        @endforeach
    </div>
</section>
@endsection
@include('dashboard')