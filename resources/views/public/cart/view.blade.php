@extends('layouts.public')

@section('content')


    <section class="checkout @if(!$cart) empty @endif">
        <div class="container">

            <a href="#" class="banner" style="background-image: url('/img/licitatii_specifice/banner.png');"></a>

            @if($cart)
                <div class="prodcts_navigation">
                    @if($prev)
                        <a href="{{ route('view_cart', ['lang' => $lang, 'id' => $prev->id]) }}" class="arrow_l">
                            <i></i>
                        </a>
                    @endif

                    <div class="counts_code">
                        <div class="count">{{ $currentIndex }}/{{ $totalItems }}</div>
                        <div class="code">{{ $cart->auction->code }}</div>
                        <div class="pieces"> 
                            <div id="countdown"> 
                                @php
                                    $limit   = $cart->created_at->addDays(2);
                                    $diff    = \Carbon\Carbon::now()->diff($limit);
                                    $hours   = \Carbon\Carbon::now()->diffInHours($limit);
                                     
                                    if($hours){
                                        $dayFormat = strFormat('hours');
                                        $str = $hours . ' ' . format_by_count($hours, $dayFormat[0],$dayFormat[1],$dayFormat[2]);  
                                        echo $str;
                                    } 

                                    if($diff->format('%i')){
                                        $dayFormat = strFormat('minutes');
                                        $str = $diff->format('%i') . ' ' . format_by_count($diff->format('%i'), $dayFormat[0],$dayFormat[1],$dayFormat[2]); 
                                        echo ' ' . $str;
                                    }   
                                @endphp
                            </div>
                        </div>
                    </div>

                    <script> 
                        $(document).ready(function () { 
                            countDown('{{ $limit }}');
                            var hoursFormat   = JSON.parse('<?=json_encode(strFormat('hours'))?>');
                            var minutesFormat = JSON.parse('<?=json_encode(strFormat('minutes'))?>');
                            var secondsFormat = JSON.parse('<?=json_encode(strFormat('seconds'))?>');
                           
                            function format_by_count(count, form1, form2, form3)
                            {
                                count = Math.abs(count) % 100;
                                lcount = count % 10;
                                if (count >= 11 && count <= 19) return(form3);
                                if (lcount >= 2 && lcount <= 4) return(form2);
                                if (lcount == 1) return(form1);
                                return form3;
                            }

                            function countDown(limit){
                                var limit = new Date(limit).getTime(); 
                                // Update the count down every 1 second
                                var x = setInterval(function() {

                                    // Get today's date and time
                                    var now = new Date().getTime();
                                    
                                    // Find the distance between now and the count down date
                                    var distance = limit - now; 

                                    // Time calculations for days, hours, minutes and seconds
                                    //var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                                    var hours   = Math.floor(distance/ (1000 * 60 * 60));
                                    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
  
                                    if (!hours) { 

                                        var str = '';
                                        var space = ' ';
                                        if (hours) {
                                            str += '<span class="cd-hours">'+hours +space+ format_by_count(hours, hoursFormat[0], hoursFormat[1], hoursFormat[2]) + '</span>';
                                        }

                                        if (minutes) {
                                            str += '<span class="cd-minutes">'+minutes +space+ format_by_count(minutes, minutesFormat[0], minutesFormat[1], minutesFormat[2]) + '</span>';
                                        }

                                        if (seconds != null) {
                                            str += '<span class="cd-seconds">'+seconds +space+ format_by_count(seconds, secondsFormat[0], secondsFormat[1], secondsFormat[2]) + '</span>';
                                        }
                                         
                                        document.getElementById("countdown").innerHTML = str; 
                                        // If the count down is over, write some text 
                                        if (!seconds && !minutes && !hours) {
                                            clearInterval(x);
                                            setTimeout(function(){
                                                location.reload();
                                            }, 2000);
                                        }
                                    } 
                                }, 1000);
                            } 
                        });
                    </script>
  
                    @if($next)
                        <a href="{{ route('view_cart', ['lang' => $lang, 'id' => $next->id]) }}" class="arrow_r">
                            <i></i>
                        </a>
                    @endif
                </div>

                <div class="tab-content">
                    <a href="{{ route('delete_cart_item', ['lang' => $lang, 'id' => $cart->id]) }}" 
                       class="cancel confirm-action"
                       data-confirm="Подтвердить операцию"></a>
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

                                    <select name="service" id="" disabled>
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
                        <p>{{ \Constant::get('FILL_CART') }}  </p>
                    </span>
                    <form method="POST" action="{{ route('order', ['lang' => $lang, 'id' => $cart->id]) }}" class="ajax__submit">
                        {{ csrf_field() }}
                        @if($cart->auction->product_type == 2)
                            <div class="form">
                                <h3>{{ \Constant::get('BUYER_DETAILS') }}</h3>
                                <input type="text" required placeholder="{{ field('name') }} *" name="name">
                                <input type="text" required placeholder="{{ field('surname') }} *" name="surname">
                                <input type="text" required placeholder="{{ field('ph_nr') }} *" name="phone">
                            </div>
                        @else
                            <div class="form">
                                <h3>{{ \Constant::get('EVOUCHER_DATE') }} *</h3>
                                <label class="select_provider" for="select_provider">
                                    <select name="provider" id="">
                                        @foreach($providers as $provider)
                                            <option value="{{ $provider->id }}">{{ $provider["name_$lang"] }}</option> 
                                        @endforeach 
                                    </select>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10.984 6.453">
                                        <g id="right-arrow_1_" data-name="right-arrow (1)" transform="translate(10.984 -101.478) rotate(90)">
                                            <g id="Group_12" data-name="Group 12" transform="translate(101.478)">
                                                <path id="Path_12" data-name="Path 12" class="cls-1" d="M107.756,5.063,102.868.175a.6.6,0,0,0-.85,0l-.36.36a.6.6,0,0,0,0,.85l4.1,4.1L101.653,9.6a.6.6,0,0,0,0,.85l.36.36a.6.6,0,0,0,.85,0l4.892-4.892a.606.606,0,0,0,0-.853Z" transform="translate(-101.478)"></path>
                                            </g>
                                        </g>
                                    </svg>
                                </label>
                                <input type="text" placeholder="{{ field('ph_nr') }}" name="phone">
                            </div>
                        @endif


                        <div class="options">
                            <h3>{{ \Constant::get('PAYMENT_METHOD') }} *</h3>
                            <label for="checkbox">
                                <input type="checkbox" name="payment_type" value="wallet" id="checkbox">
                                <span class="checkmark"></span>
                                {{ \Constant::get('ELECTRONIC_WALLET') }}
                            </label>
                            <button type="submit">CUMPARA</button>
                        </div>
                    </form>
                </div>
            @else
                <img src="/img/products/checkout_empty.png" alt="checkout_empty">
                <h3>{{ \Constant::get('EMPTY_CART') }}</h3>
            @endif
        </div>
    </section>
@stop

