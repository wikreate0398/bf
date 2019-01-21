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
							@include('admin.utils.input', ['label' => 'Name', 'name' => 'name', 'lang' => true, 'data' => $data])
							
							@if($data['alone'] == 0)
								@include('admin.utils.input', ['label' => 'Link', 'req' => true, 'name' => 'url', 'data' => $data, 'help' => 'Without http://www и.т.п just an English phrase, without spaces, reflecting a menu item, for example Our approach - our-approach'])
							@endif

							@include('admin.utils.textarea', ['label' => 'Text', 'name' => 'text', 'ckeditor' => true, 'lang' => true, 'data' => $data])
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