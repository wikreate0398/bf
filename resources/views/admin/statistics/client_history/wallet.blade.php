@if($data->count())   
	<table class="table table-bordered">
		<tbody>
		<tr> 
			<th class="nw">Date</th>
			<th class="nw">Transaction Type</th> 
			<th>Auction Code</th> 
			<th>Value, MDL</th>  
		</tr>
		</tbody>
		<tbody>
		@foreach($data as $transaction)
			<tr> 
				<td>{{ $transaction->created_at->format('d.m.Y H:i') }}</td>
				<td>{{ $transaction->type_data->name_en }}</td>
				<td>{{ $transaction->auction->code }}</td>
				<td>
					@if($transaction->type == 'off')
                        <span style="color: red;">-{{ $transaction->price }} LEI</span>
                    @else
                        <span style="color: green;">{{ $transaction->price }} LEI</span>
                    @endif
				</td>
			</tr>
		@endforeach
		</tbody>
	</table>

	{{ $data->appends(request()->input())->links() }} 
@else
	<div class="alert alert-warning">No transactions</div>
@endif