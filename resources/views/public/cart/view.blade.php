@extends('layouts.public')

@section('content')


    <section class="checkout @if(!$cart) empty @endif">
        <div class="container">

            <a href="#" class="banner" style="background-image: url('/img/licitatii_specifice/banner.png');"></a>

            @if($cart)
                <div class="prodcts_navigation">
                    @if($prev)
                        <a href="{{ route('cart_view', ['lang' => $lang, 'url' => $prev->auction->url]) }}" class="arrow_l">
                            <i></i>
                        </a>
                    @endif

                    <div class="counts_code">
                        <div class="count">{{ $currentIndex }}/{{ $totalItems }}</div>
                        <div class="code">{{ $cart->auction->code }}</div>
                        <div class="pieces">
                            @php
                                $limit   = $cart->created_at->addDays(2);
                                $hours   = \Carbon\Carbon::now()->diffInHours($limit);
                                $minutes = \Carbon\Carbon::now()->diffInMinutes($limit);
                                if($hours){
                                    echo $hours . ' ' . \Constant::get('HOURS_LEFT');
                                }else{
                                    echo $minutes . ' ' . \Constant::get('MIN_LEFT');
                                }
                            @endphp
                        </div>
                    </div>

                    @if($next)
                        <a href="{{ route('cart_view', ['lang' => $lang, 'url' => $next->auction->url]) }}" class="arrow_r">
                            <i></i>
                        </a>
                    @endif
                </div>

                <div class="tab-content">
                    <a href="{{ route('delete_cart_item', ['lang' => $lang, 'id' => $cart->id]) }}" class="cancel"></a>
                    <div class="table-head">
                        <div class="item" data-number="1">{{ \Constant::get('ITEM') }}</div>
                        <div class="item" data-number="2">{{ \Constant::get('QTY') }}</div>
                        <div class="item" data-number="3">Cost</div>
                    </div>
                    <div class="table-body">
                        <div class="result_item">
                            <div class="item" data-number="1">
                                <div class="img" style="background-image: url('/uploads/auctions/{{ $cart->auction['image'] }}');">
                                    @if($cart->auction->product_type == 2)
                                        <img class="special__label" src="/img/special_{{ $lang }}.png" alt="">
                                    @endif
                                </div>
                            </div>
                            <div class="item content" data-number="2">
                                <span class="section-title">{{ \Constant::get('ITEM') }}</span>
                                <div class="product-description">
                                    <span class="title">{{ $cart->auction["name_$lang"] }}</span>
                                    <p>{{ $cart->auction["name2_$lang"] }}</p>
                                </div>
                            </div>
                            <div class="item content" data-number="3">
                                <span class="section-title">{{ \Constant::get('QTY') }}</span>
                                <label for="">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10.984 6.453">
                                        <g id="right-arrow_1_" data-name="right-arrow (1)" transform="translate(10.984 -101.478) rotate(90)">
                                            <g id="Group_12" data-name="Group 12" transform="translate(101.478)">
                                                <path id="Path_12" data-name="Path 12" class="cls-1" d="M107.756,5.063,102.868.175a.6.6,0,0,0-.85,0l-.36.36a.6.6,0,0,0,0,.85l4.1,4.1L101.653,9.6a.6.6,0,0,0,0,.85l.36.36a.6.6,0,0,0,.85,0l4.892-4.892a.606.606,0,0,0,0-.853Z" transform="translate(-101.478)"></path>
                                            </g>
                                        </g>
                                    </svg>

                                    <select name="service" id="">
                                        <option value="1" selected>1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </label>
                            </div>
                            <div class="item content" data-number="4">
                                <span class="section-title">{{ \Constant::get('TOTAL') }}</span>
                                <span class="price">{{ $cart['price'] }}</span>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="buy_product_block">
                    <span class="head_title">
                        <p>COMPLETATI cu atentie cartela produsului!</p>
                    </span>
                    <form action="">
                        @if($cart->auction->product_type == 2)
                            <div class="form">
                                <h3>Date de contact ale CUMPARATORULUI</h3>
                                <input type="text" placeholder="Nume" name="">
                                <input type="text" placeholder="Prenume" name="">
                                <input type="text" placeholder="Telefon" name="">
                                <div class="id_code">
                                    <i title="Cod de identificare"></i>
                                    <p>Cod de identificare</p>
                                    <input type="text" name="">
                                </div>
                            </div>
                        @else
                            <div class="form">
                                <h3>Date e-Voucher</h3>
                                <label class="select_provider" for="select_provider">
                                    <select name="" id="">
                                        <option value="Orange" selected>Orange</option>
                                        <option value="Moldcell">Moldcell</option>
                                        <option value="Unite">Unite</option>
                                    </select>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10.984 6.453">
                                        <g id="right-arrow_1_" data-name="right-arrow (1)" transform="translate(10.984 -101.478) rotate(90)">
                                            <g id="Group_12" data-name="Group 12" transform="translate(101.478)">
                                                <path id="Path_12" data-name="Path 12" class="cls-1" d="M107.756,5.063,102.868.175a.6.6,0,0,0-.85,0l-.36.36a.6.6,0,0,0,0,.85l4.1,4.1L101.653,9.6a.6.6,0,0,0,0,.85l.36.36a.6.6,0,0,0,.85,0l4.892-4.892a.606.606,0,0,0,0-.853Z" transform="translate(-101.478)"></path>
                                            </g>
                                        </g>
                                    </svg>
                                </label>
                                <input type="text" placeholder="Telefon" name="">
                            </div>
                        @endif


                        <div class="options">
                            <h3>Optiuni de achitare</h3>
                            <label for="checkbox">
                                <input type="checkbox" id="checkbox">
                                <span class="checkmark"></span>
                                Portofel electronic
                            </label>
                            <button type="submit">CUMPARA</button>
                        </div>
                    </form>
                </div>
            @else
                <img src="/img/products/checkout_empty.png" alt="checkout_empty">
                <h3>La moment nu sunt produse in cos.</h3>
            @endif
        </div>
    </section>
@stop

