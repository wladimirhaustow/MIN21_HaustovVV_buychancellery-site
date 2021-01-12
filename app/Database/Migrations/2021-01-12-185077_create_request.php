<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRequest extends Migration
{
	public function up()
	{
        $this->forge->addField([
            'id'					=> ['type' => 'int', 'constraint' => 11, 'auto_increment' => true],
            'request'					=> ['type' => 'text'],
            'user'             => ['type' => 'int', 'constraint' => 11],
            'created_at'			=> ['type' => 'bigint', 'null' => true],
            'updated_at'            => ['type' => 'bigint', 'null' => true],
            'deleted_at'            => ['type' => 'bigint', 'null' => true]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user','t_users','id','NO ACTION','NO ACTION');
        $this->forge->createTable('t_request', true);
		//
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
	}
}
