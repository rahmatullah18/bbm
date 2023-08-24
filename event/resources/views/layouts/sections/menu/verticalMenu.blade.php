@php
$configData = Helper::appClasses();
$menu_arr = Helper::get_menu_access(session()->get('username'));
$menu_active = session('menu_active', '');
@endphp


@if (session()->get('menu_active') === 'marketing')
@php
$menuData = $menuData[0]
@endphp
@elseif(session()->get('menu_active') === 'finance')
@php
$menuData = $menuData[1]
@endphp
@else
@php
$menuData = $menuData[2]
@endphp
@endif

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

  <!-- ! Hide app brand if navbar-full -->
  @if(!isset($navbarFull))
  <div class="app-brand demo">
    <a href="{{url('/')}}" class="app-brand-link">
      <span class="app-brand-logo demo">
        <!-- @include('_partials.macros') -->
        <img src="{{asset('assets/img/custom/bams3d1.png')}}" alt style="width:21px">
      </span>
      <span class="app-brand-text demo menu-text fw-bold ms-2">{{config('variables.templateName')}}</span>
    </a>

    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
      <i class="bx menu-toggle-icon d-none d-xl-block fs-4 align-middle"></i>
      <i class="bx bx-x d-block d-xl-none bx-sm align-middle"></i>
    </a>
  </div>
  @endif

  <!-- ! Hide menu divider if navbar-full -->
  @if(!isset($navbarFull))
  <div class="menu-divider mt-0 ">
  </div>
  @endif

  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1">
    @foreach ($menuData->menu as $menu)

    {{-- adding active and open class if child is active --}}

    {{-- menu headers --}}
    @if (isset($menu->menuHeader))
    @php
    if(in_array($menu->slug, $menu_arr)){
    @endphp
    <li class="menu-header small text-uppercase">
      <span class="menu-header-text">{{ $menu->menuHeader }}</span>
    </li>
    @php
    }
    @endphp
    @else

    {{-- active menu method --}}
    @php
    $activeClass = null;
    $currentRouteName = Route::currentRouteName();

    if ($currentRouteName === $menu->slug) {
    $activeClass = 'active';
    }
    elseif (isset($menu->submenu)) {
    if (gettype($menu->slug) === 'array') {
    foreach($menu->slug as $slug){
    if (str_contains($currentRouteName,$slug) and strpos($currentRouteName,$slug) === 0) {
    $activeClass = 'active open';
    }
    }
    }
    else{
    if (str_contains($currentRouteName,$menu->slug) and strpos($currentRouteName,$menu->slug) === 0) {
    $activeClass = 'active open';
    }
    }

    }
    @endphp

    {{-- main menu --}}

    @php
	if($menu_active == 'marketing'){
		if(in_array($menu->slug, $menu_arr) || $menu->slug == 'pages-home'){
			@endphp
			<li class="menu-item {{$activeClass}}">
			  <a href="{{ isset($menu->url) ? url($menu->url) : 'javascript:void(0);' }}"
				class="{{ isset($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}" @if (isset($menu->target) and
				!empty($menu->target)) target="_blank" @endif>
				@isset($menu->icon)
				<i class="{{ $menu->icon }}"></i>
				@endisset
				<div>{{ isset($menu->name) ? __($menu->name) : '' }}</div>
			  </a>

			  {{-- submenu --}}
			  @isset($menu->submenu)
			  @include('layouts.sections.menu.submenu',['menu' => $menu->submenu])
			  @endisset
			</li>
			@php
		}
	}else{
		@endphp
		<li class="menu-item {{$activeClass}}">
		  <a href="{{ isset($menu->url) ? url($menu->url) : 'javascript:void(0);' }}"
			class="{{ isset($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}" @if (isset($menu->target) and
			!empty($menu->target)) target="_blank" @endif>
			@isset($menu->icon)
			<i class="{{ $menu->icon }}"></i>
			@endisset
			<div>{{ isset($menu->name) ? __($menu->name) : '' }}</div>
		  </a>

		  {{-- submenu --}}
		  @isset($menu->submenu)
		  @include('layouts.sections.menu.submenu',['menu' => $menu->submenu])
		  @endisset
		</li>
		@php
	}
    @endphp
    @endif
    @endforeach
  </ul>

</aside>