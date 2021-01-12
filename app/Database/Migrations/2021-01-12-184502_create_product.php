<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProduct extends Migration
{
	public function up()
	{
        $this->forge->addField([
            'id'					=> ['type' => 'int', 'constraint' => 11, 'auto_increment' => true],
            'name'					=> ['type' => 'varchar', 'constraint' => 30],
            'comment'             => ['type' => 'varchar', 'constraint' => 100, 'null' => true],
            'created_at'			=> ['type' => 'bigint', 'null' => true],
            'updated_at'            => ['type' => 'bigint', 'null' => true],
            'deleted_at'            => ['type' => 'bigint', 'null' => true]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('t_product', true);
        //
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
	}
}
