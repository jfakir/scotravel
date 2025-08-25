<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCarRentingUsersTable extends Migration
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
            'car_renting_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
            ],
        ]);

        // Add foreign key constraint for user_id
        $this->forge->addForeignKey('user_id', 'user', 'id', 'CASCADE', 'CASCADE');

        // Add foreign key constraint for car_renting_id
        $this->forge->addForeignKey('car_renting_id', 'car_renting', 'id', 'CASCADE', 'CASCADE');

        $this->forge->addPrimaryKey('id');

        // Add unique constraint to ensure each user can be associated with a car renting plan only once
        $this->forge->addUniqueKey(['user_id', 'car_renting_id']);

        $this->forge->createTable('car_renting_users');
    }

    public function down()
    {
        $this->forge->dropTable('car_renting_users');
    }
}
