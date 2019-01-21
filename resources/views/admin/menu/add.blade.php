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
 
			<form action="/{{ $method }}/create" class="ajax__submit form-horizontal">  

				{{ csrf_field() }}

				<div class="form-body" style="padding-top: 20px;"> 
					<div class="tab-content">
						<div class="tab-pane active" id="tab_1"> 
							@include('admin.utils.input', ['label' => 'Name', 'lang' => true, 'name' => 'name'])

							@include('admin.utils.input', ['label' => 'Link', 'req' => true, 'name' => 'url', 'help' => 'Without http://www и.т.п just an English phrase, without spaces, reflecting a menu item, for example Our approach - our-approach'])

							@include('admin.utils.textarea', ['label' => 'Text', 'lang' => true, 'name' => 'text', 'ckeditor' => true])
						</div>
					 
						<div class="tab-pane" id="tab_2">
							@include('admin.utils.input', ['label' => 'Title', 'lang' => true, 'name' => 'seo_title'])

							@include('admin.utils.textarea', ['label' => 'Description', 'lang' => true, 'name' => 'seo_description'])

							@include('admin.utils.input', ['label' => 'Keywords', 'lang' => true, 'name' => 'seo_keywords'])
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