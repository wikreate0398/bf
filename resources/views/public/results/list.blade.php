@extends('layouts.public')

@section('content')
<section class="results">
		<div class="container" style="min-height: 400px;">

			<h1 class="page_title">{{ \Constant::get('COMPLETED_AUCTIONS_TTL') }}</h1>

		<!-- 	<div class="alert">
				<p> 12.04.2018: Licitația UL13258 a fost anulată. Toate plațile de înregistrare a ofertelor de preț au fost returnate.</p>
			</div> -->
			
			@if($orders->count())
			<div class="tab-content">
				<div class="table-head">
					<div class="item" data-number="1">
						{{ \Constant::get('CODE') }}
					</div>
					<div class="item" data-number="2">
						{{ \Constant::get('ITEM') }}
					</div>
					<div class="item" data-number="3">
						{{ \Constant::get('BUYER_ID') }}
					</div>
					<div class="item" data-number="4">
						{{ \Constant::get('OFFERS_WINNING') }}
					</div>
					<div class="item" data-number="5">
						{{ \Constant::get('REDUCTION_OBTAINED') }}
					</div>
					<div class="item" data-number="6">
						{{ \Constant::get('TABLE_OFFERS') }}
					</div>
				</div>
				<div class="table-body">

					@foreach($orders as $order)  
						<div class="result_item">
							<div class="item" data-number="1">
								<span class="code">{{ $order->auction->code }}</span>
							</div>
							<div class="item" data-number="2">
								<span class="title">{{ $order->auction["name_$lang"] }}</span>
								<p>{{ $order->auction["name2_$lang"] }}</p>
							</div>
							<div class="item" data-number="3">
								<span class="code">{{ $order->user->account_number }}</span>
							</div>
							<div class="item" data-number="4">
								<span class="code">{{ $order->price }} LEI</span>
							</div>
							<div class="item" data-number="5">
								<span class="code">{{ savePercent($order->auction->retail_price, $order->price) }}%</span>
							</div>
							<div class="item" data-number="6">
								<a href="{{ route('results_bids', ['lang' => $lang, 'id_result' => $order->id]) }}">
									<svg class="result_icon" xmlns="http://www.w3.org/2000/svg" width="24.651" height="24.651" viewBox="0 0 24.651 24.651">
										<g id="analytics_1_" data-name="analytics (1)" opacity="0.5">
											<g id="Group_54" data-name="Group 54">
												<g id="Group_53" data-name="Group 53">
													<path id="Path_65" data-name="Path 65" d="M24.17,10.051H21.088a.481.481,0,0,0-.481.481v2.431a.481.481,0,1,0,.963,0v-1.95h2.118V23.688H21.57V16.575a.481.481,0,0,0-.963,0v7.114h-.963V13.722a.481.481,0,0,0-.481-.481H16.081a.481.481,0,0,0-.481.481v9.966h-.963v-6.6a.481.481,0,0,0-.481-.481H11.074a.481.481,0,0,0-.481.481v6.6H9.629V19.855a.481.481,0,0,0-.481-.481H6.067a.481.481,0,0,0-.481.481v3.834H1.444a.482.482,0,0,1-.481-.481V1.444A.482.482,0,0,1,1.444.963H13.865V4.141A1.446,1.446,0,0,0,15.31,5.585h3.178v5.922a.481.481,0,1,0,.963,0V5.1a.482.482,0,0,0-.141-.34L14.687.141A.482.482,0,0,0,14.347,0H1.444A1.446,1.446,0,0,0,0,1.444V23.207a1.446,1.446,0,0,0,1.444,1.444H24.17a.481.481,0,0,0,.481-.481V10.532A.481.481,0,0,0,24.17,10.051ZM14.828,1.644l2.978,2.978h-2.5a.482.482,0,0,1-.481-.481ZM8.666,23.688H6.548V20.336H8.666Zm5.007,0H11.555V17.574h2.118Zm5.007,0H16.563V14.2h2.118Z" fill="#fff"/>
												</g>
											</g>
											<g id="Group_56" data-name="Group 56" transform="translate(20.607 14.198)">
												<g id="Group_55" data-name="Group 55">
													<path id="Path_66" data-name="Path 66" d="M428.822,295.031a.481.481,0,1,0,.141.34A.483.483,0,0,0,428.822,295.031Z" transform="translate(-428 -294.89)" fill="#fff"/>
												</g>
											</g>
											<g id="Group_58" data-name="Group 58" transform="translate(2.581 2.635)">
												<g id="Group_57" data-name="Group 57">
													<path id="Path_67" data-name="Path 67" d="M58.03,54.729a.481.481,0,0,0-.481.481v.866a4.428,4.428,0,1,0,4.884,4.884H63.3a.481.481,0,0,0,.481-.481A5.756,5.756,0,0,0,58.03,54.729Zm0,9.215a3.466,3.466,0,0,1-.481-6.9v3.432a.482.482,0,0,0,.481.481h3.432A3.471,3.471,0,0,1,58.03,63.944ZM58.512,60h0V55.716A4.8,4.8,0,0,1,62.793,60Z" transform="translate(-53.602 -54.729)" fill="#fff"/>
												</g>
											</g>
											<g id="Group_60" data-name="Group 60" transform="translate(2.6 14.167)">
												<g id="Group_59" data-name="Group 59">
													<path id="Path_68" data-name="Path 68" d="M63.678,294.25h-9.2a.481.481,0,1,0,0,.963h9.2a.481.481,0,0,0,0-.963Z" transform="translate(-54 -294.25)" fill="#fff"/>
												</g>
											</g>
											<g id="Group_62" data-name="Group 62" transform="translate(2.6 16.49)">
												<g id="Group_61" data-name="Group 61">
													<path id="Path_69" data-name="Path 69" d="M57.563,342.5H54.481a.481.481,0,1,0,0,.963h3.081a.481.481,0,0,0,0-.963Z" transform="translate(-54 -342.5)" fill="#fff"/>
												</g>
											</g>
											<g id="Group_64" data-name="Group 64" transform="translate(8.093 16.49)">
												<g id="Group_63" data-name="Group 63">
													<path id="Path_70" data-name="Path 70" d="M168.9,342.641a.481.481,0,1,0,.141.34A.485.485,0,0,0,168.9,342.641Z" transform="translate(-168.08 -342.5)" fill="#fff"/>
												</g>
											</g>
										</g>
									</svg>
								</a>
							</div>
						</div>
					@endforeach
 
				</div>
			</div>

			{{ $orders->links() }} 

			@else
				<div class="alert _2">
                    <p>{{ \Constant::get('NO_AUCTIONS') }}</p>
                </div>
			@endif
		</div>
	</section>

	<script>
		$(document).ready(function(){
			setTimeout(function(){
				$("#results").addClass("active");
			}, 500)
		})
	</script>
@stop

