@extends('layouts.master')

@section('content')
    <section class="services" id="services">
        <div class="head-section">
            <span>
                خدماتی که ارائه می‌دهیم
            </span>
        </div>
        <div class="body">
            @foreach( $allRootCategoryServices as $service )
                <div class="service">
                    <div class="thumbnail">
                        {{ $service->thumbanil }}
                        <img src="{{ $service->thumbnail->specs[0]['relativepath']}} " alt="{{$service->title}}">
                    </div>
                    <div class="main">
                        <div class="title" style='color:{{$service->color->primary_color}}'>
                            {{ $service->title }}
                        </div>
                        <div class="excerpt">
                            {{ $service->excerpt }}
                        </div>
                        <div class="more" style='background:{{$service->color->gradient}}'>
                            <a href='{{ "/services/$service->slug/show/" }}'>
                                بیشتر بدانید
                            </a>
                        </div>
                    </div>
                </div> <!-- .service -->
                @endforeach

        </div>

    </section>

    <section id="pricing">
        <div class="panel panel-1">
            <div class="header">
                طراحی وب‌سایت
            </div>
            <div class="price">
                ۸۰۰٫۰۰۰
            </div>
            <div class="desc">
                تیمی متشکل از بهترین‌های این حوزه آماده هستند بهترین راه‌کارها را برای دیجیتالی‌شدن کسب‌وکارتان در جهت …
            </div>
            <div class="order">
                <a href="/services/web-design/">
                    جزئیات بیشتر و مشاوره
                </a>
            </div>

        </div>

        <div class="panel panel-2">
            <div class="header">
                ربات تلگرام
            </div>
            <div class="price">
                ۸۰۰٫۰۰۰
            </div>
            <div class="desc">
                تیمی متشکل از بهترین‌های این حوزه آماده هستند بهترین راه‌کارها را برای دیجیتالی‌شدن کسب‌وکارتان در جهت …
            </div>
            <div class="order">
                <a href="/services/telegram-bot/">
                    جزئیات بیشتر و مشاوره
                </a>
            </div>

        </div>

        <div class="panel panel-3">
            <div class="header">
                سئــــو
                SEO
            </div>
            <div class="price">
                ۸۰۰٫۰۰۰
            </div>
            <div class="desc">
                تیمی متشکل از بهترین‌های این حوزه آماده هستند بهترین راه‌کارها را برای دیجیتالی‌شدن کسب‌وکارتان در جهت …
            </div>
            <div class="order">
                <a href="/services/seo/">
                    جزئیات بیشتر و مشاوره
                </a>
            </div>

        </div>
    </section>

    <section id="news">

<!--         <div class="item">
            <a href="#">
                <img src="../img/1.jpg" alt="news">
                <p>
                    تخفیف به مناسبت نیمه شعبان
                </p>
            </a>
        </div>
 -->
    @if( $posts->count() )
        @foreach($posts as $post )
            <div class="item">
                <a href="/posts/{{$post->slug}}/show/#post">
                    <img src="{{ $post->thumb->specs[1]['relativepath'] }}" alt="$post->slug">
                    <p>
                        {{ $post->title }}
                    </p>
                </a>
            </div>
        @endforeach
    @endif


        <div class="more-news">
            <a href="#">
                مشاهده بیشتر
            </a>
        </div>
    </section>

@endsection