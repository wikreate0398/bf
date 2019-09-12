@extends('layouts.admin')

@section('content')
<div class="row">
	<div class="col-md-12"> 
	 <div class="portlet light bg-inverse"> 

			<div class="portlet-title actions_float_none">
	        
	            @include('admin.utils.language_switcher') 
	         </div>
 
			<div class="portlet-body form">  
 
				<form action="/{{ $method }}/{{ $data['id'] }}/update" class="ajax__submit form-horizontal">  

					{{ csrf_field() }}
					
					<div class="form-body" style="padding-top: 20px;"> 
						@include('admin.utils.input', ['label' => 'Name', 'name' => 'name', 'lang' => true, 'data' => $data])
  
						@include('admin.utils.textarea', ['label' => 'Message', 'lang' => true, 'name' => 'message', 'data' => $data])
						<div class="form-group"> 
							<div class="col-md-12">
								<div class="alert alert-info">
									Defines <code>{NAME}</code> <code>{ORDER_ID}</code>
								</div>
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