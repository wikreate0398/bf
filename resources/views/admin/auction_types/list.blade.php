@extends('layouts.admin')
@function ( catList($menu, $method, $table) )
	@foreach ($menu as $item)  
    <li class="dd-item dd3-item" data-id="{{ $item['id'] }}">
	       <div class="dd-handle dd3-handle handle "></div>
	       <div class="dd3-content clearfix">
	          	<p style="float:left; margin:0 !important;" class="no-drag">   
	            	{{ $item['name_en'] }}
	          	</p>
	          	<p style="float:right; margin:0 !important;"> 
	          		<input type="checkbox" 
	          		       class="make-switch" data-size="mini" {{ !empty($item['view']) ? 'checked' : '' }} 
	          		       data-on-text="<i class='fa fa-check'></i>" 
	          		       data-off-text="<i class='fa fa-times'></i>" 
	          		       onchange="Ajax.buttonView(this, '{{ $table }}', '{{ $item["id"] }}', 'view')"> 
	             	<a style="margin-left: 5px;" href="/{{ $method }}/{{ $item['id'] }}/edit/" class="btn btn-primary btn-xs">Edit</a>
	             	{{--<a class="btn btn-danger btn-xs" data-toggle="modal" href="#deleteModal_{{ $table }}_{{ $item['id'] }}">Delete</a>--}}
	            	<!-- Modal -->
	            		@include('admin.utils.delete', ['id' => $item['id'], 'table' => $table])
	           		<!-- Modal --> 
	          	</p>   
	       </div>
	        @if(!empty($item['childs']))  
	           	<ol class="dd-list">
	             	@catList($item['childs'], $method, $table)
	           	</ol>
	        @endif
	    </li>
	@endforeach
@endfunction
 
@section('content') 
	<div class="row">
		<div class="col-md-12" style="margin-bottom: 20px;">
			<a href="/{{ $method }}/add/" class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Add</a>
		</div>

	   	<div class="col-md-12">  
	      	<div class="dd nestable" data-table="{{ $table }}" data-action="{{ route('depth_sort') }}">
	        	<ol class="dd-list">  
               	@catList(map_tree($data->toArray()), $method, $table) 
	        	</ol>
	      	</div> 
	   	</div>
	</div>
@stop

