@extends('layouts.admin')

@section('content') 
	<div class="row">
		<div class="col-md-12" style="margin-bottom: 20px;">
			<a href="/{{ $method }}/add/" class="btn btn-primary btn-sm open-area-btn">
				<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Add
			</a> 
		</div>

		 
		<div class="col-md-12">
	 		<form action="" class="row">
				<input type="hidden" name="filter" value="1">
				<div class="col-md-2">
					<input type="text" class="form-control" value="{{ request()->q }}" placeholder="Search..." name="q">
				</div>
 
				<div class="col-md-2">
					<button type="submit" class="btn btn-info">Search</button>
					@if(request()->filter)
						<a href="{{ route('admin_orders_list') }}" class="btn btn-danger">Reset</a>
					@endif
				</div>
			</form>

			<br> 
	 	</div>

		<div class="col-md-12">
			@if($data->count()) 
				<table class="table table-bordered">
					<tbody>
					<tr>
						<th style="width:5%; text-align: center"><i class="fa fa-check-square" aria-hidden="true"></i></th>
						<th class="nw">Name</th>
						<th class="nw">Account Nr</th>
						<th style="width:8%;" class="nw">Ballance, MDL</th> 
						<th style="width:77%;">E-mail</th>  
						<th style="width:5%; text-align: center"><i class="fa fa-cogs" aria-hidden="true"></i></th>
					</tr>
					</tbody>
					<tbody id="sort-items" data-table="{{ $table }}" data-action="{{ route('sortElement') }}">
					@foreach($data as $item)
						<tr id="<?=$item['id']?>">
							<td style="width:5px; white-space: nowrap;">
								<input type="checkbox"
									   class="make-switch" data-size="mini" {{ !empty($item['active']) ? 'checked' : '' }}
									   data-on-text="<i class='fa fa-check'></i>"
									   data-off-text="<i class='fa fa-times'></i>"
									   onchange="Ajax.buttonView(this, '{{ $table }}', '{{ $item["id"] }}', 'active')">
							</td>
							<td class="nw">{{ $item->name }}</td>
							<td class="nw">{{ $item->account_number }}</td>
							<td>{{ $item->ballance }}</td>
							<td>{{ $item->email }}</td>
							<td style="width: 5px; white-space: nowrap">
								<a class="btn btn-xs btn-warning" data-toggle="modal" href="#send_letter_{{ $item['id'] }}">
									<i class="fa fa-envelope" aria-hidden="true"></i>
								</a>

								<div id="send_letter_{{ $item['id'] }}" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
								   <div class="modal-dialog">
								      <div class="modal-content">
								         <div class="modal-header">
								            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
								            <h4 class="modal-title">Send message</h4>
								         </div>
								         <form action="/{{ $method }}/{{ $item['id'] }}/send-letter" class="ajax__submit form-horizontal"> 
									         <div class="modal-body">
									         	{{ csrf_field() }}
									        	@include('admin.utils.input', ['label' => 'Theme', 'req' => true, 'name' => 'theme', 'data' => ['theme' => '☆ ' . config('app.name') . ': New Message']])  
									        	@include('admin.utils.textarea', ['label' => 'Message', 'req' => true, 'name' => 'message'])
									         </div>
									         <div class="modal-footer">
									            <button type="button" data-dismiss="modal" class="btn default">Cancel</button>
									            <button type="submit"  
									                    class="btn green">
									               	Send
									            </button>
									         </div>
								         </form>
								      </div>
								   </div>
								</div>

								<a href="/{{ $method }}/{{ $item['id'] }}/autologin/" target="_blank" class="btn btn-primary btn-xs">
									<i class="fa fa-sign-in" aria-hidden="true"></i>
								</a> 
								<a style="margin-left: 5px;" href="/{{ $method }}/{{ $item['id'] }}/edit/" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>
								<a class="btn btn-danger btn-xs" data-toggle="modal" href="#deleteModal_{{ $table }}_{{ $item['id'] }}"><i class="fa fa-trash-o "></i></a>
								<!-- Modal -->
							@include('admin.utils.delete', ['id' => $item['id'], 'table' => $table])
							<!-- Modal -->
							</td>
						</tr>
					@endforeach
					</tbody>
				</table>
			@else
				<div class="alert alert-warning">No users</div>
			@endif
		</div>
	</div>
@stop

