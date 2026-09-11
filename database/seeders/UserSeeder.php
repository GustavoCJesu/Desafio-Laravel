<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder {
    public function run(): void {
        User::create([
            'email' => 'gustavo@gmail.com',
            'employee_id' => 1,
            'user_role_id' => 1,
            'password' => '123456',
        ]);

        User::create([
            'email' => 'mariana@gmail.com',
            'employee_id' => 2,
            'user_role_id' => 2,
            'password' => '123456',
        ]);

        User::create([
            'email' => 'rafael@gmail.com',
            'employee_id' => 3,
            'user_role_id' => 2,
            'password' => '123456',
        ]);

        User::create([
            'email' => 'camila@gmail.com',
            'employee_id' => 4,
            'user_role_id' => 3,
            'password' => '123456',
        ]);

        User::create([
            'email' => 'lucas@gmail.com',
            'employee_id' => 5,
            'user_role_id' => 2,
            'password' => '123456',
        ]);

        User::create([
            'email' => 'fernanda@gmail.com',
            'employee_id' => 6,
            'user_role_id' => 3,
            'password' => '123456',
        ]);

        User::create([
            'email' => 'joao@gmail.com',
            'employee_id' => 7,
            'user_role_id' => 2,
            'password' => '123456',
        ]);

        User::create([
            'email' => 'bruno@gmail.com',
            'employee_id' => 8,
            'user_role_id' => 2,
            'password' => '123456',
        ]);

        User::create([
            'email' => 'andre@gmail.com',
            'employee_id' => 9,
            'user_role_id' => 2,
            'password' => '123456',
        ]);

        User::create([
            'email' => 'patricia@gmail.com',
            'employee_id' => 10,
            'user_role_id' => 3,
            'password' => '123456',
        ]);

        User::create([
            'email' => 'thiago@gmail.com',
            'employee_id' => 11,
            'user_role_id' => 2,
            'password' => '123456',
        ]);

        User::create([
            'email' => 'carlos@gmail.com',
            'employee_id' => 12,
            'user_role_id' => 2,
            'password' => '123456',
        ]);

        User::create([
            'email' => 'diego@gmail.com',
            'employee_id' => 13,
            'user_role_id' => 2,
            'password' => '123456',
        ]);

        User::create([
            'email' => 'juliana@gmail.com',
            'employee_id' => 14,
            'user_role_id' => 3,
            'password' => '123456',
        ]);

        User::create([
            'email' => 'renata@gmail.com',
            'employee_id' => 15,
            'user_role_id' => 2,
            'password' => '123456',
        ]);

        User::create([
            'email' => 'marcelo@gmail.com',
            'employee_id' => 16,
            'user_role_id' => 2,
            'password' => '123456',
        ]);

        User::create([
            'email' => 'aline@gmail.com',
            'employee_id' => 17,
            'user_role_id' => 2,
            'password' => '123456',
        ]);

        User::create([
            'email' => 'roberto@gmail.com',
            'employee_id' => 18,
            'user_role_id' => 3,
            'password' => '123456',
        ]);

        User::create([
            'email' => 'beatriz@gmail.com',
            'employee_id' => 19,
            'user_role_id' => 2,
            'password' => '123456',
        ]);

        User::create([
            'email' => 'felipe@gmail.com',
            'employee_id' => 20,
            'user_role_id' => 2,
            'password' => '123456',
        ]);
    }
}
