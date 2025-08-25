<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateActivityUsersTable extends Migration
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
            'activity_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
            ],
        ]);

        // Add foreign key constraint for user_id
        $this->forge->addForeignKey('user_id', 'user', 'id', 'CASCADE', 'CASCADE');

        // Add foreign key constraint for activity_id
        $this->forge->addForeignKey('activity_id', 'activity', 'id', 'CASCADE', 'CASCADE');

        $this->forge->addPrimaryKey('id');

        // Add unique constraint to ensure each user can be associated with an activity only once
        $this->forge->addUniqueKey(['user_id', 'activity_id']);

        $this->forge->createTable('activity_users');
    }

    public function down()
    {
        $this->forge->dropTable('activity_users');
    }
}

