<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ trans('message.detail_post') }}</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="manifest" href="site.html">
    <link rel="shortcut icon" type="image/x-icon" href="assets/imgs/favicon.svg">

    <!-- UltraNews CSS  -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/widgets.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/color.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/components-font-awesome/css/all.css') }}">
</head>

<body>
    <!-- Preloader Start -->
    <div id="preloader-active">
        <div class="preloader d-flex align-items-center justify-content-center">
            <div class="preloader-inner position-relative">
                <div class="text-center">
                    <img class="jump mb-50" src="{{ asset('assets/imgs/loading.svg') }}" alt="">
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
                                <a href="index.html">
                                    <img class="logo-img d-inline" src="{{ asset('assets/imgs/logo.svg') }}" alt="">
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
                                                        <li><strong>{{ $item->name }}</strong></li>
                                                        @foreach ($item->children as $child)
                                                            <li><a href="{{ route('filterCategory', [$child->id]) }}">{{ $child->name }}</a></li>
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
                                                <a class="nav-link"
                                                    href="{{ route('login') }}">{{ trans('message.login') }}</a>
                                            </li>
                                            @if (Route::has('register'))
                                                <li class="nav-item">
                                                    <a class="nav-link"
                                                        href="{{ route('register') }}">{{ trans('message.register') }}</a>
                                                </li>
                                            @endif
                                            @else
                                                <li class="nav-item dropdown">
                                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#"
                                                        role="button" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false" v-pre>
                                                        {{ Auth::user()->name }}
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right"
                                                        aria-labelledby="navbarDropdown">
                                                        <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                                            @csrf
                                                            <button class="btn btn-light"
                                                                type="submit">{{ trans('message.logout') }}</button>
                                                        </form>
                                                        @can('my_post')
                                                        <a href="{{ route('postAuthor', [Auth::user()->id]) }}" class="btn btn-primary">{{ trans('message.my_post') }}</a>
                                                        @endcan
                                                        @cannot('become_author')
                                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#author">
                                                                {{ trans('message.become_author') }}
                                                            </button>
                                                        @endcannot
                                                    </div>
                                                </li>
                                        @endguest
                                        <li class="nav-item dropdown">
                                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                                {{ trans('message.language') }}
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                                <a href="{{ route('change-languages', ['language' => 'en']) }}">{{ trans('message.en') }}</a>
                                                <a href="{{ route('change-languages', ['language' => 'vi']) }}">{{ trans('message.vi') }}</a>
                                            </div>
                                        </li>
                                    </ul>
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
                <div class="entry-header entry-header-1 mb-30 mt-50" data-postid="{{ $post->id }}">
                    <div class="entry-meta meta-0 font-small mb-30"><a href="{{ route('filterCategory', [$post->category->id]) }}"><span
                                class="post-cat bg-success color-white">{{ $post->category->name }}</span></a></div>
                    <h1 class="post-title mb-30 title-detail">
                        {{ $post->title }}
                    </h1>
                    <div class="entry-meta meta-1 font-x-small color-grey text-uppercase">
                        <span class="post-by">{{ trans('message.by') }} <a
                                href="author.html">{{ $post->author->name }}</a></span>
                        <span class="post-on">{{ date('M d ,Y', strtotime($post->created_at)) }} {{ trans('message.at') }} {{ date('g:ia', strtotime($post->created_at)) }}</span>
                        <div class="font-x-small mt-10 icon-like">
                            <div class="hit-count">
                                <i class="far fa-eye"></i> {{ $post->view . " " . trans('message.view') }}
                            </div>
                            <div class="hit-count">
                                <i class="ti-comment mr-5"></i>{{ $post->comments->count() . " " . trans('message.comment') }}
                            </div>
                            <div class="hit-count">
                                <i class="far fa-thumbs-up"></i>{{ $post->likes->where('like', config('number_format.view'))->count() . " " . trans('message.like') }}
                            </div>
                            <br>
                        </div>
                        @auth
                            <div class="interaction">
                                <button data-post="{{ $post->id }}" class="btn btn-primary like"><i class="far fa-thumbs-up"></i>
                                    {{ trans('message.like') }}
                                </button>
                            </div>
                        @endauth

                    </div>
                </div>
                <!--end entry header-->
                <div class="row mb-50">
                    <div class="col-lg-8 col-md-12">
                        <div class="bt-1 border-color-1 mb-30"></div>
                        <div class="entry-main-content">
                            {!! $post->content !!}
                        </div>
                        <!--related posts-->
                        <div class="related-posts">
                            <h4 class="mb-30">{{ trans('message.related_post') }}</h4>
                            <div class="row">
                                <article class="col-lg-4">
                                    <div class="background-white border-radius-10 p-10 mb-30">
                                        <div class="post-thumb d-flex mb-15 border-radius-15 img-hover-scale">
                                            <a href="single.html">
                                                <img class="border-radius-15"
                                                    src="{{ asset(config('image_user.image') . '/' . $post->image) }}"
                                                    alt="">
                                            </a>
                                        </div>
                                        <div class="pl-10 pr-10">
                                            <div class="entry-meta mb-15 mt-10">
                                                <a class="entry-meta meta-2" href="category.html"><span
                                                        class="post-in text-primary font-x-small"></span></a>
                                            </div>
                                            <h5 class="post-title mb-15">
                                                <a href="single.html">{{ $post->title }}</a>
                                            </h5>
                                            <div
                                                class="entry-meta meta-1 font-x-small color-grey float-left text-uppercase mb-10">
                                                <span class="post-by">{{ trans('message.by') }}<a
                                                        href="author.html">{{ $post->author->name }}</a></span>
                                                <span class="post-on">{{ date('M d ,Y', strtotime($post->created_at)) }} {{ trans('message.at') }} {{ date('g:ia', strtotime($post->created_at)) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </article>

                            </div>
                        </div>
                        <!--Comments-->
                        <div class="comments-area">
                        <h3 class="mb-30" id="count-comment">{{ $post->comments->count() . " " . trans('message.comment') }}</h3>
                            <div class="comment-list">
                                @foreach ($post->comments as $comment)
                                    <div class="single-comment justify-content-between d-flex" id="listcomment">
                                        <div class="user justify-content-between d-flex">
                                            <div class="thumb">
                                                <img src="{{ asset('images/' . $post->author->image) }}" alt="">
                                            </div>
                                            <div class="desc">
                                                <div class="d-flex justify-content-between">
                                                    <div class="d-flex align-items-center">
                                                        <h5>
                                                            <a href="#">{{ $comment->user->name }}</a>
                                                        </h5>
                                                        <p class="date">{{ $comment->created_at->diffForHumans() }}</p>
                                                    </div>
                                                </div>
                                                <p class="comment">
                                                    {!! $comment->content !!}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!--comment form-->
                            @auth
                                <div class="comment-form">
                                    <h4 class="mb-30">{{ trans('message.leave_reply') }}</h4>
                                        <input type="hidden" value="{{ $post->id }}" name="post_id" id="post_id">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <textarea class="form-control w-100" name="content" id="content"
                                                        cols="10" rows="10"
                                                        placeholder="{{ trans('message.write_comment') }}">
                                                    </textarea>
                                                </div>
                                            </div>
                                        </div>
                                    <div class="form-group">
                                        <button
                                            class="button button-contactForm" data-url="{{ route('comments.store') }}">
                                            {{ trans('message.post_comment') }}
                                        </button>
                                    </div>
                                </div>
                            @endauth
                        </div>
                        <!--End col-lg-8-->

                        <!--End col-lg-4-->
                    </div>
                    <div class="col-lg-4 col-md-12 sidebar-right sticky-sidebar">
                        <div class="pl-lg-50">
                            <!--Post aside style 2-->
                            <div class="sidebar-widget mb-50">
                                <div class="widget-header mb-30">
                                    <h5 class="widget-title">{{ trans('message.recent') }}
                                        <span>{{ trans('message.post') }}</span>
                                    </h5>
                                </div>
                                <div class="post-aside-style-3">
                                    <article class="bg-white border-radius-15 mb-30 p-10 wow fadeIn  animated">
                                        <div class="post-thumb d-flex mb-15 border-radius-15 img-hover-scale">
                                            <a href="single.html">

                                            </a>
                                        </div>
                                        <div class="pl-10 pr-10">
                                            <h5 class="post-title mb-15">
                                                <a href="single.html">{{ trans('message.title') }}</a>
                                            </h5>

                                            <div
                                                class="entry-meta meta-1 font-x-small color-grey float-left text-uppercase mb-10">
                                                <span class="post-in"><a
                                                        href="category.html">{{ trans('message.category') }}</a></span>
                                                <span class="post-by">{{ trans('message.by') }}<a
                                                        href="author.html">{{ trans('message.author') }}</a></span>
                                                <span class="post-on">{{ trans('message.created_at') }}</span>
                                            </div>
                                        </div>
                                    </article>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End row-->
                </div>
                <div class="row">
                    <div class="col-12 text-center mb-50">
                        <a href="#">
                            <img class="border-radius-10 d-inline" src="assets/imgs/ads-3.png" alt="">
                        </a>
                    </div>
                </div>
                <div class="row mb-50">
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="sidebar-widget mb-md-30">
                            <div class="widget-header mb-30">
                                <h5 class="widget-title">
                                    {{ trans('message.top') }}<span>{{ trans('message.trending') }}</span>
                                </h5>
                            </div>
                            <div class="post-aside-style-2">
                                <ul class="list-post">
                                    <li class="mb-30 wow fadeIn animated">
                                        <div class="d-flex">
                                            <div class="post-thumb d-flex mr-15 border-radius-5 img-hover-scale">
                                                <a class="color-white" href="single.html">
                                                    <img src="{{ asset('assets/imgs/thumbnail-12.jpg') }}" alt="">
                                                </a>
                                            </div>
                                            <div class="post-content media-body">
                                                <h6 class="post-title mb-10 text-limit-2-row">
                                                    <a href="single.html">{{ trans('message.title') }}</a>
                                                </h6>
                                                <div
                                                    class="entry-meta meta-1 font-x-small color-grey float-left text-uppercase">
                                                    <span class="post-by">{{ trans('message.by') }}
                                                        <a href="author.html">{{ trans('message.author') }}
                                                        </a>
                                                    </span>
                                                    <span class="post-on">{{ trans('message.created_at') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="sidebar-widget mb-md-30">
                            <div class="widget-header mb-30">
                                <h5 class="widget-title">
                                    {{ trans('message.editor') }}<span>{{ trans('message.picked') }}</span>
                                </h5>
                            </div>
                            <div class="post-aside-style-1 border-radius-10 p-20 bg-white">
                                <ul class="list-post">
                                    <li class="mb-20">
                                        <div class="d-flex">
                                            <div class="post-thumb d-flex mr-15 border-radius-5 img-hover-scale">
                                                <a class="color-white" href="single.html">
                                                    <img src="{{ asset('assets/imgs/thumbnail-4.jpg') }}" alt="">
                                                </a>
                                            </div>
                                            <div class="post-content media-body">
                                                <h6 class="post-title mb-10 text-limit-2-row">
                                                    <a href="single.html">
                                                        {{ trans('message.title') }}
                                                    </a>
                                                </h6>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="sidebar-widget mb-sm-30">
                            <div class="widget-header mb-30">
                                <h5 class="widget-title"><span>{{ trans('message.most_popular') }}</span></h5>
                            </div>
                            <div class="post-aside-style-2">
                                <ul class="list-post">
                                    <li class="mb-30 wow fadeIn-animated">
                                        <div class="d-flex">
                                            <div class="post-thumb d-flex mr-15 border-radius-5 img-hover-scale">
                                                <a class="color-white" href="single.html">
                                                    <img src="{{ asset('assets/imgs/thumbnail-2.jpg') }}" alt="">
                                                </a>
                                            </div>
                                            <div class="post-content media-body">
                                                <h6 class="post-title mb-10 text-limit-2-row">
                                                    <a href="single.html">
                                                        {{ trans('message.title') }}
                                                    </a>
                                                </h6>
                                                <div
                                                    class="entry-meta meta-1 font-x-small color-grey float-left text-uppercase">
                                                    <span class="post-by">{{ trans('message.by') }}
                                                        <a href="author.html">
                                                            {{ trans('message.author') }}
                                                        </a>
                                                    </span>
                                                    <span class="post-on">{{ trans('message.created_at') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
        </main>
        <!-- Footer Start-->
        <footer>
            <div class="footer-area pt-50 bg-white">
                <div class="container">
                    <div class="row pb-30">
                        <div class="col">
                            @foreach ($category as $item)
                                <ul class="float-left mr-30 font-medium">
                                    <li><strong>{{ $item->name }}</strong></li>
                                    @foreach ($item->children as $child)
                                        <li class="cat-item cat-item-2">
                                            <a href="category.html">{{ $child->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <!-- footer-bottom aera -->
            <!-- Footer End-->
        </footer>
    </div> <!-- Main Wrap End-->
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
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="{{ asset('bower-components/components-font-awesome/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('js/like.js') }}"></script>
    <script type="text/javascript">
        var token = '{{ Session::token() }}';
        var urlLike = '{{ route('like') }}';
        var urldisLike = '{{ route('dislike') }}';
    </script>
    <script src="{{ asset('js/comment.js') }}"></script>
</body>


<!-- Mirrored from demos.alithemes.com/html/newsviral/single.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 25 Oct 2020 07:34:20 GMT -->

</html>
