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
						@include('admin.utils.input', ['label' => 'Название', 'name' => 'name', 'lang' => true, 'data' => $data]) 

						@include('admin.utils.textarea', ['label' => 'Описание', 'name' => 'description', 'lang' => true, 'data' => $data])

						@include('admin.utils.image', [
						'inputName' => 'image', 
						'table' => $table, 
						'folder' => 'slider', 
						'id' => $data['id'], 
						'filename' => $data['image']])
					</div>
					<div class="form-actions">
						<div class="btn-set pull-left"> 
							<button type="submit" class="btn green">Сохранить</button> 
						</div> 
					</div>
				</form>
			</div>
	</div>
	</div>
</div>
 
@stop