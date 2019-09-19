@if(!empty($banner->image_top))
    <a @if($banner->link) href="{{ $banner->link }}" target="_blank" @endif class="banner" style="background-image: url('/uploads/banners/{{ $banner->image_top }}');"></a>
@endif