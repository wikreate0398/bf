@extends('layouts.public')

@section('content')
    <section class="checkout">
        <div class="container">
            <a href="#" class="banner" style="background-image: url('/img/licitatii_specifice/banner.png');"></a>
            <div class="alert alert-success">
                {{ \Constant::get('SUCCESS_ORDERED') }}  
            </div>
        </div>
    </section>
@stop

