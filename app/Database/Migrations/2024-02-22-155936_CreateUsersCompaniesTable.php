<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersCompaniesTable extends Migration {
    public function up(){
        $this->forge->addField([
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'company_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
        ]);
        // Add foreign key constraint for user_id
        $this->forge->addForeignKey('user_id', 'user', 'id', 'CASCADE', 'CASCADE');
        // Add foreign key constraint for company_id
        $this->forge->addForeignKey('company_id', 'company', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('users_companies');
    }

    public function down() {
        $this->forge->dropTable('users_companies');
    }
}
