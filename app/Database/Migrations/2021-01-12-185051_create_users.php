<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsers extends Migration
{
	public function up()
	{
        $this->forge->addField([
            'id'					=> ['type' => 'int', 'constraint' => 11, 'auto_increment' => true],
            'login'					=> ['type' => 'varchar', 'constraint' => 20],
            'password'					=> ['type' => 'varchar', 'constraint' => 100],
            'user_status'             => ['type' => 'int', 'constraint' => 11, 'default' => 1],
            'created_at'			=> ['type' => 'bigint', 'null' => true],
            'updated_at'            => ['type' => 'bigint', 'null' => true],
            'deleted_at'            => ['type' => 'bigint', 'null' => true]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('bdSeeds');
        $this->forge->addForeignKey('user_status','c_user_status','id','NO ACTION','NO ACTION');
        $this->forge->createTable('t_users', true);
		//
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
	}
}
