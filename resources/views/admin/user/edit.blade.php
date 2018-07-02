@extends('layout.admins.admins')

@section('title',$title)


@section('content')
<div class="mws-panel grid_8">
	<div class="mws-panel-header">
    	<span>{{$title}}</span>
    </div>
    <div class="mws-panel-body no-padding">

    		@if (count($errors) > 0)
			    <div class="mws-form-message error">
			        <ul>
			            @foreach ($errors->all() as $error)
			                <li style='font-size:16px;list-style:none'>{{ $error }}</li>
			            @endforeach
			        </ul>
			    </div>
			@endif


    	<form action="/admin/user/{{$user->uid}}" method='post' class="mws-form" enctype='multipart/form-data'>

    		<div class="mws-form-inline">
    			<div class="mws-form-row">
    				<label class="mws-form-label">用户名</label>
    				<div class="mws-form-item">
    					<input type="text" class="small" name='name' value="{{$user->name}}">
    				</div>
    			</div>

                <div class="mws-form-row">
                    <label class="mws-form-label">性别</label>
                    <div class="mws-form-item clearfix">
                        <ul class="mws-form-list inline">
                            <li><input type="radio" name='sex' value='1'  
                                @if ($user_detail->sex == 1)
                                    checked
                                @endif
                             > <label>男</label></li>
                            <li><input type="radio" name='sex' value='0'  
                                 @if ($user_detail->sex == 0)
                                    checked
                                @endif 
                                > <label>女</label></li>
                        </ul>
                    </div>
                </div>
                
                <div class="mws-form-row">
                    <label class="mws-form-label">出生日期</label>
                    <div class="mws-form-item">
                        <input type="text" class="small" name='brithday' value="{{$user_detail->brithday}}">
                    </div>
                </div>
                
              

    			<div class="mws-form-row">
    				<label class="mws-form-label">邮箱</label>
    				<div class="mws-form-item">
    					<input type="text" class="small" name='email' value="{{$user->email}}">
    				</div>
    			</div>

    			<div class="mws-form-row">
    				<label class="mws-form-label">手机号</label>
    				<div class="mws-form-item">
    					<input type="text" class="small" name='phone' value="{{$user->phone}}">
    				</div>
    			</div>

                <div class="mws-form-row">
                    <label class="mws-form-label">居住地</label>
                    <div class="mws-form-item">
                        <input type="text" class="small" name='address' value="{{$user_detail->address}}">
                    </div>
                </div>

    			<div class="mws-form-row">
    				<label class="mws-form-label">头像</label>
    				<div class="mws-form-item">
    					<!-- <input type="file" class="small" name='profile'> -->
                        <img src="{{$user->uimg}}" width="100px">
    					<input type="file" name='uimg' class="fileinput-preview" style="width: 455px; padding-right: 84px;" readonly="readonly" placeholder="请选择头像">
    				</div>
    			</div>

                <div class="mws-form-row">
                    <label class="mws-form-label">个人简介:</label>
                    <div class="mws-form-item">
                        <textarea rows="" cols="" class="large" name="label">{{$user_detail->label}}</textarea>
                    </div>
                </div>
    			<div class="mws-form-row">
    				<label class="mws-form-label">状态</label>
    				<div class="mws-form-item clearfix">
    					<ul class="mws-form-list inline">
    						<li><input type="radio" name='status' value='1' 
                               @if ($user->status == 1)
                                    checked
                                @endif
                             > <label>启动</label></li>
    						<li><input type="radio" name='status' value='0' 
                                 @if ($user->status == 0)
                                    checked
                                @endif
                                > <label>禁止</label></li>
    					</ul>
    				</div>
    			</div>
                  <div class="mws-form-row bordered">
                                    <label class="mws-form-label">选择身份</label>
                                    <div class="mws-form-item"  style="width:200px;">
                                        <select class="large" name="authority">
                                            <option value="1" 
                                                 @if ($user->authority == 1)
                                                         selected 
                                                    @endif
                                            >普通用户</option>
                                            <option value="0"
                                              @if ($user->authority == 0)
                                                         selected 
                                                    @endif>管理员</option>
                                        </select>
                                    </div>
                                </div>
    		</div>
    		<div class="mws-button-row">
                {{ method_field('PUT') }}
    			{{csrf_field()}}
    			<input type="submit" class="btn btn-success" value="提交">
    		</div>
    	</form>
    </div>    	
</div>


@endsection

@section('js')
<script type="text/javascript">
	
	/*setTimeout(function(){

		$('.mws-form-message').remove();

	},3000)*/

	$('.mws-form-message').slideDown(1000).delay(3000).slideUp(1000);

</script>
@endsection