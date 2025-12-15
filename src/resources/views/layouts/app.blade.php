
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>@yield('title', 'Mi Proyecto Laravel')</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Kanit:wght@300;400;600&display=swap" rel="stylesheet">

  <style>
    .icon-btn {
      background: none;
      border: none;
      font-size: 1.25rem;
      margin-left: 10px;
    }
    .geo-btn {
    color: red;                     /* color del icono */
    font-size: 1.5rem;              /* tamaño del icono */
    padding: 8px;                   /* espacio dentro del círculo */
    border-radius: 50%;             /* círculo */
    transition: all 0.3s ease;      /* transición suave */
    cursor: pointer;                /* puntero al pasar el mouse */
}

/* Hover */
.geo-btn:hover {
    background-color: rgba(255,0,0,0.1); /* fondo circular rojo suave */
    box-shadow: 0 4px 8px rgba(0,0,0,0.2); /* sombra sutil */
    transform: scale(1.2);                  /* pequeño zoom */
}
.banner-img {
    height: auto;        altura deseada tipo banner
    object-fit: cover;    /* mantiene la proporción y corta lo que sobra */
}
.product-card {
    border: 1px solid #eee;
    border-radius: 10px;
    transition: transform 0.3s, box-shadow 0.3s;
    overflow: hidden;
    cursor: pointer;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
}

.product-card .add-cart {
    opacity: 0;
    transition: opacity 0.3s;
}

.product-card:hover .add-cart {
    opacity: 1;
}

/* Texto más compacto y atractivo */
.card-title {
    font-size: 0.9rem;
}
.card-text {
    font-size: 0.75rem;
    color: #555;
}
.featured-img-wrapper {
    overflow: hidden;              /* evita que se vea fuera del borde */
    border-radius: 12px;           /* bordes redondeados */
    aspect-ratio: 3/4;             /* relación de aspecto 3:4 */
    width: 100%;

}

.featured-img {
    width: 100%;
    height: 100%;
    object-fit: cover;             /* recorta sin deformar */
    transition: transform 0.4s ease, box-shadow 0.4s ease;
    border-radius: 12px;
}

.featured-img-wrapper:hover .featured-img {
    transform: scale(1.08);        /* pequeño zoom */
    box-shadow: 0 10px 20px rgba(0,0,0,0.25); /* sombra elegante */
}
.destacado2s{
      background: whitesmoke;
    padding: 2em;
    border-radius: 25px;
}
/* @keyframes slide-up {
  0% {
    transform: translateY(50px);
    opacity: 0;
  }
  100% {
    transform: translateY(0);
    opacity: 1;
  }
}

.animate-slide-up {
  animation: slide-up 0.8s ease-out forwards;
} */
@keyframes slide-up {
  0% {
    transform: translateY(50px);
    opacity: 0;
  }
  100% {
    transform: translateY(0);
    opacity: 1;
  }
}

.slide-up {
  opacity: 0;
  transform: translateY(50px);
  transition: all 0.8s ease-out;
}

.slide-up.show {
  animation: slide-up 0.8s ease-out forwards;
}


.logo-slider {
  overflow: hidden;
  position: relative;
  /* width: 100%; */
  background: #fff;
  padding: 20px 0;
}

.logo-track {
  display: flex;
  width: calc(250px * 12); /* ancho = logo ancho * cantidad */
  animation: scroll 30s linear infinite;
}

.logo-track img {
  /* width: 250px; */
  height: 6em;
  margin: 0 20px;
  /* filter: grayscale(100%); */
  /* transition: filter 0.3s ease; */
}

.logo-track img:hover {
  filter: grayscale(0%);
}

@keyframes scroll {
  from {
    transform: translateX(0);
  }
  to {
    transform: translateX(-50%);
  }
}
.whatsapp-btn {
    position: fixed;
    right: 0;
    top: 50%;
    transform: translateY(-50%);
    z-index: 9999;
    background: white;
    padding: 8px;
    border-radius: 50%;
    box-shadow: 0 2px 8px rgba(0,0,0,0.3);
}

.whatsapp-btn img {
    width: 45px;
    height: 45px;
    object-fit: contain;
}

/* Ajustes en pantallas pequeñas (evitar tap targets fuera de pantalla) */
@media (max-width: 420px) {
  .whatsapp-float {
    width: 48px;
    height: 48px;
    margin-right: 6px;
    border-radius: 24px 0 0 24px;
  }
  .whatsapp-float svg { width: 24px; height: 24px; }
}
.social-icon {
    width: 24px;
    height: 24px;
    object-fit: contain;
    display: block;
}
.icon-btn svg {
    width: 24px;
    height: 24px;
    display: block;
    stroke: #6c757d;   /* gris */
    stroke-width: 2;
    fill: transparent; /* borde solamente */
    transition: 0.25s ease;
}

.icon-btn:hover svg {
    fill: #6c757d !important; /* se rellena en hover */
    stroke: none;
}

  </style>
</head>
{{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}

<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">

    <!-- Botón hamburguesa (solo visible en móvil) -->
    <button class="navbar-toggler order-1" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContenido">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Izquierda: Logo + Menú (colapsable) -->
    <div class="collapse navbar-collapse order-lg-1 order-2" id="navbarContenido">
      <a class="navbar-brand d-lg-block d-none me-3" href="{{ route('market.index') }}">
        <img src="{{asset('imagenes/logo.png')}}" alt="Logo" class="d-inline-block align-text-top" style="height: 2em;">
      </a>
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="#" style="font-weight: bold;font-size: 0.8em;" data-bs-toggle="modal" data-bs-target="#mapModal">
            <i class="bi bi-geo-alt-fill text-danger geo-btn"></i>
            Estás en Cochabamba
          </a>
        </li>
        <!-- <li class="nav-item">
          <a class="nav-link" href="#">Productos</a>
        </li> -->
      </ul>
    </div>

    <!-- Centro: Buscador (siempre visible) -->
    <form class="d-flex flex-grow-1 justify-content-center order-3 order-lg-2 mx-2" action="{{route('market.buscar')}}" method="GET">
        @csrf  
    <input class="form-control w-100 w-lg-75" type="search" placeholder="Buscar..." aria-label="Buscar" style="border-radius: 20px;" required name="buscar" value="{{ request('buscar') }}">
    <button class="icon-btn" aria-label="Perfil" type="submit">
            <i class="bi bi-search"></i>
        </button>
    </form>
    
    <!-- Derecha: Íconos (colapsable) -->
    <div class="collapse navbar-collapse justify-content-end order-lg-3 order-4" id="navbarContenido">
      <div class="d-flex align-items-center ms-auto mt-2 mt-lg-0">
        <!-- Facebook -->
        <a href="{{$configapp->facebook ?? '#'}}"
          target="_blank"
          class="icon-btn"
          aria-label="Facebook">
            <svg xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24">
                <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/>
            </svg>
        </a>

        <!-- TikTok -->
        <a href="{{$configapp->tiktok ?? '#'}}"
          target="_blank"
          class="icon-btn"
          aria-label="TikTok">
            <svg xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24">
                <path d="M20 7.5c-2 0-3.8-1.2-4.6-3h-2.4v11.2a4 4 0 1 1-3-3.9V9.9a6.4 6.4 0 1 0 7 6.3V9.1c1.1.8 2.4 1.2 3.8 1.2V7.5z"
                      stroke="Gray"
                      stroke-width="1.8"
                      fill="Gray"
                      stroke-linecap="round"
                      stroke-linejoin="round"/>
            </svg>
        </a>

        <button class="icon-btn" aria-label="Likes">
            <i class="bi bi-house"></i>
        </button>
        <button class="icon-btn position-relative" aria-label="Carrito" data-bs-toggle="modal" data-bs-target="#modalCarrito">
            <i class="bi bi-cart"></i>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger cartCount">
              0
            </span>
        </button>
        <button class="icon-btn" aria-label="Perfil">
            <i class="bi bi-person-circle"></i>
        </button>
        
      </div>
    </div>

  </div>
</nav>
    <div class="bg-light border-bottom py-1">
        <div class="container d-flex justify-content-between align-items-center">
            <!-- Select de categorías -->
            <div class="dropdown">
                <button class="btn btn-sm btn-warning dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="border-radius: 15px;padding: 5px 20px;">
                    <i class="bi bi-list"></i>
                    Categorías
                </button>
                <ul class="dropdown-menu shadow-sm">
                    <li><a class="dropdown-item" href="#">Herramientas</a></li>
                    <li><a class="dropdown-item" href="#">Jardinería</a></li>
                    <li><a class="dropdown-item" href="#">Cerrajería</a></li>
                    <li><a class="dropdown-item" href="#">Carpintería</a></li>
                    <li><a class="dropdown-item" href="#">Otros</a></li>
                </ul>
            </div>

            <!-- Opciones de texto -->
            <div class="d-none d-lg-flex gap-5">
            <a href="#" class="text-decoration-none text-dark small">Hogar</a>
            <a href="#" class="text-decoration-none text-dark small">Jardinería</a>
            <a href="#" class="text-decoration-none text-dark small">Herramientas</a>
            <a href="#" class="text-decoration-none text-dark small">Cerrajería</a>
            <a href="#" class="text-decoration-none text-dark small">Carpintería</a>
            <a href="#" class="text-decoration-none text-dark small">Otros</a>
            </div>
            <div class="d-block d-lg-none">
              <button class="icon-btn position-relative" aria-label="Carrito" data-bs-toggle="modal" data-bs-target="#modalCarrito">
                  <i class="bi bi-cart"></i>
                  <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger cartCount">
                    0
                  </span>
              </button>
            </div>

        </div>
    </div>
  <main class="container-fluid px-0 py-2">
    @yield('content')
  </main>
@php
    // Número sin símbolos: cambiar si tu país no es Bolivia (591)
    $whatsappPhone = '59162611118';
    $whatsappMessage = 'más información por favor...';
    $waTextEncoded = urlencode($whatsappMessage);
    // Enlace recomendado: wa.me para móviles y web
    $waLink = "https://wa.me/{$whatsappPhone}?text={$waTextEncoded}";
@endphp

<a 
    href="https://wa.me/59179760327?text=Más%20información%20por%20favor..."
    target="_blank"
    class="whatsapp-btn"
>
    <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg"
         alt="WhatsApp" />
</a>

 <footer class="bg-secondary bg-gradient text-center py-3 text-white mt-4">
        {{-- <small>&copy; {{ date('Y') }} - El Ofertón</small> --}}
<div class="row">
      <div class="col-6 col-md-2 mb-3">
        <h6>
          Dirección
        </h6>
        <ul class="nav flex-column">
          <li class="nav-item mb-2">
            Av. Beijing casi Dorgbigni<br>
            # 1234 acera este
          </li>
          <li class="nav-item mb-2">
              Teléfonos
          </li>
          <li class="nav-item mb-2">
              7774444<br>
              4294444<br>
              6565656
          </li>
        </ul>
      </div>
      <div class="col-6 col-md-2 mb-3">
        <h5>
          Section
        </h5>
        <ul class="nav flex-column">
          <li class="nav-item mb-2">
            <a href="#" class="nav-link p-0 text-body-secondary">
              Home
            </a>
          </li>
          <li class="nav-item mb-2">
            <a href="#" class="nav-link p-0 text-body-secondary">
              Features
            </a>
          </li>
          <li class="nav-item mb-2">
            <a href="#" class="nav-link p-0 text-body-secondary">
              Pricing
            </a>
          </li>
          <li class="nav-item mb-2">
            <a href="#" class="nav-link p-0 text-body-secondary">
              FAQs
            </a>
          </li>
          <li class="nav-item mb-2">
            <a href="#" class="nav-link p-0 text-body-secondary">
              About
            </a>
          </li>
        </ul>
      </div>
      <div class="col-6 col-md-2 mb-3">
        <h5>
          Section
        </h5>
        <ul class="nav flex-column">
          <li class="nav-item mb-2">
            <a href="#" class="nav-link p-0 text-body-secondary">
              Home
            </a>
          </li>
          <li class="nav-item mb-2">
            <a href="#" class="nav-link p-0 text-body-secondary">
              Features
            </a>
          </li>
          <li class="nav-item mb-2">
            <a href="#" class="nav-link p-0 text-body-secondary">
              Pricing
            </a>
          </li>
          <li class="nav-item mb-2">
            <a href="#" class="nav-link p-0 text-body-secondary">
              FAQs
            </a>
          </li>
          <li class="nav-item mb-2">
            <a href="#" class="nav-link p-0 text-body-secondary">
              About
            </a>
          </li>
        </ul>
      </div>
      <div class="col-md-5 offset-md-1 mb-3">
        <form>
          <h5>
            Suscríbete a nuestro grupo de whatsapp
          </h5>
          <p>
            Ofertas semanales, mensuales y de temporada
          </p>
          <div class="d-flex flex-column flex-sm-row w-100 gap-2">
            <label for="newsletter1" class="visually-hidden">
              7775555
            </label>
            <input id="newsletter1" type="text" class="form-control" placeholder="7775555">
            <button class="btn btn-primary" type="button">
              Únirme
            </button>
          </div>
        </form>
      </div>
    </div>
    <div class="d-flex flex-column  justify-content-between py-4 my-4 border-top">
      <p style="text-align:center;">
        © 2025 El Ofertón Online.
      </p>
      <ul class="list-unstyled d-flex">
        <li class="ms-3">
          <a class="link-body-emphasis" href="#" aria-label="Instagram">
            <svg class="bi" width="24" height="24">
              <use xlink:href="#instagram">
              </use>
            </svg>
          </a>
        </li>
        <li class="ms-3">
          <a class="link-body-emphasis" href="#" aria-label="Facebook">
            <svg class="bi" width="24" height="24" aria-hidden="true">
              <use xlink:href="#facebook">
              </use>
            </svg>
          </a>
        </li>
      </ul>
    </div>

<!-- Modal con mapa -->
<div class="modal fade" id="mapModal" tabindex="-1" aria-labelledby="mapModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-dark" id="mapModalLabel">Ubicación en Cochabamba</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body p-0">
        <div id="map" style="height: 500px; width: 100%;"></div>
      </div>
    </div>
  </div>
</div>

<!-- popup aÑadir al carrito -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999">
    <div id="toastCarrito" class="toast align-items-center text-bg-success border-0" role="alert">
        <div class="d-flex">
            <div class="toast-body">
                Producto añadido al carrito 🛒
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
</div>

<!-- modal para ver el carrito -->
<div class="modal fade" id="modalCarrito" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-dark">🛒 Carrito de Compras</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="carritoDetalles">
        <p>Tu carrito está vacío.</p>
      </div>
      <div class="modal-footer">
        <button class="btn btn-outline-danger" data-bs-dismiss="modal">Cerrar</button>
        <button class="btn btn-success">Finalizar Compra</button>
      </div>
    </div>
  </div>
</div>

</footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <!-- Leaflet JS -->
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    const elementos = document.querySelectorAll('.slide-up');

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('show');
                observer.unobserve(entry.target); // opcional, solo animar 1 vez
            }
        });
    }, { threshold: 0.1 });

    elementos.forEach(el => observer.observe(el));

    // Cuando el modal del mapa se abre, inicializamos el mapa
    var map;
    var modal = document.getElementById('mapModal');
    modal.addEventListener('shown.bs.modal', function () {
      if (!map) {
        // Coordenadas de Cochabamba, Bolivia
        var cochabambaCoords = [-17.3895, -66.1568];

        map = L.map('map').setView(cochabambaCoords, 13);

        // Capa de mapa (OpenStreetMap)
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
          attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // Icono centrado en Cochabamba
        L.marker(cochabambaCoords).addTo(map)
          .bindPopup("📍 El Ofertón")
          .openPopup();
      }
    });

      let carrito = JSON.parse(localStorage.getItem('carrito')) || [];

  function actualizarContador() {
    const elements = document.querySelectorAll('.cartCount');
    elements.forEach(el => el.innerText = carrito.length);
    // const el = document.getElementById('cartCount');
    // if (el) el.innerText = carrito.length;
  }

  function guardarYActualizar() {
    localStorage.setItem('carrito', JSON.stringify(carrito));
    actualizarContador();
  }

  function renderizarCarrito() {
    const cont = document.getElementById('carritoDetalles');
    if (!cont) return;

    if (carrito.length === 0) {
      cont.innerHTML = '<p>Tu carrito está vacío.</p>';
      return;
    }

    let total = 0;
    let html = '<ul class="list-group">';
    carrito.forEach((p, i) => {
      const subtotal = p.precio * p.cantidad;
      total += subtotal;
      html += `
        <li class="list-group-item d-flex justify-content-between align-items-center">
          <button class="btn btn-sm btn-light btn-remove" data-index="${i}">❌</button>
          <div class="flex-grow-1 mx-2 text-truncate">
            <span >${p.nombre}</span><br>
            <small style="font-size:0.8em;color:gray;width:150px;display:flex;justify-content:space-between;align-items:center;">
              <button class="btn btn-sm btn-outline-secondary btn-restar" data-index="${i}">-</button>
              <span style="font-size:1.3em;font-wieght:bold;"> ${p.cantidad} </span>
              <button class="btn btn-sm btn-outline-secondary btn-sumar" data-index="${i}">+</button>
              x Bs.${p.precio}
            </small>
            
          </div>
          <div>
            <strong>Bs.${subtotal}</strong>
            
          </div>
        </li>`;
    });
    html += `</ul>
      <div class="mt-3 text-end fw-bold">
        <ul class="list-group">
          <li class="list-group-item d-flex justify-content-between align-items-center" style="color:green;">
            <span>Total a pagar:</span>
            <span>Bs.${total}</span>
          </li>
        </ul>
      </div>`;

    cont.innerHTML = html;

    // listeners dinámicos
    cont.querySelectorAll('.btn-remove').forEach(btn => {
      btn.addEventListener('click', () => {
        const idx = btn.dataset.index;
        carrito.splice(idx, 1);
        guardarYActualizar();
        renderizarCarrito();
      });
    });

    cont.querySelectorAll('.btn-sumar').forEach(btn => {
      btn.addEventListener('click', () => {
        const idx = btn.dataset.index;
        carrito[idx].cantidad++;
        guardarYActualizar();
        renderizarCarrito();
      });
    });

    cont.querySelectorAll('.btn-restar').forEach(btn => {
      btn.addEventListener('click', () => {
        const idx = btn.dataset.index;
        if (carrito[idx].cantidad > 1) {
          carrito[idx].cantidad--;
        } else {
          carrito.splice(idx, 1);
        }
        guardarYActualizar();
        renderizarCarrito();
      });
    });
  }

  // añadir al carrito
  document.querySelectorAll('.btn-add-to-cart').forEach(btn => {
    btn.addEventListener('click', () => {
      const id = btn.dataset.id;
      const nombre = btn.dataset.nombre;
      const precio = parseFloat(btn.dataset.precio);

      // Buscar si ya está en carrito
      const index = carrito.findIndex(p => p.id === id);
      if (index >= 0) {
        carrito[index].cantidad += 1;
      } else {
        carrito.push({ id, nombre, precio, cantidad: 1 });
      }

      guardarYActualizar();

      const toast = new bootstrap.Toast(document.getElementById('toastCarrito'));
      toast.show();
    });
  });

  // show modal -> renderizar
  const modalCarrito = document.getElementById('modalCarrito');
  if (modalCarrito) modalCarrito.addEventListener('show.bs.modal', renderizarCarrito);

  // init
  actualizarContador();

});




</script>

</body>
</html>
