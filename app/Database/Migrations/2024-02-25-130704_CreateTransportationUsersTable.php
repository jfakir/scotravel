<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTransportationUsersTable extends Migration
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
                'null' => false,
            ],
            'transportation_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
            ],
        ]);

        // Add foreign key constraint for user_id
        $this->forge->addForeignKey('user_id', 'user', 'id', 'CASCADE', 'CASCADE');

        // Add foreign key constraint for transportation_id
        $this->forge->addForeignKey('transportation_id', 'transportation', 'id', 'CASCADE', 'CASCADE');

        $this->forge->addPrimaryKey('id');

        // Add unique constraint to ensure each user can be associated with a transportation only once
        $this->forge->addUniqueKey(['user_id', 'transportation_id']);

        $this->forge->createTable('transportation_users');
    }

    public function down()
    {
        $this->forge->dropTable('transportation_users');
    }
}
