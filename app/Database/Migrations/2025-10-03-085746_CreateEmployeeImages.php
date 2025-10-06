<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEmployeeImages extends Migration
{
    public function up()
    {
        {
            $this->forge->addField([
                'id'          => ['type' => 'INT', 'auto_increment' => true],
                'employee_id' => ['type' => 'INT'],
                'image'       => ['type' => 'VARCHAR', 'constraint' => '255'],
                'created_at'  => ['type' => 'DATETIME', 'null' => true],
                'updated_at'  => ['type' => 'DATETIME', 'null' => true],
            ]);
            $this->forge->addKey('id', true);
            $this->forge->createTable('employee_images');
        }
    }

    public function down()
    {
        //
    }
}
