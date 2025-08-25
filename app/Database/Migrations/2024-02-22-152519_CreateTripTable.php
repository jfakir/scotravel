<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTripTable extends Migration
{
    public function up() {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'company_id' => [ 
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'destination' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'starting_date_time' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'ending_date_time' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'image_url' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'default' => null,
            ],
            'created_by' => [
                'type' => 'INT',
                'constraint' => 255,
                'null' => false,
            ],
            'modified_by' => [
                'type' => 'INT',
                'constraint' => 255,
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

        $this->forge->addForeignKey('company_id', 'company', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('created_by', 'user', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('modified_by', 'user', 'id', 'CASCADE', 'CASCADE');

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('trip');

    }

    public function down()
    {
        $this->forge->dropTable('trip');
    }
}
