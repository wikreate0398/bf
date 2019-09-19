@extends('layouts.public')

@section('content')
    <section class="licitatii_specifice">
        <div class="container">
             
            @include('public.utils.top_banner')

            {{--<div class="alert">--}}
                {{--<p> 12.04.2018: Licitația UL13258 a fost anulată. Toate plațile de înregistrare a ofertelor de preț au fost returnate.</p>--}}
            {{--</div>--}}


            @if(Session::has('flash_message'))
                <div class="alert a-warning">
                    <p>{{ Session::get('flash_message') }}</p> 
                    @php Session::forget('flash_message') @endphp
                </div> 
            @endif

            <span class="title_page">
				<i></i>
				{{ \Constant::get('CURRENT_AUCTIONS') }}
			</span>

            @if($auctions->count())
                <div class="tab-content">
                    <div class="table-head">
                        <div class="item" data-number="1">
                            <span class="section-title">{{ \Constant::get('ITEM') }}</span>
                        </div>
                        <div class="item" data-number="2">
                            <span class="section-title">{{ \Constant::get('ITEM_CODE') }}</span>
                        </div>
                        <div class="item" data-number="3"><i class="icon_time"></i></div>
                    </div>
                    <div class="table-body">
                        @foreach($auctions as $auction)
                            <a href="{{ setUri(\Request::segment(2) . '/' . $auction['url']) }}" class="product_item">
                                <div class="item item-auction-image" data-number="1">
                                    <div class="img" style="background-image: url('/uploads/auctions/{{ $auction['image'] }}');">
                                        @if($auction->product_type == 2)
                                            <img class="special__label" src="/img/special_{{ $lang }}.png" alt="">
                                        @endif
                                    </div>
                                </div>
                                <div class="item content" data-number="2">
                                    <span class="section-title">{{ \Constant::get('ITEM') }}</span>
                                    <div class="product-description">
                                        <span class="title">{{ $auction["name_$lang"] }}</span>
                                        <p>{{ $auction["name2_$lang"] }}</p>
                                    </div>
                                </div>
                                <div class="item content" data-number="3">
                                    <span class="section-title">{{ \Constant::get('ITEM_CODE') }}</span>
                                    <span class="code">{{ $auction["code"] }}</span>
                                </div>
                                <div class="item content" data-number="4">
                                    <i class="icon_time"></i>
                                    <span class="rate"> {{ bigNumberFormat($auction['bids_count']) }} / {{ bigNumberFormat($auction["total_bid_limit"]) }}</span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="alert _2">
                    <p> {!! html_entity_decode(\Constant::get('SECRET_OFFERS')) !!} </p>
                </div>
            @else
                <div class="alert _2">
                    <p> {{ \Constant::get('NO_AUCTIONS') }}</p>
                </div>
            @endif

        </div>
    </section>
@stop

