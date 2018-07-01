<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Config;
use App\Models\admin\User;
use App\Models\admin\UserDetail;
use App\Myclass\PwdAbout;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         //
        $res = User::paginate(10);

        return view('admin.user.index',[
            'title'=>'用户列表',
            'res'=>$res

        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.add',[

            'title'=>'用户基本信息添加'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

       //表单验证
        $this->validate($request, [
            'name' => 'required|regex:/^\w{5,12}$/',
            'password' => 'required|regex:/^\S{6,12}$/',
            'repass'=>'same:password',
            'email'=>'required|email',
            'phone'=>'required|regex:/^1[3456789]\d{9}$/',                    
        ],[
            'name.required'=>'用户名不能为空',
            'email.required'=>'email不能为空',
            'name.regex'=>'用户名格式不正确',
            'password.required'=>'密码不能为空',
            'password.regex'=>'密码格式不正确',
            'repass.same'=>'两次密码不一致',
            'email.email'=>'邮箱格式不正确',
            'phone.required'=>'手机号不能为空',
            'phone.regex'=>'手机号格式不正确'

        ]);

        $res = $request->except(['_token','uimg','repass']);

        //头像
        if($request->hasFile('uimg')){

            //设置名字
            $name = str_random(10).time();

            //获取后缀
            $suffix = $request->file('uimg')->getClientOriginalExtension();

            //移动
            $request->file('uimg')->move(Config::get('app.move'),$name.'.'.$suffix);
            //存数据表
            $res['uimg'] = Config::get('app.path').$name.'.'.$suffix;
            // dd($res);
        }

        
      

        //密码加密
        $res['password'] = PwdAbout::jiami($request->input('password'));
// echo  '<pre>';
// var_dump($res);die;
        //模型
        $data = User::create($res);
        // dd($data->uid);
        // $data1 = UserDetail::create('uid',$data->uid);
dd($data);
        if($data){

            return redirect('/admin/user')->with('info','添加成功');

        } else {

            return back();
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id)->UserDetail;
        // dd($user);
        return view('admin.user.detailIndex',[
                'user' => $user,
                'title' => '用户详情',
            ]);
    }       

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
