<div class="{{$viewClass['form-group']}}">
	<div class="{{$viewClass['label']}}">
		<div class="layui-form-auto-label {{$viewClass['label_element']}}">
			@include('py-system::tpl.form.help-tip')
			{{$label}}
		</div>
	</div>
	<div class="{{$viewClass['field']}}">
		<div class="layui-form-auto-field">
			<div class="layui-field-display">
				{!! dump($value) !!}
				{!! $value !!}&nbsp;
			</div>
		</div>
		@include('py-system::tpl.form.help-block')
	</div>
</div>