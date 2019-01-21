@extends('layouts.admin')

@section('content')
<div class="row">
	<div class="col-md-12"> 
	 <div class="portlet light bg-inverse"> 

			<div class="portlet-title">
	            <div class="caption">
	               <span class="caption-subject font-red-sunglo bold uppercase"> </span> 
	               <div class="tabbable-line">
	                  <ul class="nav nav-tabs" >
							<li class="active">
								<a href="#tab_1" data-toggle="tab">
									General </a>
							</li> 
							<li class="">
								<a href="#tab_2" data-toggle="tab">
									Seo </a>
							</li> 
						</ul> 
	               </div>
	            </div>
	            @include('admin.utils.language_switcher') 
	         </div>

			<div class="portlet-body form">
			 
 
			<form action="/{{ $method }}/{{ $data['id'] }}/update" class="ajax__submit form-horizontal">  

				{{ csrf_field() }}
				
				<div class="form-body" style="padding-top: 20px;"> 
					<div class="tab-content">
						<div class="tab-pane active" id="tab_1">
							@include('admin.utils.input', ['label' => 'Name', 'lang' => true, 'name' => 'name', 'req' => true, 'data' => $data])

							@include('admin.utils.input', ['label' => 'Link', 'data' => $data, 'name' => 'url', 'help' => 'Without http://www и.т.п just an English phrase, without spaces, reflecting a menu item, for example Our approach - our-approach'])

							@include('admin.utils.textarea', ['label' => 'Description', 'data' => $data, 'lang' => true, 'name' => 'description'])

							<div class="form-group">
								<label class="col-md-12 control-label">Auction Type: <span class="req">*</span>
								</label>
								<div class="col-md-12">
									<select class="form-control" name="auction_type">
										<option value="0">Select...</option>
										@foreach($auction_types as $item)
											<option {{ ($data->auction_type == $item->key) ? 'selected' : '' }} value="{{ $item['key'] }}">{{ $item["name_en"] }}</option>
										@endforeach
									</select>
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-12 control-label">Product Type: <span class="req">*</span>
								</label>
								<div class="col-md-12">
									<select class="form-control" name="product_type">
										<option value="0">Select...</option>
										@foreach($product_types as $item)
											<option {{ ($data->product_type == $item->id) ? 'selected' : '' }} value="{{ $item['id'] }}">{{ $item["name_en"] }}</option>
										@endforeach
									</select>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-12">Code</label>
								<div class="col-md-12">
									<input type="text" class="form-control" name="" value="{{ $data->code }}" readonly>
								</div>
							</div>

							<div class="row">
								<div class="col-md-3">
									@include('admin.utils.input', [
										'label' => '<i class="fa fa-money" aria-hidden="true"></i> Retail value, MDL',
										'name' => 'retail_price',
										'attributes' => ['class' => 'rp'],
										'data' => $data
									])
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label class="control-label col-md-12"><i class="fa fa-clock-o" aria-hidden="true"></i> Bid limit</label>
										<div class="col-md-12">
											<div class="input-group input-medium date date-picker" data-date="{{ date('d.m.Y', strtotime($data->bid_limit_date)) }}" data-date-format="dd.mm.yyyy" data-date-viewmode="years">
												<input type="text" class="form-control" name="bid_limit_date" value="{{ date('d.m.Y', strtotime($data->bid_limit_date)) }}" readonly>
												<span class="input-group-btn">
													<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
													</span>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label class="control-label col-md-12"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Stock quantity</label>
										<div class="col-md-12">
											<div class="spiner__3">
												<div class="input-group">
													<input type="text" name="quantity" value="{{ $data->quantity }}" class="spinner-input form-control" maxlength="1000000000">
													<div class="spinner-buttons input-group-btn">
														<button type="button" class="btn spinner-up default">
															<i class="fa fa-angle-up"></i>
														</button>
														<button type="button" class="btn spinner-down default">
															<i class="fa fa-angle-down"></i>
														</button>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label class="control-label col-md-12"><i class="fa fa-clock-o" aria-hidden="true"></i> <i class="fa fa-users" aria-hidden="true"></i> Bid Limit</label>
										<div class="col-md-12">
											<div class="spiner__3">
												<div class="input-group">
													<input type="text" name="bid_limit_people" class="spinner-input form-control" maxlength="1000000000" value="{{ $data->bid_limit_people }} ">
													<div class="spinner-buttons input-group-btn">
														<button type="button" class="btn spinner-up default">
															<i class="fa fa-angle-up"></i>
														</button>
														<button type="button" class="btn spinner-down default">
															<i class="fa fa-angle-down"></i>
														</button>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

							@include('admin.utils.image', [
								'inputName' => 'image',
								'table' => $table,
								'folder' => 'auctions',
								'id' => $data['id'],
								'filename' => $data['image']])
						</div>
					 
						<div class="tab-pane" id="tab_2">
							@include('admin.utils.input', ['label' => 'Title', 'name' => 'seo_title', 'lang' => true, 'data' => $data])

							@include('admin.utils.textarea', ['label' => 'Description', 'name' => 'seo_description', 'lang' => true, 'data' => $data])

							@include('admin.utils.input', ['label' => 'Keywords', 'name' => 'seo_keywords', 'lang' => true, 'data' => $data])
						</div>
					</div> 
				</div>
				<div class="form-actions">
					<div class="btn-set pull-left"> 
						<button type="submit" class="btn green">Save</button>
					</div> 
				</div>
			</form>
		</div>
	</div>
	</div>
</div>
 
@stop