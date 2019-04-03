@extends('layouts.public')

@section('content')
    <section class="product_inner">
        <div class="content">
            <div class="container">
                <a href="#" class="banner" style="background-image: url('/img/licitatii_specifice/banner.png');"></a>

                <div class="prodcts_navigation">
                    @if($prev)
                        <a href="<?=setUri(\Request::segment(2) . '/' . $prev['url'])?>" class="arrow_l">
                            <i></i>
                        </a>
                    @endif

                    <div class="counts_code">
                        <div class="count">{{ $currentIndex }}/{{ $auctions->count() }}</div>
                        <div class="code">{{ $auction['code'] }}</div>
                        <div class="pieces">{{ $auction['bids_count'] }} / {{ bigNumberFormat($auction["total_bid_limit"]) }}</div>
                    </div>

                    @if($next)
                        <a href="{{ setUri(\Request::segment(2) . '/' . $next['url']) }}" class="arrow_r">
                            <i></i>
                        </a>
                    @endif
                </div>

                <div class="product">
                    <div class="row">
                        <div class="col-lg-5 left_part">
                            <img class="main_img" src="/uploads/auctions/{{ $auction['image'] }}" alt="product" />
                            <div class="provider">
                                <span class="title">{{ $auction["name_$lang"] }}</span>
                                <p>{{ $auction["name2_$lang"] }}</p>
                            </div>
                            <p>{{ \Constant::get('COMMERCIAL_PRICE') }} {{ $auction['retail_price'] }} {{ \Constant::get('LEI') }}</p>
                            <div class="adout_product">
                                <span class="title">{{ \Constant::get('ABOUT_PRODUCT') }}</span>
                                <p>{{ $auction["description_$lang"] }}</p>
                            </div>
                        </div>
                        <div class="col-lg-7 rigth_part">
                            <div class="action_block">
                                <div class="price_per_action">
                                    <p>{{ \Constant::get('COST_REG_OFFER') }}</p>
                                </div>
                                <form method="POST" class="ajax__submit" action="{{ setUri(\Request::segment(2) . '/add-bid/' . $auction->id) }}">
                                    {{ csrf_field() }}
                                    @php

                                    @endphp
                                    <div class="{{ ($auctionState->canMakeBids() !== true) ? 'disable__offers' : '' }}">
                                        <div class="offer">
                                            <p>{!! nl2br(\Constant::get('CONS_INC_BIDS')) !!}</p>
                                            @php
                                                $totalBids = 1;
                                                if(Auth::check() && $user->bids->count())
                                                {
                                                    $totalBids = $user->bids->count()+1;
                                                }
                                            @endphp
                                            <input type="text" disabled name="bid" value="{{ $totalBids }}" placeholder="0">
                                        </div>

                                        <div class="submit_offer">
                                            <i class="regulament"></i>
                                            <input type="text" placeholder="0" name="integer" data-number="1">
                                            <span class="dot"></span>
                                            <input type="text" placeholder="0" value="01" name="decimal" data-number="2">
                                            <span class="currency">{{ \Constant::get('LEI') }}</span>
                                            <button type="submit">{{ \Constant::get('ADD_BID') }}</button>
                                        </div>
                                    </div>
                                    @if($auctionState->canMakeBids() !== true)
                                        <div class="alert_warning">
                                            <p>{!! $auctionState->getErrorMessage() !!}</p>
                                        </div>
                                    @endif
                                </form>
                            </div>

                            @if($auction->auction_type == 'classical')
                                @include('public.auction.utils.classical_bids')
                            @else
                                @include('public.auction.utils.specific_bids')
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop

