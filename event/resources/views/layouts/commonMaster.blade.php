@php
$cloc = '';
$token = getToken();
$today = date('Y-m-d');
// $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJiYW1zLWJibSIsInN1YiI6eyJ1c2VybmFtZSI6ImlsaGFtLnN1cmlhbnRvIiwic3RhdHVzIjoibG9naW4iLCJrb2RlX3BlZyI6IkstMTktMDAxMTEiLCJkaXZpc2kiOiIxIiwiY25tX2xlbmdrYXAiOiJJTEhBTSBTVVJJQU5UTyIsImNsb2MiOiJQUlQiLCJjamFiIjoiSVQiLCJja29kZV9qYWIiOiI5OSIsImNhYmFuZyI6IktJTUEifSwiaWF0IjoxNzE1NjUwNTg0LCJleHAiOjE3MjA4MzQ1ODR9.A64iJDLnvuaek2yFGuHUw8xvf_kfW2lswHYm8_kSZ30'
@endphp

<!DOCTYPE html>

<html lang="{{ session()->get('locale') ?? app()->getLocale() }}" class="{{ $configData['style'] }}-style {{ $navbarFixed ?? '' }} {{ $menuFixed ?? '' }} {{ $menuCollapsed ?? '' }} {{ $footerFixed ?? '' }} {{ $customizerHidden ?? '' }}" dir="{{ $configData['textDirection'] }}" data-theme="{{ (($configData['theme'] === 'theme-semi-dark') ? (($configData['layout'] !== 'horizontal') ? $configData['theme'] : 'theme-default') :  $configData['theme']) }}" data-assets-path="{{ asset('/assets') . '/' }}" data-base-url="{{url('/')}}" data-framework="laravel" data-template="{{ $configData['layout'] . '-menu-' . $configData['theme'] . '-' . $configData['style'] }}">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <title>@yield('title') |
    {{ config('variables.templateName') ? config('variables.templateName') : 'TemplateName' }}
    {{ config('variables.templateSuffix') ? config('variables.templateSuffix') : '' }}</title>
  <meta name="description" content="{{ config('variables.templateDescription') ? config('variables.templateDescription') : '' }}" />
  <meta name="keywords" content="{{ config('variables.templateKeyword') ? config('variables.templateKeyword') : '' }}">
  <!-- laravel CRUD token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Canonical SEO -->
  <link rel="canonical" href="{{ config('variables.productPage') ? config('variables.productPage') : '' }}">
  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/custom/favicon-marketing.png') }}" />

  {{-- global css --}}
  <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">

  <!-- Include Styles -->
  @include('layouts/sections/styles')

  <!-- Include Scripts for customizer, helper, analytics, config -->
  @include('layouts/sections/scriptsIncludes')

  {{-- alpine --}}
  <script defer src="https://unpkg.com/@colinaut/alpinejs-plugin-simple-validate@1/dist/alpine.validate.min.js"></script>
  {{-- <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script> --}}

  {{-- plugin alpine js --}}
  <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/mask@3.x.x/dist/cdn.min.js"></script>

  {{-- alpine js --}}
  <script defer src="{{asset('assets/js/alpine.js')}}"></script>
</head>

<body x-data="{
  // global function for alpine js
  globalCabang: `{{$cloc}}`,
  globalToken: `{{$token}}`,
  today: `{{$today}}`,
  getBaseUrlApi(url){
    return `http://bbm-bams.co.id:1122/${url}`
  },
  formatRupiah(angka) {
    if(angka){
      const angkaBulat = Math.floor(angka);
    const angkaFormat = angkaBulat.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    return `${angkaFormat}`;
    } else {
      return '0';
    }
  },
  removeThousandsSeparator(rupiah) {
    let number =  Number(rupiah?.replace(/\./g, ''));
    return number.toString()
  },
  async initialFetchApiOrLocal({name, url, body, loading}){
    const getData = localStorage.getItem(name); // Gunakan variabel 'name' tanpa tanda kutip
    const timestamp = localStorage.getItem(name + '_timestamp'); // Gunakan key unik untuk timestamp
    const now = new Date().getTime();
    // Cek apakah data sudah ada dan belum lewat 24 jam
    if (getData && timestamp && now - parseInt(timestamp) < 24 * 60 * 60 * 1000) {
      // Jika data masih valid gunakan data dari localstorage
      return JSON.parse(getData);
    } else {
      try {
        const response = await fetch(this.getBaseUrlApi(url), {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + this.globalToken,
          },
          body: JSON.stringify(body)
        });
        const data = await response.json();
        const result = data.result.data;
        // Set ke localstorage
        localStorage.setItem(name, JSON.stringify(result));
        localStorage.setItem(name + '_timestamp', now.toString()); // Simpan timestamp dengan key yang sama
        return result;
      } catch (err) {
        console.error(err); // Gunakan console.error untuk error logging
        throw err; // Throw error untuk bisa di-handle oleh caller function
      }
    }
  },
  compareOnKey(key, rule, keys){
    return function(a,b){
      if(keys.includes(key)){
        let comparison = 0
        const fieldA = a[key]?.toUpperCase()
        const fieldB = b[key]?.toUpperCase()
        if (rule === 'asc') {
            if (fieldA > fieldB) {
              comparison = 1;
            } else if (fieldA < fieldB) {
              comparison = -1;
            }
        } else {
          if (fieldA < fieldB) {
            comparison = 1;
          } else if (fieldA > fieldB) {
            comparison = -1;
          }
        }
        return comparison
      } else {
        if (rule === 'asc') {
          return a.year - b.year
        } else {
          return b.year - a.year
        }
      }
    }
  },

  async fetchApi({url, method, data}){
    try{
    const response = await fetch(this.getBaseUrlApi(url), {
      method : method,
      headers: {
        'Content-Type': 'application/json',
        'Authorization': 'Bearer ' + this.globalToken,
      },
      body: JSON.stringify(data)
    }).then(res => res.json()).then(data => {
    if(data.error){
      throw data;
    }
      return data
    })
    return response
    }catch(err){
      return {
        ...err,
        error : true
      }
    }
  },

  checkingResError(code){
    let text;
    if(code === 404){
      text = 'Maaf Lagi ada kendala, Silahkan Contact Tim IT'
    }

    Swal.fire({
      icon: 'error',
      title: text,
      text: code,
      // showConfirmButton: false,
      // timer: 3000,
    })
  },
}">
  <!-- Layout Content -->
  @yield('layoutContent')
  <!--/ Layout Content -->

  <!-- Include Scripts -->
  @include('layouts/sections/scripts')

</body>

</html>
