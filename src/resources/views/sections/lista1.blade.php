<div class="container mt-4 slide-up" id="lista{{$data->id}}">
    <h3>{{$data->parametros['titulo']}}</h3>
    <div class="row justify-content-left g-4">
        @foreach($data->data as $unproductolista)
            {{-- Producto 1 --}}
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                <div class="card product-card h-100 rounded">
                    <img 
                        src="{{$unproductolista->img1 ? asset('storage/'.$unproductolista->img1) : asset('imagenes/toolsplaceholder.png')}}"
                        class="card-img-top open-product-modal"
                        alt="unProductolista"
                        style="object-fit:cover; cursor:pointer;"
                        data-id="{{ $unproductolista->id }}"
                        data-marca="{{ $unproductolista->marca }}"
                        data-descripcion="{{ $unproductolista->descripcion }}"
                        data-precio="{{ $unproductolista->precioventa }}"
                        data-img="{{ $unproductolista->img1 ? asset('storage/'.$unproductolista->img1) : asset('imagenes/toolsplaceholder.png') }}"
                    >
                    <div class="card-body d-flex flex-column p-2">
                        <h6 class="card-title mb-1">{{$unproductolista->marca}}</h6>
                        <p class="card-text text-truncate mb-2 small">{{$unproductolista->descripcion}}</p>
                        <div class="mt-auto d-flex justify-content-between align-items-center">
                            <span class="fw-bold text-secondary small">Bs.{{$unproductolista->precioventa}}</span>
                            <button class="btn btn-success btn-sm add-cart btn-add-to-cart" data-id="{{ $unproductolista->id }}" data-nombre="{{ $unproductolista->descripcion }}" data-precio="{{ $unproductolista->precioventa }}" data-img="{{ $unproductolista->img1 ? asset('storage/'.$unproductolista->img1) : asset('imagenes/toolsplaceholder.png') }}">Añadir</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
         {{-- Paginación independiente usando el límite de la lista --}}
        <div class="mt-3">
            {{ $data->data->appends(request()->query())->fragment('lista'.$data->id)->links() }}
        </div>
        </div>
</div>
