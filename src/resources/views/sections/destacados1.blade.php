<div class="container my-3 slide-up">
    <h3 class="w-100 text-center py-3">{{$data->parametros['titulo']}}</h3>
    <div class="row g-4 align-items-start">

        {{-- Izquierda: imagen 3:4 --}}
        <div class="col-12 col-lg-4">
            <div class="featured-img-wrapper"><img src="{{asset('storage/'.$data->parametros['imagen_destacada'])}}" alt="Destacado" class="img-fluid rounded featured-img" style="aspect-ratio: 3/4; width: 100%;"></div>
        </div>

        {{-- Derecha: grid de productos --}}
        <div class="col-12 col-lg-8">
            <div class="row row-cols-1 row-cols-md-3 g-4">
                @foreach($data->data as $producto)
                {{-- Producto 1 --}}
                    <div class="col">
                        <div class="card product-card h-100 rounded">
                            <img src="{{$producto->img1 ? asset('storage/'.$producto->img1) : asset('imagenes/toolsplaceholder.png')}}" class="card-img-top" alt="Producto 1" style="object-fit:cover;">
                            <div class="card-body d-flex flex-column p-2">
                                <h6 class="card-title mb-1">{{$producto->marca}}</h6>
                                <p class="card-text text-truncate mb-2 small">{{$producto->descripcion}}</p>
                                <div class="mt-auto d-flex justify-content-between align-items-center">
                                    <span class="fw-bold text-secondary small">Bs.{{$producto->precioventa}}</span>
                                    <button class="btn btn-success btn-sm add-cart btn-add-to-cart" data-id="{{ $producto->id }}" data-nombre="{{ $producto->descripcion }}" data-precio="{{ $producto->precioventa }}">Añadir</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div> {{-- row derecha --}}
        </div> {{-- col derecha --}}

    </div>
</div>