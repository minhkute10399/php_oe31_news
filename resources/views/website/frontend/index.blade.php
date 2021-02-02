@extends('website.frontend.header')

@section('content')
    <!-- Preloader Start -->
    <div id="preloader-active">
        <div class="preloader d-flex align-items-center justify-content-center">
            <div class="preloader-inner position-relative">
                <div class="text-center">
                    <img class="jump mb-50" src="assets/imgs/loading.svg" alt="">
                    <h6>{{ trans('message.now_loading') }}</h6>
                    <div class="loader">
                        <div class="bar bar1"></div>
                        <div class="bar bar2"></div>
                        <div class="bar bar3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="main-wrap">
        <!--Offcanvas sidebar-->
        <aside id="sidebar-wrapper" class="custom-scrollbar offcanvas-sidebar position-right">
            <button class="off-canvas-close"><i class="ti-close"></i></button>
            <div class="sidebar-inner">
                <!--lastest post-->
                <div class="sidebar-widget mb-50">
                    <div class="widget-header mb-30">
                        <h5 class="widget-title">{{ trans('message.top') }}<span>{{ trans('message.trending') }}</span></h5>
                    </div>
                    <div class="post-aside-style-2">
                        <ul class="list-post">
                            <li class="mb-30 wow fadeIn animated">
                                <div class="d-flex">
                                    <div class="post-thumb d-flex mr-15 border-radius-5 img-hover-scale">
                                        <a class="color-white" href="single.html">
                                            <img src="{{ asset('assets/imgs/thumbnail-2.jpg') }}" alt="">
                                        </a>
                                    </div>
                                    <div class="post-content media-body">
                                        <h6 class="post-title mb-10 text-limit-2-row"><a
                                                href="single.html">{{ trans('message.title') }}</a></h6>
                                        <div class="entry-meta meta-1 font-x-small color-grey float-left text-uppercase">
                                            <span class="post-by">{{ trans('message.by') }}<a
                                                    href="author.html">{{ trans('message.author') }}</a></span>
                                            <span class="post-on">{{ trans('message.created_at') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="mb-30 wow fadeIn animated">
                                <div class="d-flex">
                                    <div class="post-thumb d-flex mr-15 border-radius-5 img-hover-scale">
                                        <a class="color-white" href="single.html">
                                            <img src="assets/imgs/thumbnail-3.jpg" alt="">
                                        </a>
                                    </div>
                                    <div class="post-content media-body">
                                        <h6 class="post-title mb-10 text-limit-2-row"><a
                                                href="single.html">{{ trans('message.title') }}</a></h6>
                                        <div class="entry-meta meta-1 font-x-small color-grey float-left text-uppercase">
                                            <span class="post-by">{{ trans('message.by') }}<a
                                                    href="author.html">{{ trans('message.author') }}</a></span>
                                            <span class="post-on">{{ trans('message.created_at') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="mb-30 wow fadeIn animated">
                                <div class="d-flex">
                                    <div class="post-thumb d-flex mr-15 border-radius-5 img-hover-scale">
                                        <a class="color-white" href="single.html">
                                            <img src="{{ asset('assets/imgs/thumbnail-5.jpg') }}" alt="">
                                        </a>
                                    </div>
                                    <div class="post-content media-body">
                                        <h6 class="post-title mb-10 text-limit-2-row"><a
                                                href="single.html">{{ trans('message.title') }}</a></h6>
                                        <div class="entry-meta meta-1 font-x-small color-grey float-left text-uppercase">
                                            <span class="post-by">{{ trans('message.by') }}<a
                                                    href="author.html">{{ trans('message.author') }}</a></span>
                                            <span class="post-on">{{ trans('message.created_at') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <!--Categories-->
                <!--Ads-->
            </div>
        </aside>
        <!-- Main Header -->
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
        <!-- Main Wrap Start -->
        <main class="position-relative">
            <div class="container">
                <div class="row">
                    <!-- sidebar-left -->
                    <div class="col-lg-2 col-md-3 primary-sidebar sticky-sidebar sidebar-left order-2 order-md-1">
                        <!-- Widget Weather -->
                        <!-- Widget Categories -->

                        <!-- Widget Categories -->
                        <div class="sidebar-widget widget_categories_2 border-radius-10 bg-white mb-30">
                            @foreach ($category as $item)
                                <ul class="font-small text-muted">
                                    <li class="cat-item cat-item-2 active"><a href="{{ route('filterCategory', [$item->id]) }}">
                                        <span class="mr-10">
                                            <ion-icon name="earth-outline"></ion-icon>
                                        </span>{{ $item->name }}</a>
                                    </li>
                                </ul>
                            @endforeach
                        </div>
                        <div class="sidebar-widget widget_categories border-radius-10 bg-white mb-30">
                            <div class="widget-header position-relative mb-15">
                                <h5 class="widget-title"><strong>{{ trans('message.category') }}</strong></h5>
                            </div>
                            @foreach ($category as $item)
                                <ul class="font-small text-muted">
                                    @foreach ($item->children as $child)
                                        <li class="cat-item cat-item-2"><a href="{{ route('filterCategory', [$child->id]) }}" dusk="category">{{ $child->name }}</a></li>
                                    @endforeach
                                </ul>
                            @endforeach
                        </div>
                    </div>
                    <!-- main content -->
                    <div class="col-lg-10 col-md-9 order-1 order-md-2">
                        <div class="row">
                            <div class="col-lg-8 col-md-12">
                                <!-- Featured posts -->
                                <div class="featured-post mb-50">
                                    <h4 class="widget-title mb-30">
                                        {{ trans('message.breaking') }}<span> {{ trans('message.news') }}</span></h4>
                                    <div class="featured-slider-1 border-radius-10">
                                        <div class="featured-slider-1-items">
                                            <div class="slider-single p-10">
                                                <div
                                                    class="img-hover-slide border-radius-15 mb-30 position-relative overflow-hidden">
                                                    <span class="top-right-icon bg-dark"><i
                                                            class="mdi mdi-camera-alt"></i></span>
                                                    <a href="single.html">
                                                        <img src="assets/imgs/news-8.jpg" alt="post-slider">
                                                    </a>
                                                </div>
                                                <div class="pr-10 pl-10">
                                                    <div class="entry-meta mb-30">
                                                        <a class="entry-meta meta-0" href="category.html"><span
                                                                class="post-in background1 text-danger font-x-small">{{ trans('message.category') }}</span></a>
                                                        <div class="float-right font-small">
                                                            <span>
                                                                <span class="mr-10 text-muted">
                                                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                                                </span>{{ trans('message.view') }}
                                                            </span>
                                                            <span class="ml-30"><span class="mr-10 text-muted"><i
                                                                        class="fa fa-comment"
                                                                        aria-hidden="true"></i></span>{{ trans('message.comment') }}</span>
                                                        </div>
                                                    </div>
                                                    <h4 class="post-title mb-20"><a
                                                            href="#">{{ trans('message.title') }}</a></h4>
                                                    <div class="mb-20 overflow-hidden">
                                                        <div class="entry-meta meta-2 float-left">
                                                            <a class="float-left mr-10 author-img" href="author.html"
                                                                tabindex="0"><img src="assets/imgs/authors/author.png"
                                                                    alt=""></a>
                                                            <a href="author.html" tabindex="0"><span
                                                                    class="author-name text-grey">{{ trans('message.author') }}</span></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="slider-single pt-10 pl-10 pr-10 pb-10">
                                                <div
                                                    class="img-hover-slide border-radius-15 mb-30 position-relative overflow-hidden">
                                                    <span class="top-right-icon bg-dark"><i
                                                            class="mdi mdi-flash-on"></i></span>
                                                    <a href="single.html">
                                                        <img src="assets/imgs/slide-1.jpg" alt="post-slider">
                                                    </a>
                                                </div>
                                                <div class="pr-10 pl-10">
                                                    <div class="entry-meta mb-30">
                                                        <a class="entry-meta meta-0" href="category.html"><span
                                                                class="post-in background2 text-primary font-x-small">{{ trans('message.category') }}</span></a>
                                                        <div class="float-right font-small">
                                                            <span><span class="mr-10 text-muted"><i class="fa fa-eye"
                                                                        aria-hidden="true"></i></span>{{ trans('message.view') }}</span>
                                                            <span class="ml-30"><span class="mr-10 text-muted">
                                                                    <i class="fa fa-comment"
                                                                        aria-hidden="true"></i></span>{{ trans('message.comment') }}</span>
                                                        </div>
                                                    </div>
                                                    <h4 class="post-title mb-20"><a
                                                            href="#">{{ trans('message.title') }}</a>
                                                    </h4>
                                                    <div class="mb-20 overflow-hidden">
                                                        <div class="entry-meta meta-2 float-left">
                                                            <a class="float-left mr-10 author-img" href="author.html"
                                                                tabindex="0"><img src="assets/imgs/authors/author-1.png"
                                                                    alt=""></a>
                                                            <a href="author.html" tabindex="0"><span
                                                                    class="author-name text-grey">{{ trans('message.author') }}</span></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--Videos-->
                            </div>
                            <div class="col-lg-4 col-md-12 sidebar-right">
                                <!--Post aside style 1-->
                                <div class="sidebar-widget mb-30">
                                    <div class="widget-header position-relative mb-30">
                                        <div class="row">
                                            <div class="col-7">

                                            </div>
                                            <div class="col-5 text-right">

                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!--Top authors-->

                                <!--Newsletter-->

                                <!--Post aside style 2-->
                                <div class="sidebar-widget">
                                    <div class="widget-header mb-30">
                                        <h5 class="widget-title">
                                            {{ trans('message.top') }}<span> {{ trans('message.trending') }}</span></h5>
                                    </div>
                                    <div class="post-aside-style-2">
                                        <ul class="list-post">
                                            <li class="mb-30 wow fadeIn animated">
                                                <div class="d-flex">
                                                    <div class="post-thumb d-flex mr-15 border-radius-5 img-hover-scale">
                                                        <a class="color-white" href="single.html">
                                                            <img src="assets/imgs/thumbnail-2.jpg" alt="">
                                                        </a>
                                                    </div>
                                                    <div class="post-content media-body">
                                                        <h6 class="post-title mb-10 text-limit-2-row"><a
                                                                href="single.html">{{ trans('message.title') }}</a></h6>
                                                        <div
                                                            class="entry-meta meta-1 font-x-small color-grey float-left text-uppercase">
                                                            <span class="post-by">{{ trans('message.by') }} <a
                                                                    href="author.html">{{ trans('message.author') }}</a></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="mb-30 wow fadeIn animated">
                                                <div class="d-flex">
                                                    <div class="post-thumb d-flex mr-15 border-radius-5 img-hover-scale">
                                                        <a class="color-white" href="single.html">
                                                            <img src="assets/imgs/thumbnail-2.jpg" alt="">
                                                        </a>
                                                    </div>
                                                    <div class="post-content media-body">
                                                        <h6 class="post-title mb-10 text-limit-2-row"><a
                                                                href="single.html">{{ trans('message.title') }}</a></h6>
                                                        <div
                                                            class="entry-meta meta-1 font-x-small color-grey float-left text-uppercase">
                                                            <span class="post-by">{{ trans('message.by') }} <a
                                                                    href="author.html">{{ trans('message.author') }}</a></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="mb-30 wow fadeIn animated">
                                                <div class="d-flex">
                                                    <div class="post-thumb d-flex mr-15 border-radius-5 img-hover-scale">
                                                        <a class="color-white" href="single.html">
                                                            <img src="assets/imgs/thumbnail-2.jpg" alt="">
                                                        </a>
                                                    </div>
                                                    <div class="post-content media-body">
                                                        <h6 class="post-title mb-10 text-limit-2-row"><a
                                                                href="single.html">{{ trans('message.title') }}</a></h6>
                                                        <div
                                                            class="entry-meta meta-1 font-x-small color-grey float-left text-uppercase">
                                                            <span class="post-by">{{ trans('message.by') }} <a
                                                                    href="author.html">{{ trans('message.author') }}</a></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-8 col-md-12">
                                <div class="latest-post mb-50">
                                    <div class="widget-header position-relative mb-30">
                                        <div class="row">
                                            <div class="col-7">
                                                <h4 class="widget-title mb-0">
                                                    {{ trans('message.latest') }}<span> {{ trans('message.post') }}</span>
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="loop-list-style-1">
                                        <article
                                            class="first-post p-10 background-white border-radius-10 mb-30 wow fadeIn animated">
                                            <div
                                                class="img-hover-slide border-radius-15 mb-30 position-relative overflow-hidden">
                                                <span class="top-right-icon bg-dark"><i class="mdi mdi-flash-on"></i></span>
                                                <a href="single.html">
                                                    <img src="assets/imgs/news-21.jpg" alt="post-slider">
                                                </a>
                                            </div>
                                            <div class="pr-10 pl-10">
                                                <div class="entry-meta mb-30">
                                                    <a class="entry-meta meta-0" href="category.html"><span
                                                            class="post-in background2 text-primary font-x-small">{{ trans('message.category') }}</span></a>
                                                    <div class="float-right font-small">
                                                        <span><span class="mr-10 text-muted"><i class="fa fa-eye"
                                                                    aria-hidden="true"></i></span>{{ trans('message.view') }}</span>
                                                        <span class="ml-30"><span class="mr-10 text-muted"><i
                                                                    class="fa fa-comment"
                                                                    aria-hidden="true"></i></span>{{ trans('message.comment') }}</span>
                                                    </div>
                                                </div>
                                                <h4 class="post-title mb-20">
                                                    <span class="post-format-icon">
                                                        <ion-icon name="headset-outline"></ion-icon>
                                                    </span>
                                                    <a href="single.html">{{ trans('message.title') }}</a>
                                                </h4>
                                                <div class="mb-20 overflow-hidden">
                                                    <div
                                                        class="entry-meta meta-1 font-x-small color-grey float-left text-uppercase">
                                                        <span class="post-by">{{ trans('message.by') }} <a
                                                                href="author.html">{{ trans('message.author') }}</a></span>
                                                        <span class="post-on">{{ trans('message.created_at') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </article>
                                        @foreach ($posts as $post)
                                            <article
                                                class="p-10 background-white border-radius-10 mb-30 wow fadeIn animated">
                                                <div class="d-flex">
                                                    <div class="post-thumb d-flex mr-15 border-radius-15 img-hover-scale">
                                                        <a class="color-white"
                                                            href="{{ route('posts.show', [$post->id]) }}">
                                                            <img class="border-radius-15"
                                                                src="{{ asset('images/' . $post->image) }}" alt="">
                                                        </a>
                                                    </div>
                                                    <div class="post-content media-body">
                                                        <div class="entry-meta mb-15 mt-10">
                                                            <a class="entry-meta meta-2" href="category.html"><span
                                                                    class="post-in text-danger font-x-small">{{ $post->category->name }}</span></a>
                                                        </div>
                                                        <h5 class="post-title mb-15 text-limit-2-row">
                                                            <a
                                                                href="{{ route('posts.show', [$post->id]) }}">{{ $post->title }}</a>
                                                        </h5>
                                                        <div
                                                            class="entry-meta meta-1 font-x-small color-grey float-left text-uppercase">
                                                            <span class="post-by">{{ trans('message.by') }} <a
                                                                    href="author.html">{{ $post->author->name }}</a></span>
                                                            <span class="post-on">{{  date('M d ,Y', strtotime($post->created_at)) }} {{ trans('message.at') }} {{  date('g:ia', strtotime($post->created_at)) }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </article>
                                        @endforeach
                                        {{ $posts->links() }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-12 sidebar-right">
                                <div class="sidebar-widget mb-50">
                                    <div class="widget-header mb-30">
                                        <h5 class="widget-title">
                                            {{ trans('message.most') }}<span> {{ trans('message.popular') }}</span></h5>
                                    </div>
                                    <div class="post-aside-style-3">
                                        <article class="bg-white border-radius-15 mb-30 p-10 wow fadeIn animated">
                                            <div class="post-thumb d-flex mb-15 border-radius-15 img-hover-scale">
                                                <a href="single.html">
                                                    <img class="border-radius-15" src="assets/imgs/news-22.jpg" alt="">
                                                </a>
                                            </div>
                                            <div class="pl-10 pr-10">
                                                <h5 class="post-title mb-15"><a
                                                        href="single.html">{{ trans('message.title') }}</a></h5>
                                                <div
                                                    class="entry-meta meta-1 font-x-small color-grey float-left text-uppercase mb-10">
                                                    <span class="post-in"><a
                                                            href="category.html">{{ trans('message.category') }}</a></span>
                                                    <span class="post-by">{{ trans('message.by') }} <a
                                                            href="author.html">{{ trans('message.author') }}</a></span>
                                                </div>
                                            </div>
                                        </article>
                                        <article class="bg-white border-radius-15 mb-30 p-10 wow fadeIn animated">
                                            <div class="post-thumb d-flex mb-15 border-radius-15 img-hover-scale">
                                                <a href="single.html">
                                                    <img class="border-radius-15" src="assets/imgs/news-22.jpg" alt="">
                                                </a>
                                            </div>
                                            <div class="pl-10 pr-10">
                                                <h5 class="post-title mb-15"><a
                                                        href="single.html">{{ trans('message.title') }}</a></h5>
                                                <div
                                                    class="entry-meta meta-1 font-x-small color-grey float-left text-uppercase mb-10">
                                                    <span class="post-in"><a
                                                            href="category.html">{{ trans('message.category') }}</a></span>
                                                    <span class="post-by">{{ trans('message.by') }} <a
                                                            href="author.html">{{ trans('message.author') }}</a></span>
                                                </div>
                                            </div>
                                        </article>
                                        <article class="bg-white border-radius-15 mb-30 p-10 wow fadeIn animated">
                                            <div class="post-thumb d-flex mb-15 border-radius-15 img-hover-scale">
                                                <a href="single.html">
                                                    <img class="border-radius-15" src="assets/imgs/news-22.jpg" alt="">
                                                </a>
                                            </div>
                                            <div class="pl-10 pr-10">
                                                <h5 class="post-title mb-15"><a
                                                        href="single.html">{{ trans('message.title') }}</a></h5>
                                                <div
                                                    class="entry-meta meta-1 font-x-small color-grey float-left text-uppercase mb-10">
                                                    <span class="post-in"><a
                                                            href="category.html">{{ trans('message.category') }}</a></span>
                                                    <span class="post-by">{{ trans('message.by') }} <a
                                                            href="author.html">{{ trans('message.author') }}</a></span>
                                                </div>
                                            </div>
                                        </article>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-50 mt-15">
                            <div class="col-md-12">
                                <div class="widget-header position-relative mb-30">
                                    <h4 class="widget-title mb-0">
                                        {{ trans('message.all') }}<span> {{ trans('message.post') }}</span></h4>
                                </div>
                                <div class="post-carausel-2 post-module-1 row">
                                    <div class="col">
                                        <div class="post-thumb position-relative">
                                            <article class="bg-white border-radius-15 mb-30 p-10 wow fadeIn animated">
                                                <div class="post-thumb d-flex mb-15 border-radius-15 img-hover-scale">
                                                    <a href="single.html">
                                                        <img class="border-radius-15" src="assets/imgs/news-22.jpg" alt="">
                                                    </a>
                                                </div>
                                                <div class="pl-10 pr-10">
                                                    <h5 class="post-title mb-15"><a
                                                            href="single.html">{{ trans('message.title') }}</a></h5>
                                                    <div
                                                        class="entry-meta meta-1 font-x-small color-grey float-left text-uppercase mb-10">
                                                        <span class="post-in"><a
                                                                href="category.html">{{ trans('message.category') }}</a></span>
                                                        <span class="post-by">{{ trans('message.by') }} <a
                                                                href="author.html">{{ trans('message.author') }}</a></span>
                                                    </div>
                                                </div>
                                            </article>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="post-thumb position-relative">
                                            <article class="bg-white border-radius-15 mb-30 p-10 wow fadeIn animated">
                                                <div class="post-thumb d-flex mb-15 border-radius-15 img-hover-scale">
                                                    <a href="single.html">
                                                        <img class="border-radius-15" src="assets/imgs/news-22.jpg" alt="">
                                                    </a>
                                                </div>
                                                <div class="pl-10 pr-10">
                                                    <h5 class="post-title mb-15"><a
                                                            href="single.html">{{ trans('message.title') }}</a></h5>
                                                    <div
                                                        class="entry-meta meta-1 font-x-small color-grey float-left text-uppercase mb-10">
                                                        <span class="post-in"><a
                                                                href="category.html">{{ trans('message.category') }}</a></span>
                                                        <span class="post-by">{{ trans('message.by') }} <a
                                                                href="author.html">{{ trans('message.author') }}</a></span>
                                                    </div>
                                                </div>
                                            </article>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="post-thumb position-relative">
                                            <article class="bg-white border-radius-15 mb-30 p-10 wow fadeIn animated">
                                                <div class="post-thumb d-flex mb-15 border-radius-15 img-hover-scale">
                                                    <a href="single.html">
                                                        <img class="border-radius-15" src="assets/imgs/news-22.jpg" alt="">
                                                    </a>
                                                </div>
                                                <div class="pl-10 pr-10">
                                                    <h5 class="post-title mb-15"><a
                                                            href="single.html">{{ trans('message.title') }}</a></h5>
                                                    <div
                                                        class="entry-meta meta-1 font-x-small color-grey float-left text-uppercase mb-10">
                                                        <span class="post-in"><a
                                                                href="category.html">{{ trans('message.category') }}</a></span>
                                                        <span class="post-by">{{ trans('message.by') }} <a
                                                                href="author.html">{{ trans('message.author') }}</a></span>
                                                    </div>
                                                </div>
                                            </article>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="post-thumb position-relative">
                                            <article class="bg-white border-radius-15 mb-30 p-10 wow fadeIn animated">
                                                <div class="post-thumb d-flex mb-15 border-radius-15 img-hover-scale">
                                                    <a href="single.html">
                                                        <img class="border-radius-15" src="assets/imgs/news-22.jpg" alt="">
                                                    </a>
                                                </div>
                                                <div class="pl-10 pr-10">
                                                    <h5 class="post-title mb-15"><a
                                                            href="single.html">{{ trans('message.title') }}</a></h5>
                                                    <div
                                                        class="entry-meta meta-1 font-x-small color-grey float-left text-uppercase mb-10">
                                                        <span class="post-in"><a
                                                                href="category.html">{{ trans('message.category') }}</a></span>
                                                        <span class="post-by">{{ trans('message.by') }} <a
                                                                href="author.html">{{ trans('message.author') }}</a></span>
                                                    </div>
                                                </div>
                                            </article>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="post-thumb position-relative">
                                            <article class="bg-white border-radius-15 mb-30 p-10 wow fadeIn animated">
                                                <div class="post-thumb d-flex mb-15 border-radius-15 img-hover-scale">
                                                    <a href="single.html">
                                                        <img class="border-radius-15" src="assets/imgs/news-22.jpg" alt="">
                                                    </a>
                                                </div>
                                                <div class="pl-10 pr-10">
                                                    <h5 class="post-title mb-15"><a
                                                            href="single.html">{{ trans('message.title') }}</a></h5>
                                                    <div
                                                        class="entry-meta meta-1 font-x-small color-grey float-left text-uppercase mb-10">
                                                        <span class="post-in"><a
                                                                href="category.html">{{ trans('message.category') }}</a></span>
                                                        <span class="post-by">{{ trans('message.by') }} <a
                                                                href="author.html">{{ trans('message.author') }}</a></span>
                                                    </div>
                                                </div>
                                            </article>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <!-- Footer Start-->
        <footer>
            <div class="footer-area pt-50 bg-white">
                <div class="container">
                </div>
            </div>
            <!-- footer-bottom aera -->
            <div class="footer-bottom-area bg-white text-muted">
                <div class="container">
                    <div class="footer-border pt-20 pb-20">
                        <div class="row d-flex mb-15">

                        </div>
                        <div class="row d-flex align-items-center justify-content-between">
                            <div class="col-12">
                                <div class="footer-copy-right">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer End-->
        </footer>
    </div> <!-- Main Wrap End-->
    <div class="modal fade" id="author" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('requestAuthor') }}" method="POST">
                    @csrf
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align">{{ trans('message.title') }}</label>
                        <div class="col-md-6 col-sm-6 ">
                            <input type="text" id="note" name="note" required="required" class="form-control "
                                placeholder=" Title ...">
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary close" data-dismiss="modal">{{ trans('message.close') }}</button>
              <button type="submit" class="btn btn-primary">{{ trans('message.save') }}</button>
            </div>
        </form>
          </div>
        </div>
      </div>
    <div class="dark-mark"></div>
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
