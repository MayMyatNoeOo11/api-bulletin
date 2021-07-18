<?php

namespace Database\Seeders;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();
        for($i=1;$i<2;$i++)
        {
            DB::table('users')->insert([
                'name' => 'User '.$i,
                'email' =>'user'.$i.'@gmail.com', //Str::random(7).'@gmail.com',
                'password' => Hash::make('User1234'),
                'phone' => '0979895623'.$i,
                'type'=>'1',
                'address' => Str::random(50),
                'profile_photo' => 'D:\MayMyatNoeOo\images\img'.$i.'.jpg',
                'date_of_birth' => '1996-11-07',
                'created_at'=>now(),
                'updated_at'=>now(),
                'created_user_id'=>'1',
                'updated_user_id'=>'1',
                'remember_token'=>str::random(10)
            ]);
        }
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' =>'admin@gmail.com', //Str::random(7).'@gmail.com',
            'password' => Hash::make('Admin1234'),
            'phone' => '0979895623'.$i,
            'type'=>'0',
            'address' => Str::random(50),
            'profile_photo' => 'D:\MayMyatNoeOo\images\img'.$i.'.jpg',
            'date_of_birth' => '1996-11-07',
            'created_at'=>now(),
            'updated_at'=>now(),
            'created_user_id'=>'1',
            'updated_user_id'=>'1',
            'remember_token'=>str::random(10)
        ]);
    }
}
