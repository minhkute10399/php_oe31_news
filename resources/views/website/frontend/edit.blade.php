@extends('website.frontend.header')

@section('content')
<header class="main-header header-style-2 mb-40">
    <div class="header-bottom header-sticky background-white text-center">
        <div class="scroll-progress gradient-bg-1"></div>
        <div class="mobile_menu d-lg-none d-block"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-2 col-md-3">
                    <div class="header-logo d-none d-lg-block">
                        <a href="{{ route('home.index') }}">
                            <img class="logo-img d-inline" src="assets/imgs/logo.svg" alt="">
                        </a>
                    </div>
                    <div class="logo-tablet d-md-inline d-lg-none d-none">
                        <a href="index.html">
                            <img class="logo-img d-inline" src="assets/imgs/logo.svg" alt="">
                        </a>
                    </div>
                    <div class="logo-mobile d-block d-md-none">
                        <a href="index.html">
                            <img class="logo-img d-inline" src="assets/imgs/favicon.svg" alt="">
                        </a>
                    </div>
                </div>
                <div class="col-lg-10 col-md-9 main-header-navigation">
                    <!-- Main-menu -->
                    <div class="main-nav text-left float-lg-left float-md-right">
                        <nav>
                            <ul class="main-menu d-none d-lg-inline">
                                <li class="menu-item-has-children">
                                    <a href="{{ route('home.index') }}">
                                        <span class="mr-15">
                                            <ion-icon name="home-outline"></ion-icon>
                                        </span>{{ trans('message.home') }}
                                    </a>
                                </li>
                                <li class="mega-menu-item">
                                    <a href="#">
                                        <span class="mr-15">
                                            <ion-icon name="desktop-outline"></ion-icon>
                                        </span>{{ trans('message.category') }}
                                    </a>
                                    <div class="sub-mega-menu sub-menu-list row text-muted font-small">
                                        @foreach ($category as $item)
                                            <ul class="col-md-2">
                                                <li><a href="{{ route('filterCategory', [$item->id]) }}"><strong>{{ $item->name }}</strong></a></li>
                                                @foreach ($item->children as $child)
                                                    <li><a href="{{ route('filterCategory', [$item->id]) }}">{{ $child->name }}</a></li>
                                                @endforeach
                                            </ul>
                                        @endforeach
                                    </div>
                                </li>
                                @auth
                                    @can('create_post')
                                        <li>
                                            <a href="{{ route('authors.create') }}">{{ trans('message.create_post') }}</a>
                                        </li>
                                    @endcan
                                @endauth
                                @guest
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('login') }}">{{ trans('message.login') }}</a>
                                    </li>
                                    @if (Route::has('register'))
                                        <li class="nav-item">
                                            <a class="nav-link"
                                                href="{{ route('register') }}">{{ trans('message.register') }}</a>
                                        </li>
                                    @endif
                                    @else
                                    <li class="nav-item dropdown">
                                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                            {{ Auth::user()->name }}
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                                @csrf
                                                <button class="btn btn-light"
                                                    type="submit" dusk="logout">{{ trans('message.logout') }}</button>
                                            </form>
                                            @can('my_post')
                                                <a href="{{ route('postAuthor', [Auth::user()->id]) }}" class="btn btn-primary">{{ trans('message.my_post') }}</a>
                                            @endcan
                                            @cannot('become_author')
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#author" dusk="become_author">
                                                    {{ trans('message.become_author') }}
                                                </button>
                                            @endcannot
                                        </div>
                                    </li>
                                @endguest
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                        data-toggle="dropdown" aria-haspopup="true" dusk="language" aria-expanded="false" v-pre>
                                        {{ trans('message.language') }}
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        <a href="{{ route('change-languages', ['language' => 'en']) }}" dusk="english">{{ trans('message.en') }}</a>
                                        <a href="{{ route('change-languages', ['language' => 'vi']) }}" dusk="vietnam">{{ trans('message.vi') }}</a>
                                    </div>
                                </li>
                            {{-- Notification --}}
                        </nav>
                    </div>

                   <!-- Search -->
                   <form action="{{ route('search') }}" method="GET"
                    class="search-form d-lg-inline float-right position-relative mr-30 d-none">
                        <input type="text" class="search_field" placeholder="{{ trans('message.search') }}" value="" name="search">
                        <button type="submit" class="search-icon"><i class="ti-search mr-5"></i></button>
                    </form>
               <!-- Off canvas -->
                    <div class="off-canvas-toggle-cover">
                        <div class="off-canvas-toggle hidden d-inline-block ml-15" id="off-canvas-toggle">
                            <ion-icon name="grid-outline"></ion-icon>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<div class="col-md-12 col-sm-12 alo-alo">
    <div class="x_panel create_post">
        <div class="x_title">
            <h2>{{ trans('message.edit_post') }}</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <br>
            <form id="demo-form2" data-parsley-validate="" class="form-horizontal form-label-left" novalidate=""
                enctype="multipart/form-data" method="POST" action="{{ route('authors.update', $authors->id) }}">
                @csrf
                @method('PUT')
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align"
                        for="first-name">{{ trans('message.category') }}<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 ">

                        <select class="form-control" name="category_id">
                            @foreach ($category as $item)
                                <option value="{{ $item->id }}" name="category_id">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align">{{ trans('message.title') }}</label>
                    <div class="col-md-6 col-sm-6 ">
                        <input type="text" id="img_title" name="title" required="required" class="form-control "
                            placeholder="{{ trans('message.title') }}" value="{{ $authors->title }}">
                    </div>
                </div>
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align">{{ trans('message.image') }}
                    </label>
                    <div class="col-md-6 col-sm-6 ">
                        <input type="file" class="custom-file-input" id="image" name="image" value="{{ $authors->image }}">
                        <label class="custom-file-label" for="inputGroupFile01"></label>
                    </div>
                </div>
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align">{{ trans('message.content') }}
                    </label>
                    <div class="col-md-6 col-sm-6 ">
                        <textarea name="content" id="content" cols="30" rows="20" value="{!! $authors->content !!}"></textarea>
                    </div>
                </div>
                <div class="ln_solid"></div>
                <div class="item form-group">
                    <div class="col-md-6 col-sm-6 offset-md-3">
                        <a class="btn btn-primary" type="button"
                            href="{{ route('home.index') }}">{{ trans('message.back') }}</a>
                        <button type="submit" class="btn btn-success">{{ trans('message.submit') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
    <script src="{{ asset('bower_components/components-font-awesome/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('bower_components/components-font-awesome/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('bower_components/components-font-awesome/tinymce/content.js') }}"></script>
    <!-- Vendor JS-->
    <script src="{{ asset('assets/js/vendor/modernizr-3.5.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/jquery-1.12.4.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/jquery.slicknav.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/slick.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/wow.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/animated.headline.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/jquery.magnific-popup.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/jquery.ticker.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/jquery.vticker-min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/jquery.scrollUp.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/jquery.sticky.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/waypoints.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/jquery.theia.sticky.js') }}"></script>
    <script src="{{ asset('../../../unpkg.com/ionicons%405.0.0/dist/ionicons.js') }}"></script>
    <!-- UltraNews JS -->
    <script src="{{ asset('assets/js/main2.js') }}"></script>
@endsection
