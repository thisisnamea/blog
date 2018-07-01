<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
   //
    /**
     * 与模型关联的数据表
     *
     * @var string
     */
    protected $table = 'users';

    protected $primaryKey = 'uid';

    public $timestamps = false;


    /**
     * 可以被批量赋值的属性。
     *
     * @var array
     */
    // 姓名,密码,email,电话,状态  1启用 0禁止 ,权限 0 管理员  1是普通用户
    protected $fillable = ['name','password','email','phone','status','authority','uimg'];

    // 用户与详情表  一对一
    public function UserDetail()
    {
        return $this->hasOne('App\Models\admin\UserDetail','uid');
    }
}
