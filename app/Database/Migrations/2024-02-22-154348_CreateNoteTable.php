<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateNoteTable extends Migration
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
            'trip_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'note' => [
                'type' => 'TEXT',
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
        // Add foreign key constraint for trip_id
        $this->forge->addForeignKey('trip_id', 'trip', 'id', 'CASCADE', 'CASCADE');
        // Add foreign key constraint for created_by
        $this->forge->addForeignKey('created_by', 'user', 'id', 'CASCADE', 'CASCADE');
        // Add foreign key constraint for modified_by
        $this->forge->addForeignKey('modified_by', 'user', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('note');
    }

    public function down()
    {
        $this->forge->dropTable('note');
    }
}
