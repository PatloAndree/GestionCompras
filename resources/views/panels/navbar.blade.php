@if ($configData['mainLayoutType'] === 'horizontal' && isset($configData['mainLayoutType']))
  <nav
    class="header-navbar navbar-expand-lg navbar navbar-fixed align-items-center navbar-shadow navbar-brand-center {{ $configData['navbarColor'] }}"
    data-nav="brand-center">
    <div class="navbar-header d-xl-block d-none">
      <ul class="nav navbar-nav">
        <li class="nav-item">
          <a class="navbar-brand" href="{{ url('/') }}">
            <span class="brand-logo">
              <img src="{{ asset('images/login/pm2.png')}}" style="max-width:50%;padding-bottom:5px">
            </span>
          </a>
        </li>
      </ul>
    </div>
  @else
    <nav
      class="header-navbar navbar navbar-expand-lg align-items-center {{ $configData['navbarClass'] }} navbar-light navbar-shadow {{ $configData['navbarColor'] }} {{ $configData['layoutWidth'] === 'boxed' && $configData['verticalMenuNavbarType'] === 'navbar-floating' ? 'container-xxl' : '' }}">
@endif
<div class="navbar-container d-flex content">
  <div class="bookmark-wrapper d-flex align-items-center">
    <ul class="nav navbar-nav d-xl-none">
      <li class="nav-item"><a class="nav-link menu-toggle" href="javascript:void(0);"><i class="ficon"
            data-feather="menu"></i></a></li>
    </ul>
  </div>
  <ul class="nav navbar-nav align-items-center ms-auto">
    <li class="nav-item dropdown dropdown-user">
      <a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user" href="javascript:void(0);"
        data-bs-toggle="dropdown" aria-haspopup="true">
        <div class="user-nav d-sm-flex d-none">
          <span class="user-name fw-bolder">
            @if (Auth::check())
              {{ Auth::user()->name }}
            @else
              John Doe
            @endif
          </span>
          <span class="user-status">
            @if (Auth::user()->type==1)
				Administrador
			@elseif(Auth::user()->type==2)
				Enfermero
			@elseif(Auth::user()->type==3)
				Doctor
			@elseif(Auth::user()->type==4)
				Conductor
			@endif
          </span>
        </div>
        <span class="avatar">
          <img class="round"
            src="{{ asset('images/portrait/small/avatar-s-11.jpg') }}"
            alt="avatar" height="40" width="40">
          <span class="avatar-status-online"></span>
        </span>
      </a>
      <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-user">
        <h6 class="dropdown-header d-none">Administrar perfil</h6>
        <div class="dropdown-divider d-none"></div>
        <a class="dropdown-item  d-none"
          href="{{ Route::has('profile.show') ? route('profile.show') : 'javascript:void(0)' }}">
          <i class="me-50" data-feather="user"></i> Profile
        </a>
        <a class="dropdown-item d-none" href="#">
          <i class="me-50" data-feather="settings"></i> Settings
        </a>
        @if (Auth::check())
          <a class="dropdown-item" href="{{ route('logout') }}"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="me-50" data-feather="power"></i> Salir
          </a>
          <form method="POST" id="logout-form" action="{{ route('logout') }}">
            @csrf
          </form>
        @else
          <a class="dropdown-item" href="{{ Route::has('login') ? route('login') : 'javascript:void(0)' }}">
            <i class="me-50" data-feather="log-in"></i> Login
          </a>
        @endif
      </div>
    </li>
  </ul>
</div>
</nav>

{{-- Search Start Here --}}
<ul class="main-search-list-defaultlist d-none">
  <li class="d-flex align-items-center">
    <a href="javascript:void(0);">
      <h6 class="section-label mt-75 mb-0">Files</h6>
    </a>
  </li>
  <li class="auto-suggestion">
    <a class="d-flex align-items-center justify-content-between w-100" href="{{ url('app/file-manager') }}">
      <div class="d-flex">
        <div class="me-75">
          <img src="{{ asset('images/icons/xls.png') }}" alt="png" height="32">
        </div>
        <div class="search-data">
          <p class="search-data-title mb-0">Two new item submitted</p>
          <small class="text-muted">Marketing Manager</small>
        </div>
      </div>
      <small class="search-data-size me-50 text-muted">&apos;17kb</small>
    </a>
  </li>
  <li class="auto-suggestion">
    <a class="d-flex align-items-center justify-content-between w-100" href="{{ url('app/file-manager') }}">
      <div class="d-flex">
        <div class="me-75">
          <img src="{{ asset('images/icons/jpg.png') }}" alt="png" height="32">
        </div>
        <div class="search-data">
          <p class="search-data-title mb-0">52 JPG file Generated</p>
          <small class="text-muted">FontEnd Developer</small>
        </div>
      </div>
      <small class="search-data-size me-50 text-muted">&apos;11kb</small>
    </a>
  </li>
  <li class="auto-suggestion">
    <a class="d-flex align-items-center justify-content-between w-100" href="{{ url('app/file-manager') }}">
      <div class="d-flex">
        <div class="me-75">
          <img src="{{ asset('images/icons/pdf.png') }}" alt="png" height="32">
        </div>
        <div class="search-data">
          <p class="search-data-title mb-0">25 PDF File Uploaded</p>
          <small class="text-muted">Digital Marketing Manager</small>
        </div>
      </div>
      <small class="search-data-size me-50 text-muted">&apos;150kb</small>
    </a>
  </li>
  <li class="auto-suggestion">
    <a class="d-flex align-items-center justify-content-between w-100" href="{{ url('app/file-manager') }}">
      <div class="d-flex">
        <div class="me-75">
          <img src="{{ asset('images/icons/doc.png') }}" alt="png" height="32">
        </div>
        <div class="search-data">
          <p class="search-data-title mb-0">Anna_Strong.doc</p>
          <small class="text-muted">Web Designer</small>
        </div>
      </div>
      <small class="search-data-size me-50 text-muted">&apos;256kb</small>
    </a>
  </li>
  <li class="d-flex align-items-center">
    <a href="javascript:void(0);">
      <h6 class="section-label mt-75 mb-0">Members</h6>
    </a>
  </li>
  <li class="auto-suggestion">
    <a class="d-flex align-items-center justify-content-between py-50 w-100" href="{{ url('app/user/view') }}">
      <div class="d-flex align-items-center">
        <div class="avatar me-75">
          <img src="{{ asset('images/portrait/small/avatar-s-8.jpg') }}" alt="png" height="32">
        </div>
        <div class="search-data">
          <p class="search-data-title mb-0">John Doe</p>
          <small class="text-muted">UI designer</small>
        </div>
      </div>
    </a>
  </li>
  <li class="auto-suggestion">
    <a class="d-flex align-items-center justify-content-between py-50 w-100" href="{{ url('app/user/view') }}">
      <div class="d-flex align-items-center">
        <div class="avatar me-75">
          <img src="{{ asset('images/portrait/small/avatar-s-1.jpg') }}" alt="png" height="32">
        </div>
        <div class="search-data">
          <p class="search-data-title mb-0">Michal Clark</p>
          <small class="text-muted">FontEnd Developer</small>
        </div>
      </div>
    </a>
  </li>
  <li class="auto-suggestion">
    <a class="d-flex align-items-center justify-content-between py-50 w-100" href="{{ url('app/user/view') }}">
      <div class="d-flex align-items-center">
        <div class="avatar me-75">
          <img src="{{ asset('images/portrait/small/avatar-s-14.jpg') }}" alt="png" height="32">
        </div>
        <div class="search-data">
          <p class="search-data-title mb-0">Milena Gibson</p>
          <small class="text-muted">Digital Marketing Manager</small>
        </div>
      </div>
    </a>
  </li>
  <li class="auto-suggestion">
    <a class="d-flex align-items-center justify-content-between py-50 w-100" href="{{ url('app/user/view') }}">
      <div class="d-flex align-items-center">
        <div class="avatar me-75">
          <img src="{{ asset('images/portrait/small/avatar-s-6.jpg') }}" alt="png" height="32">
        </div>
        <div class="search-data">
          <p class="search-data-title mb-0">Anna Strong</p>
          <small class="text-muted">Web Designer</small>
        </div>
      </div>
    </a>
  </li>
</ul>

{{-- if main search not found! --}}
<ul class="main-search-list-defaultlist-other-list d-none">
  <li class="auto-suggestion justify-content-between">
    <a class="d-flex align-items-center justify-content-between w-100 py-50">
      <div class="d-flex justify-content-start">
        <span class="me-75" data-feather="alert-circle"></span>
        <span>No results found.</span>
      </div>
    </a>
  </li>
</ul>
{{-- Search Ends --}}
<!-- END: Header-->
