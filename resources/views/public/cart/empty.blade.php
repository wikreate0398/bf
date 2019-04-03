@extends('layouts.public')

@section('content')
    <section class="checkout empty">
        <div class="container">
            <a href="#" class="banner" style="background-image: url('/img/licitatii_specifice/banner.png');"></a>
            <img src="/img/products/checkout_empty.png" alt="checkout_empty">
            <h3>{{ \Constant::get('EMPTY_CART') }}</h3>
        </div>
    </section>
@stop

