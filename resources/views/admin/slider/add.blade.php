@extends('layouts.admin')

@section('content')
<div class="row">
	<div class="col-md-12"> 
		<div class="portlet light bg-inverse"> 

			<div class="portlet-title actions_float_none">
	             
	            @include('admin.utils.language_switcher') 
	         </div>
 
			<div class="portlet-body form">   
 
			<form action="/{{ $method }}/create" class="ajax__submit form-horizontal">  

				{{ csrf_field() }}

				<div class="form-body" style="padding-top: 20px;"> 
					@include('admin.utils.input', ['label' => 'Заголовок', 'lang' => true, 'name' => 'name'])
 
					@include('admin.utils.textarea', ['label' => 'Описание', 'lang' => true, 'name' => 'description'])

					@include('admin.utils.image', ['inputName' => 'image'])
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