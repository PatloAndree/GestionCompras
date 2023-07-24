@php
$configData = Helper::applClasses();
@endphp
<div class="main-menu menu-fixed {{(($configData['theme'] === 'dark') || ($configData['theme'] === 'semi-dark')) ? 'menu-dark' : 'menu-light'}} menu-accordion menu-shadow" data-scroll-to-active="true">
  <div class="navbar-header">
    <ul class="nav navbar-nav flex-row">
      <li class="nav-item me-auto text-center" style="width: 80%">
        <a class="" href="{{url('/')}}">
          <span class="brand-logo">
            <img src="{{ asset('images/login/sella.png')}}" style="max-width:80px;max-height:120px;object-fit:contain">
          </span>
        </a>
      </li>
      <li class="nav-item nav-toggle">
        <a class="nav-link modern-nav-toggle pe-0" data-toggle="collapse">
          <i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i>
          <i class="d-none d-xl-block collapse-toggle-icon font-medium-4 text-primary" data-feather="disc" data-ticon="disc"></i>
        </a>
      </li>
    </ul>
  </div>
  <div class="shadow-bottom"></div>
  <div class="main-menu-content mt-3">
    <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
		@if (Auth::user()->type==1)
			<li class="nav-item  {{Route::currentRouteName() === 'home' ? 'active' : ''}}">
				<a href="{{ route('home') }}" class="d-flex align-items-center" target="_self">
					<i data-feather="home"></i>
					<span class="menu-title text-truncate">Inicio</span>
				</a>
			</li>
			<li class="nav-item  {{Route::currentRouteName() === 'productos.index' ? 'active' : ''}}">
				<a href="{{ route('productos.index') }}" class="d-flex align-items-center" target="_self">
					<i data-feather="package"></i>
					<span class="menu-title text-truncate">Productos</span>
				</a>
			</li>
			<li class="nav-item  {{Route::currentRouteName() === 'categorias.index' ? 'active' : ''}}">
				<a href="{{ route('categorias.index') }}" class="d-flex align-items-center" target="_self">
					<i data-feather="archive"></i>
					<span class="menu-title text-truncate">Categorias</span>
				</a>
			</li>
			<li class="nav-item  {{Route::currentRouteName() === 'puntoventa.index' ? 'active' : ''}}">
				<a href="{{ route('puntoventa.index') }}" class="d-flex align-items-center" target="_self">
					<i data-feather="credit-card"></i>
					<span class="menu-title text-truncate">Punto de venta</span>
				</a>
			</li>
			<li class="nav-item " >
				<a href="" class="d-flex align-items-center" target="_self">
					<i data-feather="credit-card"></i>
					<span class="menu-title text-truncate">Ventas</span>
				</a>
			</li>
			<li class="nav-item   {{Route::currentRouteName() === 'compras.index' ? 'active' : ''}}">
				<a href="{{ route('compras.index') }}" class="d-flex align-items-center" target="_self">
					<i data-feather="archive"></i>
					<span class="menu-title text-truncate">Compras</span>
				</a>
			</li>
			<li class="nav-item   {{Route::currentRouteName() === 'proveedores.index' ? 'active' : ''}}">
				<a href="{{ route('proveedores.index') }}" class="d-flex align-items-center" target="_self">
					<i data-feather="truck"></i>
					<span class="menu-title text-truncate">Proveedores</span>
				</a>
			</li>
			<li class="nav-item " >
				<a href="" class="d-flex align-items-center" target="_self">
					<i data-feather="bar-chart"></i>
					<span class="menu-title text-truncate">Reportes</span>
				</a>
			</li>

		
		@else
			<li class="nav-item  {{Route::currentRouteName() === 'cronograma.index' ? 'active' : ''}}">
				<a href="{{ route('cronograma.index') }}" class="d-flex align-items-center" target="_self">
					<i data-feather="calendar"></i>
					<span class="menu-title text-truncate">Cronograma</span>
				</a>
			</li>
			
			<li class="nav-item  {{Route::currentRouteName() === 'solicitudes.index' ? 'active' : ''}}">
				<a href="{{ route('solicitudes.index') }}" class="d-flex align-items-center" target="_self">
					<i data-feather="calendar"></i>
					<span class="menu-title text-truncate">Solicitudes</span>
				</a>
			</li>
		@endif
		<li class="nav-item  ">
       		<a href="{{ route('logout') }}" class="d-flex align-items-center" onclick="event.preventDefault(); document.getElementById('logout-form2').submit();">
				<i data-feather="power"></i>
				<span class="menu-title text-truncate">Salir</span>
            </a>
          <form method="POST" id="logout-form2" action="{{ route('logout') }}">
            @csrf
          </form>
        </li>
    </ul>
  </div>
</div>
<!-- END: Main Menu-->
