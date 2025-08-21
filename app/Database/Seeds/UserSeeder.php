<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'email' => 'admin@admin.fr',
                'password' => password_hash('admin', PASSWORD_DEFAULT),
                'username' => 'admin',
                'first_name' => 'Ad',
                'last_name' => 'Min',
                'birthdate' => '1988-09-08',
                'id_permission' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'email' => 'user@user.fr',
                'password' => password_hash('user', PASSWORD_DEFAULT),
                'username' => 'user',
                'first_name' => 'Us',
                'last_name' => 'Er',
                'birthdate' => '1991-04-30',
                'id_permission' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];
        $this->db->table('user')->insertBatch($data);
    }
}
