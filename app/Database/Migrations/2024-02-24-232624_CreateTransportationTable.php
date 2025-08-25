<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTransportationTable extends Migration
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
                'null' => false,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'address' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'dropoff_address' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'starting_date_time' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'ending_date_time' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'confirmation' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'phone' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'cost' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0,
            ],
            'created_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
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
        $this->forge->createTable('transportation');
    }

    public function down()
    {
        $this->forge->dropTable('transportation');
    }
}
