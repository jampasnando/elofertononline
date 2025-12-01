@php
    // dd($data);
@endphp
<div class="container my-5 data slide-up" style="padding: 2em;border-radious:20px;background:{{$data->parametros[0]['color']}}">
    <div class="row g-4"> <!-- g-4 da separación entre las dos columnas -->
        
        <!-- Primera columna -->
        <div class="col-md-6">
            <div class="p-4 h-100 bg-light border rounded-3 shadow-sm">
                <h6 class="mb-3">{{$data->parametros[0]['titulox']}}</h6>
                <div class="row g-3">
                      @foreach ($data->data as $index => $unprods2x)
                        @if($index<4)
                        <div class="col-6">
                          <div class="card product-card h-100">
                            <img src="{{$unprods2x->img1 ? asset('storage/'.$unprods2x->img1) : asset('imagenes/toolsplaceholder.png')}}" class="card-img-top" alt="Taladro" style="object-fit:cover;">
                            <div class="card-body d-flex flex-column p-2">
                                <h6 class="card-title mb-1">{{$unprods2x->marca}}</h6>
                                <p class="card-text text-truncate mb-2 small">{{$unprods2x->descripcion}}</p>
                                <div class="mt-auto d-flex justify-content-between align-items-center">
                                    <span class="fw-bold text-secondary small">Bs.{{$unprods2x->precioventa}}</span>
                                    <button class="btn btn-success btn-sm add-cart btn-add-to-cart" data-id="{{ $unprods2x->id }}" data-nombre="{{ $unprods2x->descripcion }}" data-precio="{{ $unprods2x->precioventa }}">Añadir</button>
                                </div>
                            </div>
                          </div>
                        </div>
                        @endif
                       @endforeach

                </div>
            </div>
        </div>

        <!-- Segunda columna -->
        <div class="col-md-6">
            <div class="p-4 h-100 bg-light border rounded-3 shadow-sm">
                <h6 class="mb-3">{{$data->parametros[0]['tituloy']}}</h6>
                <div class="row g-3">
                     @foreach ($data->data as $index => $unprods2y)
                        @if($index > 3)
                        <div class="col-6">
                          <div class="card product-card h-100">
                            <img src="{{$unprods2y->img1 ? asset('storage/'.$unprods2y->img1) : asset('imagenes/toolsplaceholder.png')}}" class="card-img-top" alt="Taladro" style="height:150px; object-fit:cover;">
                            <div class="card-body d-flex flex-column p-2">
                                <h6 class="card-title mb-1">{{$unprods2y->marca}}</h6>
                                <p class="card-text text-truncate mb-2 small">{{$unprods2y->descripcion}}</p>
                                <div class="mt-auto d-flex justify-content-between align-items-center">
                                    <span class="fw-bold text-secondary small">Bs.{{$unprods2y->precioventa}}</span>
                                    <button class="btn btn-success btn-sm add-cart btn-add-to-cart" data-id="{{ $unprods2y->id }}" data-nombre="{{ $unprods2y->descripcion }}" data-precio="{{ $unprods2y->precioventa }}">Añadir</button>
                                </div>
                            </div>
                          </div>
                        </div>
                        @endif
                       @endforeach
                </div>
            </div>
        </div>

    </div>
</div>