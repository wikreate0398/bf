@extends('layouts.admin')

@section('content') 
	<div class="row">
		<div class="col-md-12" style="margin-bottom: 20px;">
			<a href="/{{ $method }}/add/" class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Add</a>
		</div>

	   	<div class="col-md-12">  
			@if($data->count())


					<table class="table table-bordered">
						<tbody>
							<tr>
								<th style="width:5%;"></th>
								<th style="width:5%; text-align: center"><i class="fa fa-eye"></i></th>
								<th class="nw">Auction ID</th>
								<th style="width:85%;">Product Name</th>
								<th class="nw">Stock Left</th>
								<th class="nw">Stock Sold</th>
								<th style="width:5%;"><i class="fa fa-cogs" aria-hidden="true"></i></th>
							</tr>
						</tbody>
						<tbody id="sort-items" data-table="{{ $table }}" data-action="{{ route('depth_sort') }}">
							@foreach($data as $item)
								<tr id="<?=$item['id']?>">
									<td style="width:50px; text-align:center;" class="handle"> </td>
									<td style="width:5px;">
										<input type="checkbox"
											   class="make-switch" data-size="mini" {{ !empty($item['view']) ? 'checked' : '' }}
											   data-on-text="<i class='fa fa-check'></i>"
											   data-off-text="<i class='fa fa-times'></i>"
											   onchange="Ajax.buttonView(this, '{{ $table }}', '{{ $item["id"] }}', 'view')">
									</td>
									<td><span class="badge badge-warning">{{ $item->code }}</span></td>
									<td>{{ $item->name_en }}</td>
									<td class="nw"></td>
									<td class="nw"></td>
									<td style="width: 5px; white-space: nowrap">
										<a style="margin-left: 5px;" href="/{{ $method }}/{{ $item['id'] }}/edit/" class="btn btn-primary btn-xs">Edit</a>
										<a class="btn btn-danger btn-xs" data-toggle="modal" href="#deleteModal_{{ $table }}_{{ $item['id'] }}">Delete</a>
										<!-- Modal -->
									@include('admin.utils.delete', ['id' => $item['id'], 'table' => $table])
									<!-- Modal -->
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
			@else
				<div class="alert alert-warning">No auctions</div>
			@endif
	   	</div>
	</div>
@stop

