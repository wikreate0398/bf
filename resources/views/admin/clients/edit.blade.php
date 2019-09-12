@extends('layouts.admin')

@section('content')
<div class="row">
	<div class="col-md-12"> 
		<div class="portlet light bg-inverse"> 
			<div class="portlet-body form"> 
		<div class="tabbable-line">   
			<form action="/{{ $method }}/{{ $data['id'] }}/update" class="ajax__submit form-horizontal">  

				{{ csrf_field() }}
				
				<div class="form-body" style="padding-top: 20px;"> 
					<div class="tab-content">

						@include('admin.utils.input', ['label' => 'Name', 'req' => true, 'name' => 'name', 'data' => $data]) 
						@include('admin.utils.input', ['label' => 'E-mail', 'req' => true, 'name' => 'email', 'data' => $data]) 
						@include('admin.utils.input', ['label' => 'New Password', 'name' => 'password', 'type' => 'password', 'data' => []])
						@include('admin.utils.input', ['label' => 'Repeat Password', 'name' => 'repeat_password', 'type' => 'password'])

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
</div>
 
@stop