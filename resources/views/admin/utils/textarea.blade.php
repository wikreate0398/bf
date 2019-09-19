@if(empty($lang))
<div class="form-group">
	<label class="control-label col-md-12">{{ $label }} {!! @$req ? '<span class="req">*</span>' : '' !!}</label> 
	<div class="col-md-12"> 
		<textarea name="{{ $name }}" class="form-control {{ !empty($ckeditor) ? 'ckeditor' : '' }}">{{ !empty($data[@$name]) ? $data[@$name] : '' }}</textarea>
		@if(!empty($help))
			<span class="help-block">{{ $help }}</span>
		@endif
	</div>
</div>
@else
	
	@foreach(Language::get() as $key => $language)
		<div class="form-group lang-area" id="field_{{ $language['short'] }}">
			<label class="control-label col-md-12">{{ $label }} {{ @$req ? '<span class="req">*</span>' : '' }}</label>
			<div class="col-md-12">  

			        <textarea name="{{ $name }}[{{$language['short']}}]" 
			                  class="form-control {{ !empty($ckeditor) ? 'ckeditor' : '' }}">{{ !empty($data[@$name.'_'.$language['short']]) ? $data[@$name.'_'.$language['short']] : '' }}</textarea>


				@if(!empty($help))
					<span class="help-block">{{ $help }}</span>
				@endif

				@if(!empty($const))
					<div class="alert alert-info" style="margin-top: 15px;">
						@foreach($const as $key => $value)
							<code>{<?=$value?>}</code>
						@endforeach 
					</div>
				@endif
			</div>
		</div>
	@endforeach

@endif