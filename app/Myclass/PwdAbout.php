<?php 

namespace App\Myclass;

use Hash;
/**
 * 密码 的加密 和效验
 * 已测试
 */
class PwdAbout
{
	/**
	 * $str 需要加密的字符串
	 * 返回64位字符串
	 */
	public static function jiami($str)
	{
		 $hashed = Hash::make($str.'myblog');

		 $hashed = $hashed.'myblog';

		 return $hashed;
	}

	/**
	 *  $table  数据表中 加密的字符串
	 *  $user   用户再次登录时 输入的字符串
	 *  
	 *  返回布尔
	 */
	
	 
	public static function xiaoyan($user,$table)
	{
		return Hash::check($user.'myblog', substr($table,0,60));
	}
}