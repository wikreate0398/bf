@extends('layouts.admin') 

@section('content')
<form action="">
	<div class="row"> 
		<input type="hidden" name="filter" value="1">
		<div class="col-md-2">
			<input type="text" class="form-control" value="{{ request()->q }}" placeholder="Search..." name="q">
		</div>

		<div class="col-md-2">
			<select name="status" class="form-control">
				<option value="0">Status</option>
				@foreach($status as $item)
					<option value="{{ $item->id }}" {{ (request()->status == $item->id) ? 'selected' : '' }}>
						{{ $item->name_en }}
					</option>
				@endforeach
			</select>
		</div>

		<div class="col-md-2">
			<select name="client" class="form-control">
				<option value="0">Clients</option>
				@foreach($clients as $client)
					<option value="{{ $client->id }}" {{ (request()->client == $client->id) ? 'selected' : '' }}>
						{{ $client->name }}
					</option>
				@endforeach
			</select>
		</div>

		<div class="col-md-2">
			<select name="auction_type" class="form-control">
				<option value="0">Auction type	</option>
				<option value="classical" {{ (request()->auction_type == 'classical') ? 'selected' : '' }}>
					Classical
				</option>
				<option value="specific" {{ (request()->auction_type == 'specific') ? 'selected' : '' }}>
					Specific
				</option>
			</select>
		</div>

		<div class="col-md-3">
			<div class="input-group input-large date-picker input-daterange" data-date-format="dd.mm.yyyy">
				<input type="text" class="form-control" value="{{ request()->from }}" name="from">
				<span class="input-group-addon">
				to </span>
				<input type="text" class="form-control" value="{{ request()->to }}" name="to">
			</div>
		</div>

		<div class="col-md-1">
			<button type="submit" class="btn btn-info">Search</button>
			@if(request()->filter)
				<a href="{{ route('admin_orders_list') }}" class="btn btn-danger">Reset</a>
			@endif
		</div>  
	</div> 
	</form>
	<br>

	<div class="row">
		<div class="col-md-12">
			@if($data->count())   
				<table class="table table-bordered">
					<tbody>
					<tr>
						<th class="nw">ID</th>
						<th class="nw">Date</th>
						<th class="nw">Account Nr</th>
						<th>Product</th> 
						<th>Auction type</th> 
						<th>Value, MDL</th>
						<th>Delivery</th>
						<th>Status</th>
						<!-- <th style="width:5%; text-align: center"><i class="fa fa-cogs" aria-hidden="true"></i></th> -->
					</tr>
					</tbody>
					<tbody>
					@foreach($data as $order)
						<tr class="{{ $order->open ? 'open-order' : '' }}"> 
							<td class="nw">
								{{ $order->rand }}
							</td>	
							<td class="nw">{{ $order->ordered_at->format('d.m.Y H:i') }}</td>
							<td class="nw">
								<a href="{{ route('admin_clients') }}/{{ $order->user->id }}/edit" target="_blank">{{ $order->user->account_number }}</a>
							</td> 
							<td>{{ $order->auction->name_en }}</td>
							<td>
								{{ ucfirst($order->auction->auction_type) }}
							</td>
							<td class="nw">
								{{ $order->price*$order->qty }}
							</td>
							<td>
								{{ $order->user->name }}
									<br>
								@if($order->id_provider)
			                        {{ $order->provider_data->name_en }}
			                        <br>
			                    @endif
								
			                    @if($order->phone)
			                        {{ $order->phone }}
			                    @endif 
							</td>
							<td> 
								<select onchange="onChangeSelect(this, '{{ route('change_order_status', ['id' => $order->id]) }}', {{ $order->id }})" class="form-control">
									@foreach($status as $item)
										<option {{ ($order->id_status == $item->id) ? 'selected' : '' }} 
											    value="{{ $item->id }}">
											{{ $item->name_en }}
										</option>
									@endforeach
								</select>
								<small class="refund-date {{ $order->status->class }}"
									   style="{{ ($order->id_status == 3 && $order->refund_at) ? '' : 'display:none;' }}">
									{{ $order->refund_at ? $order->refund_at->format('d.m.Y H:i') : '' }}
								</small> 
							</td>
							<!-- <td style="width: 5px; white-space: nowrap">  
								<a class="btn btn-danger btn-xs" data-toggle="modal" href="#deleteModal_{{ $table }}_{{ $order['id'] }}"><i class="fa fa-trash-o "></i></a> 
								@include('admin.utils.delete', ['id' => $order['id'], 'table' => $table]) 
							</td> -->
						</tr>
					@endforeach
					</tbody>
				</table>
			@else
				<div class="alert alert-warning">No orders</div>
			@endif
		</div>
	</div>
@stop

