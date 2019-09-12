@extends('layouts.public')

@section('content')

    <section class="home" style="background-image: url('/uploads/uploads/{{ setting('home_background') }}');">
        <div class="container">
            <div class="row">
                <h2>{!! html_entity_decode(\Constant::get('HOME_TITLE')) !!}</h2>

                <div class="providers">
                    @foreach($evouchers as $evoucher)
                        <img src="/uploads/evouchers/{{ $evoucher["image"] }}" alt="{{ $evoucher["name_$lang"] }}">
                    @endforeach
                </div>
                <div class="home_button">
                    {!! html_entity_decode(\Constant::get('HOME_BTN')) !!}
                </div>
                {{--<a href="#" class="button">VEZI MAI MULTE</a>--}}
            </div>
        </div>
    </section>
    @if(setting('extend_homepage'))
    <section class="amount_economy">
        <div class="container">
            <h3>{{ \Constant::get('CUSTOMER_HOME') }}</h3>
            <div class="currency_ammount">
                <div id="amount_digits" data-content="{{ priceString(\App\Models\Order::orderStage()->where('id_status', 2)->get()->sum(function($order){
                    return $order->retail_price - $order->price;
                }), 0, '') }}"></div>
                <span class="currency">{{ \Constant::get('LEI') }}</span>
            </div>

        </div>
    </section>

    <section class="top_sales">
        <div class="container">

            <h3>{{ \Constant::get('TOP_DISCOUNTS') }}</h3>
            <div class="sale_content">

                <div class="sale_item">

                    <div class="c100 p12">
                        <span>-12%</span>
                        <div class="slice">
                            <div class="bar"></div>
                            <div class="fill"></div>
                        </div>
                    </div>
                    <span class="title">500 lei e-voucher</span>
                    <span class="code">COD UI 15</span>
                </div>

                <div class="sale_item">
                    <div class="c100 p35">
                        <span>-35%</span>
                        <div class="slice">
                            <div class="bar"></div>
                            <div class="fill"></div>
                        </div>
                    </div>
                    <span class="title">500 lei e-voucher</span>
                    <span class="code">COD UI 15</span>
                </div>

                <div class="sale_item">
                    <div class="c100 p56">
                        <span>-56%</span>
                        <div class="slice">
                            <div class="bar"></div>
                            <div class="fill"></div>
                        </div>
                    </div>
                    <span class="title">500 lei e-voucher</span>
                    <span class="code">COD UI 15</span>
                </div>

            </div>

        </div>
    </section>


    <section class="testimonials">
        <div class="container">
            <h3>{{ \Constant::get('OUR_CLIENTS') }}</h3>

            <div id="dg-container" class="testimonials_galery dg-container">
                <div class="dg-wrapper">
                    @foreach($testimonials as $testimonial)
                        <div class="item">
                            <div class="profile_img" style="background-image: url('/uploads/testimonials/{{ $testimonial['image'] }}');">
                                @if($testimonial['video'])
                                <span data-fancybox href="{{ $testimonial['video'] }}"  data-width="640" data-height="360"><i class="fas fa-play"></i></span>
                                @endif
                            </div>
                            <span class="full_name">{{ $testimonial["name_$lang"] }}</span>
                            @if($testimonial["short_$lang"])
                                <p>{{ $testimonial["short_$lang"] }}</p>
                            @endif

                            @if($testimonial["review_$lang"])
                                <span class="dots" data-fancybox data-animation-duration="700" data-src="#aditionalContent_{{ $testimonial["id"] }}" href="javascript:;">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </span>
                                <div style="display: none; max-width: 500px;" id="aditionalContent_{{ $testimonial["id"] }}" class="animated-modal" >
                                    <p>{!! nl2br($testimonial["review_$lang"]) !!}</p>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
                <nav>
                    <div class="dg-prev nav"></div>
                    <div class="dg-next nav"></div>
                </nav>
            </div>
        </div>
    </section>
    @endif
@stop

