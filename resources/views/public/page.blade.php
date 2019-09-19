@extends('layouts.public')

@section('content')
    <section class="text_container">
        <div class="container"> 
        	@include('public.utils.top_banner')
        	@if($banner['image_top']) <br> @endif 
            <div class="row">
                <h1 class="page_title">{{ $page_data["name_$lang"] }}</h1>
                {!! $page_data["text_$lang"] !!}
            </div>
        </div>
    </section>
@stop

