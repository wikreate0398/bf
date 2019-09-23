@extends('layouts.admin')

@section('content')
<div class="row">
	<div class="col-md-12"> 
		<div class="portlet light bg-inverse"> 

			<div class="portlet-body form">   
 
			<form action="/{{ $method }}/create" class="ajax__submit form-horizontal">  

				{{ csrf_field() }}

				<div class="form-body" style="padding-top: 20px;"> 
					@include('admin.utils.input', ['label' => 'Name', 'name' => 'name'])

					@include('admin.utils.input', ['label' => 'Link', 'name' => 'link']) 

					@include('admin.utils.image', ['inputName' => 'image_top', 'label' => 'Image Top'])

					<!-- @include('admin.utils.image', ['inputName' => 'image_side', 'label' => 'Image Side']) -->

					@include('admin.utils.image', ['inputName' => 'image_background', 'label' => 'Image Background'])

					<hr>
					<table class="table table-bordered">
						<tr>
							<th colspan="2">
								<h4>Pages</h4>
							</th>
						</tr>
						@foreach($menu as $item)
							<tr>
								<td style="width: 40px; white-space: nowrap;">{{ $item->name_en }}</td>
								<td><input type="checkbox" name="pages[{{ $item->id }}]"></td>
							</tr>
						@endforeach
						<tr>
							<th colspan="2">
								<h4>Auctions</h4>
							</th>
						</tr>
						@foreach($auctions as $item)
							<tr>
								<td style="width: 40px; white-space: nowrap;">{{ $item->name_en }}</td>
								<td><input type="checkbox" name="auctions[{{ $item->id }}]"></td>
							</tr>
						@endforeach
					</table>

				</div>
				<div class="form-actions">
					<div class="btn-set pull-left"> 
						<button type="submit" class="btn green">Save</button>
					</div> 
				</div>
			</form> 

		</div>
		</div>
	</div>
</div>
 
@stop