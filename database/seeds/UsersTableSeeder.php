<?php

use Illuminate\Database\Seeder;
use App\Myclass\PwdAbout;

class UsersTableSeeder extends Seeder
{
   /**
     * 运行数据库填充
     * 
     * @return void
     */
    public function run()
    {
    	for ($i=0; $i <30 ; $i++) { 
    		
    	
	        DB::table('users')->insert([
	            'name' => str_random(10),
	            'email' => str_random(10).'@gmail.com',
	            'password' => PwdAbout::jiami('123456'),
	            'phone' => str_random(11),
	            'authority' => '1',
	            'status' => '1',
	            'uimg' => '/uploads/SHJEE0221m1530500520.jpg',
	        ]);
        }
    }
}
