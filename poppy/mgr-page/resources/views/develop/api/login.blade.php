@extends('py-mgr-page::tpl.develop')
@section('develop-main')
    <div class="row">
        <div class="col-sm-12">
            {!! Form::open([ 'id'=> 'form_auto','data-ajax'=>"true"]) !!}
            {!! Form::hidden('guard', $type) !!}
            <div class="layui-form-item">
                <label for="passport" class="validation">账号</label>
                ( String ) [passport]
                <input class="layui-input" name="passport" data-rule-required="true" type="text" id="passport">
            </div>
            <div class="layui-form-item">
                <label for="password">密码</label>
                ( String ) [password]
                <input class="layui-input" name="password" type="text" id="password">
            </div>
            <div class="layui-form-item">
                <label for="captcha">验证码 {!! Form::tip('后端可以设置用户绕过验证码设置') !!}</label>
                ( String ) [captcha]
                <input class="layui-input" name="captcha" type="text" id="captcha">
            </div>
            <div class="layui-form-item">
                <button class="layui-btn btn-sm J_validate" type="submit" id="submit">登录</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection