@extends('layouts.admin') 
 
@section('content') 
	
	<form action="">
		<div class="row"> 
			<input type="hidden" name="filter" value="1"> 
			<div class="col-md-3">
				<div class="input-group input-large date-picker input-daterange" data-date-format="dd.mm.yyyy">
					<input type="text" class="form-control" value="{{ request()->from }}" name="from">
					<span class="input-group-addon">
					to </span>
					<input type="text" class="form-control" value="{{ request()->to }}" name="to">
				</div>
			</div>

			<div class="col-md-2">
				<button type="submit" class="btn btn-info">Search</button>
				@if(request()->filter)
					<a href="{{ route('admin_daily_reports') }}" class="btn btn-danger">Reset</a>
				@endif
			</div>  
		</div> 
	</form>
	<br>

	<div class="row">
	 	<div class="col-md-12">
	 		<table class="table table-bordered table-advance table-hover table-striped">
	 			<tr>
	 				<th>DATE</th>
	 				<th>New Account QTY</th>
	 				<th>Products Sold QTY</th>
	 				<th>SALES, Lei</th>
	 				<th>Products Sold VALUE, Lei</th>
	 				<th>BIDS Placed QTY</th>
	 				<th>BIDS Placed Value, Lei</th>
	 				<th>Refunds QTY</th>
	 				<th>Refunds Value</th>
	 				<th>Postal offers QTY</th>
	 				<th>E-Wallet Ballance, Lei</th>
	 			</tr>
	 			@foreach($dates as $k => $date)
					<tr>
						<td>{{ $date }}</td>
						<td align="center">
							{{ @intval($newAccounts[$date]->total) }}
						</td>
						<td align="center">
							{{ @intval($ordersStatistics[$date]->totalQty) }}
						</td>
						<td align="center">
							{{ @priceString($ordersStatistics[$date]->totalPrice, 2) }}
						</td>
						<td align="center">
							{{ @priceString($ordersStatistics[$date]->totalRetailPrice, 2) }}
						</td>
						<td align="center">
							{{ @intval($bidstStatistics[$date]->total) }}
						</td>
						<td align="center">
							{{ @priceString($bidstStatistics[$date]->totalCost, 2) }}
						</td>
						<td align="center">
							{{ @intval($orderRefunds[$date]->totalRefunds) }}
						</td>
						<td align="center">
							{{ @priceString($orderRefunds[$date]->totalPriceRefunds, 2) }}
						</td>
						<td align="center">0</td>
						<td align="center">{{ @priceString($eWallet[$date]->totalBallance, 2) }}</td>
					</tr>
	 			@endforeach
	 		</table>
	 	</div>
	</div>
@stop

