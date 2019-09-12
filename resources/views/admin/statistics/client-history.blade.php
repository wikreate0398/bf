@extends('layouts.admin') 
 
@section('content') 
	
	<form action="">
		<div class="row"> 
			<input type="hidden" name="filter" value="1"> 

			<div class="col-md-3">
				<select name="registry_type" class="form-control" required>
					<option value="0">Registry Type</option>
					<option value="checkout" {{ (request()->registry_type == 'checkout') ? 'selected' : '' }}>
						Checkout
					</option>
					<option value="wallet" {{ (request()->registry_type == 'wallet') ? 'selected' : '' }}>
						Wallet
					</option>
					<option value="bids" {{ (request()->registry_type == 'bids') ? 'selected' : '' }}>
						Bids
					</option>
				</select>
			</div>

			<div class="col-md-3">
				<input type="text" class="form-control" required value="{{ request()->q }}" placeholder="Account ID / E-mail" name="q">
			</div>

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
					<a href="{{ route('admin_client_history') }}" class="btn btn-danger">Reset</a>
				@endif
			</div>  
		</div> 
	</form>
	<br>

	<div class="row">
	 	<div class="col-md-12">
	  		{!! @$view !!}
	 	</div>
	</div>
@stop

