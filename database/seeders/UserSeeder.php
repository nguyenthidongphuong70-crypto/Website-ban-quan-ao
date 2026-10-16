<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['full_name' => 'Quản trị viên', 'email' => 'admin@webbanao.com', 'phone' => '0909000000', 'address' => 'TP.HCM', 'role' => 'admin'],
            ['full_name' => 'Nguyễn Văn A', 'email' => 'vana@gmail.com', 'phone' => '0909111111', 'address' => 'Quận 1, TP.HCM', 'role' => 'customer'],
            ['full_name' => 'Trần Thị B', 'email' => 'thib@gmail.com', 'phone' => '0909222222', 'address' => 'Quận 3, TP.HCM', 'role' => 'customer'],
        ];

        foreach ($users as $data) {
            $existing = DB::table('users')->where('email', $data['email'])->first();
            if ($existing === null) {
                DB::table('users')->insert(array_merge($data, [
                    'password' => Hash::make('123456'),
                    'created_at' => now(),
                ]));
            } elseif ($existing->password === '123456') {
                DB::table('users')->where('id', $existing->id)->update([
                    'password' => Hash::make('123456'),
                ]);
            }
        }
    }
}
