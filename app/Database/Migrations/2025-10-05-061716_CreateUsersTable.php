<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
{
        public function up()
        {
            $this->forge->addField([
                'id' => [
                    'type'           => 'INT',
                    'constraint'     => 11,
                    'unsigned'       => true,
                    'auto_increment' => true,
                ],
                'username' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 50,
                    'unique'     => true,
                ],
                'email' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                    'unique'     => true,
                ],
                'password' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                ],
                'created_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                ],
                'updated_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                ],
                'deleted_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                ],
            ]);

            $this->forge->addKey('id', true); // Set 'id' as the primary key
            $this->forge->createTable('users'); // Create the 'users' table
        }

        public function down()
        {
            $this->forge->dropTable('users'); // Drop the 'users' table if rolling back
        }
}
