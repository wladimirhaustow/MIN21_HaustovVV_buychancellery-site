<?php namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class bdSeeds extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'user',
                'comment'    => 'Обычный пользователь'
            ],
            [
                'name' => 'admin',
                'comment'    => 'Администратор'
            ],
            [
                'name' => 'purchaser',
                'comment'    => 'Закупщик'
            ]
        ];

        $this->db->table('c_user_status')->insertBatch($data);

        $data = [
            [
                'login' => 'wladimir1',
                'password'    => '$2y$10$.v.M8RUd1dvu.SzTQywbwupOHB7BnnfGEhNjj7boVBatxmTTl6cx2',
                'user_status'    => 1,
            ],
            [
                'login' => 'wladimir2',
                'password'    => '$2y$10$.v.M8RUd1dvu.SzTQywbwupOHB7BnnfGEhNjj7boVBatxmTTl6cx2',
                'user_status'    => 2,
            ],
            [
                'login' => 'wladimir3',
                'password'    => '$2y$10$.v.M8RUd1dvu.SzTQywbwupOHB7BnnfGEhNjj7boVBatxmTTl6cx2',
                'user_status'    => 3,
            ]
        ];

        $this->db->table('t_users')->insertBatch($data);
    }
}