<table>
	<thead>
		<tr>
			<th style="font-weight: bold;">{{ \Constant::get('CREATED_DATE') }}</th>
			<th style="font-weight: bold;">{{ \Constant::get('ITEM') }}</th>
			<th style="font-weight: bold;">{{ \Constant::get('AUCTION_CODE') }}</th>
			<th style="font-weight: bold;">{{ \Constant::get('REG_BID') }}</th>
			<th style="font-weight: bold;">{{ \Constant::get('PAYMENT_METHOD') }}</th>
		</tr>
	</thead> 
	<tbody>
		@foreach($bids as $bid)
			<tr>
				<td>{{ $bid->created_at->format('d.m.Y H:i') }}</td>
				<td>{{ $order->auction["name_$lang"] . "\n" . $order->auction["name2_$lang"] }}</td>
				<td>{{ $order->auction->code }}</td>
				<td>{{ $bid->price }}</td>
				<td>{{ \Constant::get('ELECTRONIC_WALLET')  }}</td>
			</tr>
		@endforeach
	</tbody>
</table>