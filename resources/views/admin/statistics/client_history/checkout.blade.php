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
					<span class="{{ $order->status->class }}">{{ $order->status->name_en }}</span>
					<small class="refund-date {{ $order->status->class }}"
						   style="{{ ($order->id_status == 3 && $order->refund_at) ? '' : 'display:none;' }}">
						{{ $order->refund_at ? $order->refund_at->format('d.m.Y H:i') : '' }}
					</small> 
				</td>
			</tr>
		@endforeach
		</tbody>
	</table>
@else
	<div class="alert alert-warning">No orders</div>
@endif