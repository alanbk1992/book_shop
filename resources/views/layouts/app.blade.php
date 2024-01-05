<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<meta name="generator" content="Hugo 0.87.0">
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1">
<meta name="description" content="Kimora Net">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{ config('app.name', 'Kimora') }}</title>

@if (Auth::User())

<link rel="stylesheet" href="/assets/css/nifty.min.4d1ebee0c2ac4ed3c2df72b5178fb60181cfff43375388fee0f4af67ecf44050.css">
<link rel="stylesheet" href="/assets/css/bootstrap.min.75a07e3a3100a6fed983b15ad1b297c127a8c2335854b0efc3363731475cbed6.css">

@endif

@if (!Auth::User())

<link rel="stylesheet" href="/assets/css/login.css">

@endif
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">

<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700" rel="stylesheet" type="text/css">

<link rel="stylesheet" href=
"https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
<style>.osSwitch{position:relative;display:inline-block;width:34px;height:15.3px}.osSwitch input{opacity:0;width:0;height:0}.osSlider{position:absolute;top:0;left:0;right:0;bottom:0;border-radius:34px;background-color:#93a0b5;transition:0.4s}.osSlider:before{position:absolute;content:'';height:13px;width:13px;left:2px;bottom:1px;border-radius:50%;background-color:white;transition:0.4s}input:checked+.sliderGreen{background-color:#04d289}input:checked+.sliderRed{background-color:#ff3b30}input:not(:checked)+.defaultGreen{background-color:#04d289}input:checked+.osSlider:before{transform:translateX(17px)}
</style><style>
    @font-face {
      font-family: 'SegoeUI_online_security'; 
      src: url(chrome-extension://llbcnfanfmjhpedaedhbcnpgeepdnnok/segoe-ui.woff);
    }

    @font-face {
      font-family: 'SegoeUI_bold_online_security'; 
      src: url(chrome-extension://llbcnfanfmjhpedaedhbcnpgeepdnnok/segoe-ui-bold.woff);
    }
</style>


</head>
<body class="jumping">
<div id="root" class="root mn--max hd--expanded">

@if (Auth::User())

<header class="header">
<div class="header__inner">

<div class="header__brand">
  
<div class="brand-wrap">

<a href="/" class="brand-img stretched-link">
<img src="/assets/img/logo_transfaran.png" alt="Kimoranet" class="Kimoranet logo" width="100" height="35">
</a>


</div>
</div>

<div class="header__content">

<div class="header__content-start">

<button type="button" class="nav-toggler header__btn btn btn-icon btn-sm" aria-label="Nav Toggler" fdprocessedid="a4xk4m">
<i class="bi bi-view-stacked"></i>
</button>


</div>


<div class="header__content-end">


<div class="dropdown">

<button class="header__btn btn btn-icon btn-sm" type="button" data-bs-toggle="dropdown" aria-label="Notification dropdown" aria-expanded="false" fdprocessedid="zgh6ke">
<span class="d-block position-relative">
<i class="bi bi-bell-fill fs-5 me-2"></i>
<span class="badge badge-super rounded bg-danger p-1">
<span class="visually-hidden">unread messages</span>
</span>
</span>
</button>

<div class="dropdown-menu dropdown-menu-end w-md-300px">
<div class="border-bottom px-3 py-2 mb-3">
<h5>Notifications</h5>
</div>
<div class="list-group list-group-borderless">

<div class="list-group-item list-group-item-action d-flex align-items-start mb-3">
<div class="flex-shrink-0 me-3">
<i class="demo-psi-data-settings text-muted fs-2"></i>
</div>
<div class="flex-grow-1 ">
<a href="#" class="h6 d-block mb-0 stretched-link text-decoration-none">Your storage is full</a>
<small class="text-muted">Local storage is nearly full.</small>
</div>
</div>

<div class="list-group-item list-group-item-action d-flex align-items-start mb-3">
<div class="flex-shrink-0 me-3">
<i class="demo-psi-file-edit text-blue-200 fs-2"></i>
</div>
<div class="flex-grow-1 ">
<a href="#" class="h6 d-block mb-0 stretched-link text-decoration-none">Writing a New Article</a>
<small class="text-muted">Wrote a news article for the John Mike</small>
</div>
</div>

<div class="list-group-item list-group-item-action d-flex align-items-start mb-3">
<div class="flex-shrink-0 me-3">
<i class="demo-psi-speech-bubble-7 text-green-300 fs-2"></i>
</div>
<div class="flex-grow-1 ">
<div class="d-flex justify-content-between align-items-start">
<a href="#" class="h6 mb-0 stretched-link text-decoration-none">Comment sorting</a>
<span class="badge bg-info rounded ms-auto">NEW</span>
</div>
<small class="text-muted">You have 1,256 unsorted comments.</small>
</div>
</div>

<div class="list-group-item list-group-item-action d-flex align-items-start mb-3">
<div class="flex-shrink-0 me-3">
<img class="img-xs rounded-circle" src="./assets/img/profile-photos/7.png" alt="Profile Picture" loading="lazy">
</div>
<div class="flex-grow-1 ">
<a href="#" class="h6 d-block mb-0 stretched-link text-decoration-none">Lucy Sent you a message</a>
<small class="text-muted">30 minutes ago</small>
</div>
</div>

<div class="list-group-item list-group-item-action d-flex align-items-start mb-3">
<div class="flex-shrink-0 me-3">
<img class="img-xs rounded-circle" src="./assets/img/profile-photos/3.png" alt="Profile Picture" loading="lazy">
</div>
<div class="flex-grow-1 ">
<a href="#" class="h6 d-block mb-0 stretched-link text-decoration-none">Jackson Sent you a message</a>
<small class="text-muted">1 hours ago</small>
</div>
</div>
<div class="text-center mb-2">
<a href="#" class="btn-link">Show all Notifications</a>
</div>
</div>
</div>
</div>



</div>
</div>
</div>
</header>


<nav id="mainnav-container" class="mainnav">
<div class="mainnav__inner">

<div class="mainnav__top-content scrollable-content pb-5">

<div class="mainnav__profile mt-3 d-flex3">
<div class="mt-2 d-mn-max"></div>

<div class="mininav-toggle text-center py-2 collapsed">
<img class="mainnav__avatar img-md rounded-circle border" src="/assets/img/user.png" alt="Profile Picture">
</div>
<div class="mininav-content collapse d-mn-max">
<div class="d-grid">

<button class="d-block btn shadow-none p-2" data-bs-toggle="collapse" data-bs-target="#usernav" aria-expanded="false" aria-controls="usernav" fdprocessedid="lhu8e">
<span class="dropdown-toggle d-flex justify-content-center align-items-center">
<h6 class="mb-0 me-3">Alan Budi Kusumah</h6>
</span>
<small class="text-muted">Developer</small>
</button>

<div id="usernav" class="nav flex-column collapse">
<a href="#" class="nav-link d-flex justify-content-between align-items-center">
<span><i class="bi bi-key-fill fs-5 me-2"></i><span class="ms-1">Change Password</span></span>
</a>
<a href="#" class="nav-link">
<i class="bi bi-box-arrow-right fs-5 me-2"></i>
<span class="ms-1">Logout</span>
</a>
</div>
</div>
</div>
</div>


<div class="mainnav__categoriy py-3">

<ul class="mainnav__menu nav flex-column">


<li class="nav-item">
<a href="/books" class="nav-link mininav-toggle collapsed"><i class="bi bi-receipt fs-4 me-2"></i>
<span class="nav-label mininav-content ms-1">Books</span>
</a>
</li>


</ul>
</div>




<div class="mainnav__profile">

<div class="mininav-toggle text-center py-2 d-mn-min collapsed">
<i class="demo-pli-monitor-2"></i>
</div>
<div class="d-mn-max mt-5"></div>

<div class="mininav-content collapse d-mn-max">
<h6 class="mainnav__caption px-3 fw-bold">Server Status</h6>
<ul class="list-group list-group-borderless">
<li class="list-group-item text-reset">
<div class="d-flex justify-content-between align-items-start">
<p class="mb-2 me-auto">CPU Usage</p>
<span class="badge bg-info rounded">35%</span>
</div>
<div class="progress progress-md">
<div class="progress-bar bg-info" role="progressbar" style="width: 35%" aria-label="CPU Progress" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100"></div>
</div>
</li>
<li class="list-group-item text-reset">
<div class="d-flex justify-content-between align-items-start">
<p class="mb-2 me-auto">Bandwidth</p>
<span class="badge bg-warning rounded">73%</span>
</div>
<div class="progress progress-md">
<div class="progress-bar bg-warning" role="progressbar" style="width: 73%" aria-label="Bandwidth Progress" aria-valuenow="73" aria-valuemin="0" aria-valuemax="100"></div>
</div>
</li>
</ul>
<div class="d-grid px-3 mt-3">
<a href="#" class="btn btn-sm btn-success">View Details</a>
</div>
</div>
</div>

</div>


<div class="mainnav__bottom-content border-top pb-2">
<ul id="mainnav" class="mainnav__menu nav flex-column">
<li class="nav-item has-sub">
<a href="#" class="nav-link mininav-toggle collapsed" aria-expanded="false">
<i class="bi bi-box-arrow-right fs-4 me-2"></i>
<span class="nav-label ms-1">Logout</span>
</a>
<ul class="mininav-content nav flex-column collapse">
<li class="nav-item">
<a href="#" class="nav-link">This device only</a>
</li>
<li class="nav-item">
<a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">All Devices</a>
</li>
<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
@csrf
</form>
<li class="nav-item">
<a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Lock screen</a>
</li>
</ul>
</li>
</ul>
</div>

</div>
</nav>

@endif

@yield('content')



<!-- <script type="text/javascript" src="/assets/js/jquery.min.js"></script> -->
<!-- <script type="text/javascript" src="/assets/js/bootstrap.min.js" defer=""></script> -->
<!-- <script type="text/javascript" src="/assets/js/nifty.min.js" defer=""></script> -->
<!-- <script type="text/javascript" src="/assets/js/bootbox.min.js"></script>
<script type="text/javascript" src="/assets/js/ui-modals.js"></script> -->

<!-- <script src="/assets/js/bootstrap.min.bdf649e4bf3fa0261445f7c2ed3517c3f300c9bb44cb991c504bdc130a6ead19.js" defer=""></script> -->
<script src="/assets/js/nifty.min.b53472f123acc27ffd0c586e4ca3dc5d83c0670a3a5e120f766f88a92240f57b.js" defer=""></script>
    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.all.min.js"></script>

</body></html>
 
