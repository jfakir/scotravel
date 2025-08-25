<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMileageAccountTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'airline' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'points' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
            ],
            'account_number' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'default' => null,
                'null' => true,
            ],
            'created_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'modified_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
                'default' => null,
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'default' => null,
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
                'default' => null,
                'on update' => 'CURRENT_TIMESTAMP',
            ],
            'is_deleted' => [
                'type' => 'INT',
                'constraint' => 1,
                'default' => 0,
            ],
        ]);

        // Add foreign key constraint for user_id
        $this->forge->addForeignKey('user_id', 'user', 'id', 'CASCADE', 'CASCADE');

        // Add foreign key constraint for created_by
        $this->forge->addForeignKey('created_by', 'user', 'id', 'CASCADE', 'CASCADE');

        // Add foreign key constraint for modified_by
        $this->forge->addForeignKey('modified_by', 'user', 'id', 'CASCADE', 'CASCADE');

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('mileage_account');
    }

    public function down()
    {
        $this->forge->dropTable('mileage_account');
    }
}
