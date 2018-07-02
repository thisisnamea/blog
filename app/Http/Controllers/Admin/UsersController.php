<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Config;
use App\Models\admin\User;
use App\Models\admin\UserDetail;
use App\Myclass\PwdAbout;
use DB;

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


         DB::beginTransaction();
        //模型
        $data = User::create($res); 

        // 注册时间
        $time = time();

        $uid = ['uid'=>$data->uid]; 
        $comment = $data->UserDetail()->create([
            'uid' => $data->uid,
            'reg_time' => $time,
        ]);
        if($data && $comment){

            DB::commit();

            return redirect('/admin/user')->with('info','添加成功');

        } else {
             DB::rollback();
             return redirect()->back()->withInput()->withErrors('添加失败！');
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
        $user = User::find($id);

        $res =  $user->UserDetail()->where('uid', $id)->get(); 
        // dump($res[$id]->sex);
        // dd($res[0]);
     
        return view('/admin/user/edit',[
                'title' => '用户的修改',
                'user' => $user,
                'user_detail' => $res[0],
            ]);
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

       $uid = $id;
       unset($id);

        //表单验证
        $this->validate($request, [
            'name' => 'required|regex:/^\w{5,12}$/',
           
            'email'=>'required|email',
            'phone'=>'required|regex:/^1[3456789]\d{9}$/',                    
        ],[
            'name.required'=>'用户名不能为空',
            'email.required'=>'email不能为空',
            'name.regex'=>'用户名格式不正确',
            'email.email'=>'邮箱格式不正确',
            'phone.required'=>'手机号不能为空',
            'phone.regex'=>'手机号格式不正确'

        ]);

        $res = $request->except(['_token','uimg','repass','_method']);

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


        // dd($res);

        //模型
        
        $post = User::find($uid);
        $data = $res;
        $post1 = UserDetail::where('uid',$uid)->get();

        DB::beginTransaction();
        $post->update($data);
        $xxoo = $post1[0]->update($res);
  
     
        if($post && $post1){

            DB::commit();
            return redirect('/admin/user')->with('info','修改成功');
            
        } else {

             DB::rollBack();
           return redirect()->back()->withInput()->withErrors('修改失败！');
           
        }

       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        DB::beginTransaction();

        $user = User::find($id);
        $res = User::find($id)->delete();
        $res_d = UserDetail::where('uid',$id)->get();   
        $res_d[0]->delete();
        if($res && $res_d){

            DB::commit();
            return redirect('/admin/user')->with('info','删除成功');

        }else{

            DB::rollBack();
            return redirect('/admin/user')->with('info','删除失败');
           
        }           
    }
}
