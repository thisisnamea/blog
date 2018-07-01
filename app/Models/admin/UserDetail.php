<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
       //
    /**
     * 与模型关联的数据表
     *
     * @var string
     */
    protected $table = 'users_detail';

    protected $primaryKey = 'd_id';

    public $timestamps = false;


    /**
     * 可以被批量赋值的属性。
     *
     * @var array
     */
    //
    // 性别 0是女 1是男,头像,地址,生日,个人简历,上次登陆时间,注册时间
    protected $fillable = ['sex','address','birthday','label','last_time','reg_time'];
}
