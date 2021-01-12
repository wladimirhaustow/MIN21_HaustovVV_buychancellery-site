<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserStatus extends Migration
{
	public function up()
	{
        $this->forge->addField([
            'id'					=> ['type' => 'int', 'constraint' => 11, 'auto_increment' => true],
            'name'					=> ['type' => 'varchar', 'constraint' => 30],
            'comment'               => ['type' => 'varchar', 'constraint' => 100]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('c_user_status', true);
        //
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
	}
}
