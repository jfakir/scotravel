<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLodgingUsersTable extends Migration
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
            'lodging_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
            ],
        ]);

        // Add foreign key constraint for user_id
        $this->forge->addForeignKey('user_id', 'user', 'id', 'CASCADE', 'CASCADE');

        // Add foreign key constraint for lodging_id
        $this->forge->addForeignKey('lodging_id', 'lodging', 'id', 'CASCADE', 'CASCADE');

        $this->forge->addPrimaryKey('id');

        // Add unique constraint to ensure each user can be associated with a lodging only once
        $this->forge->addUniqueKey(['user_id', 'lodging_id']);

        $this->forge->createTable('lodging_users');
    }

    public function down()
    {
        $this->forge->dropTable('lodging_users');
    }
}
