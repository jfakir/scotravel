<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFlightUsersTable extends Migration
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
            'flight_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
            ],
        ]);

        // Add foreign key constraint for user_id
        $this->forge->addForeignKey('user_id', 'user', 'id', 'CASCADE', 'CASCADE');

        // Add foreign key constraint for flight_id
        $this->forge->addForeignKey('flight_id', 'flight', 'id', 'CASCADE', 'CASCADE');

        $this->forge->addPrimaryKey('id');

        // Add unique constraint to ensure each user can be associated with a flight only once
        $this->forge->addUniqueKey(['user_id', 'flight_id']);

        $this->forge->createTable('flight_users');
    }

    public function down()
    {
        $this->forge->dropTable('flight_users');
    }
}
