<div class="{{$viewClass['form-group']}} {!! (isset($errors) && !$errors->has($errorKey)) ? '' : 'has-error' !!}">

	<div class="{{$viewClass['label']}}">
		<label for="{{$id}}" class="layui-form-auto-label {{$viewClass['label_element']}}">
			@include('py-system::tpl.form.help-tip')
			{{$label}}
		</label>
	</div>

	<div class="{{$viewClass['field']}}">

		<select class="form-control {{$class}}" style="width: 100%;" name="{{$name}}[]" multiple="multiple"
			data-placeholder="{{ $placeholder }}" {!! $attributes !!} >
			@foreach($options as $select => $option)
				<option value="{{$select}}" {{  in_array($select, (array)old($column, $value)) ?'selected':'' }}>{{$option}}</option>
			@endforeach
		</select>
		<input type="hidden" name="{{$name}}[]"/>
		@include('py-system::tpl.form.help-block')
		@include('py-system::tpl.form.error')
	</div>
</div>
