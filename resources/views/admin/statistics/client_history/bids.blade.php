@if($data->count())   

	 
		 
		<table class="table table-bordered">
			<tbody>
			<tr> 
				<th class="nw">Date</th> 
				<th>Auction Code</th> 
				<th>Offer, MDL</th>  
				<th>Register type</th>
			</tr>
			</tbody>
			<tbody>
				@foreach($data->groupBy('auction.name_en') as $auction_name => $bids)
					<tr>
						<td colspan="4"><h3>{{ $auction_name }}</h3></td>
					</tr>
					@foreach($bids as $bid)
						<tr> 
							<td>{{ $bid->created_at->format('d.m.Y H:i') }}</td>
							 
							<td>{{ $bid->auction->code }}</td>
							<td>{{ $bid->price }} LEI</td>
							<td>Electronic</td>
						</tr>
					@endforeach
				@endforeach
			</tbody>
		</table> 

	{{ $data->appends(request()->input())->links() }} 
@else
	<div class="alert alert-warning">No offers placed</div>
@endif