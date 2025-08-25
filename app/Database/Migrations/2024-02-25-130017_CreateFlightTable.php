<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFlightTable extends Migration
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
            'main_flight_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
            ],
            'is_round_trip' => [
                'type' => 'INT',
                'constraint' => 1,
                'default' => 0,
            ],
            'is_layover' => [
                'type' => 'INT',
                'constraint' => 1,
                'default' => 0,
            ],
            'confirmation' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'flight_number' => [
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
            'airline_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
            ],
            'departure_airport' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
            ],
            'arrival_airport' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
            ],
            'departure_terminal' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'arrival_terminal' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'departure_gate' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'arrival_gate' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'aircraft' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'class' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'meal' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'entertainment' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'distance' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0,
            ],
            'cost' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0,
            ],
            'baggage_cost' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0,
            ],
            'seat_cost' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0,
            ],
            'mileage_redeemed' => [
                'type' => 'INT',
                'constraint' => 11,
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

        // Add foreign key constraint for airline_id
        $this->forge->addForeignKey('airline_id', 'airline', 'id', 'CASCADE', 'CASCADE');

        // Add foreign key constraint for departure_airport
        $this->forge->addForeignKey('departure_airport', 'airport', 'id', 'CASCADE', 'CASCADE');

        // Add foreign key constraint for arrival_airport
        $this->forge->addForeignKey('arrival_airport', 'airport', 'id', 'CASCADE', 'CASCADE');

        // Add foreign key constraint for created_by
        $this->forge->addForeignKey('created_by', 'user', 'id', 'CASCADE', 'CASCADE');

        // Add foreign key constraint for modified_by
        $this->forge->addForeignKey('modified_by', 'user', 'id', 'CASCADE', 'CASCADE');

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('flight');
    }

    public function down()
    {
        $this->forge->dropTable('flight');
    }
}
