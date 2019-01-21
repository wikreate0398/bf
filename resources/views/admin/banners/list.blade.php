@extends('layouts.admin')
@function ( catList($menu, $method, $table) )
	@foreach ($menu as $item)
		@php
			$image = '';
			if(!empty($item->image_top)){
				$image = $item->image_top;
			} elseif (!empty($item->image_side)){
				$image = $item->image_side;
			} elseif (!empty($item->image_background)){
				$image = $item->image_background;
			}
		@endphp
		<div class="col-sm-12 col-md-3 thumbnail__item">
			<div class="thumbnail">
				<img src="/uploads/banners/{{ $image }}" alt="" style="width: 100%; height: 200px;">
				<div class="caption">
					<h3>{{ $item->name }}</h3>

					<p>
						<input type="checkbox"
							   class="make-switch" data-size="mini" {{ !empty($item['view']) ? 'checked' : '' }}
							   data-on-text="<i class='fa fa-check'></i>"
							   data-off-text="<i class='fa fa-times'></i>"
							   onchange="Ajax.buttonView(this, '{{ $table }}', '{{ $item["id"] }}', 'view')">
							<a style="margin-left: 5px;" href="/{{ $method }}/{{ $item['id'] }}/edit/" class="btn btn-primary btn-xs"><i class="fa fa-pencil" aria-hidden="true"></i>
								 Edit</a>
							<a class="btn btn-danger btn-xs" data-toggle="modal" href="#deleteModal_{{ $table }}_{{ $item['id'] }}"><i class="fa fa-trash-o" aria-hidden="true"></i>
								 Delete</a>
							<!-- Modal -->
						@include('admin.utils.delete', ['id' => $item['id'], 'table' => $table])
						<!-- Modal -->
					</p>
				</div>
			</div>
		</div>
	@endforeach
@endfunction
 
@section('content') 
	<div class="row">
		<div class="col-md-12" style="margin-bottom: 20px;">
			<a href="/{{ $method }}/add/" class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Add</a>
		</div>

        @catList($data, $method, $table)
	</div>
@stop

