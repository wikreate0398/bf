@extends('layouts.admin')

@section('content')
<div class="row">
	<div class="col-md-12"> 
	 <div class="portlet light bg-inverse">
 
			<div class="portlet-body form">  
 
				<form action="/{{ $method }}/{{ $data['id'] }}/update" class="ajax__submit form-horizontal">  

					{{ csrf_field() }}
					
					<div class="form-body" style="padding-top: 20px;"> 
						@include('admin.utils.input', ['label' => 'Name', 'name' => 'name', 'data' => $data])

						@include('admin.utils.image', [
						'inputName' => 'image_top',
						'table' => $table, 
						'folder' => $folder,
						'id' => $data['id'],
						'label' => 'Image Top',
						'filename' => $data['image_top']])

						@include('admin.utils.image', [
						'inputName' => 'image_side',
						'table' => $table,
						'folder' => $folder,
						'id' => $data['id'],
						'label' => 'Image Side',
						'filename' => $data['image_side']])

						@include('admin.utils.image', [
						'inputName' => 'image_background',
						'table' => $table,
						'folder' => $folder,
						'id' => $data['id'],
						'label' => 'Image Background',
						'filename' => $data['image_background']])

						<hr>
						<table class="table table-bordered">
							<tr>
								<th colspan="2">
									<h4>Pages</h4>
								</th>
							</tr>
							@php $banner_pages = $data->banner_pages->groupBy('type') @endphp
							@foreach($menu as $item)
								@php
									$ids = [];
									if(!empty($banner_pages['page'])){
										$ids = $banner_pages['page']->pluck('id_page')->toArray();
									}
							    @endphp
								<tr>
									<td style="width: 40px; white-space: nowrap;">{{ $item->name_en }}</td>
									<td><input {{ in_array($item->id, $ids) ? 'checked' : '' }} type="checkbox" name="pages[{{ $item->id }}]"></td>
								</tr>
							@endforeach
							<tr>
								<th colspan="2">
									<h4>Auctions</h4>
								</th>
							</tr>
							@foreach($auctions as $item)
								@php
									$ids = [];
									if(!empty($banner_pages['product'])){
										$ids = $banner_pages['product']->pluck('id_page')->toArray();
									}
								@endphp
								<tr>
									<td style="width: 40px; white-space: nowrap;">{{ $item->name_en }}</td>
									<td><input {{ in_array($item->id, $ids) ? 'checked' : '' }} type="checkbox" name="auctions[{{ $item->id }}]"></td>
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