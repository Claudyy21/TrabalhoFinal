<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTotemFieldsToPedidos extends Migration
{
    public function up()
    {
        $fields = [
            'totem_id' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'totem_name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'totem_ip' => [
                'type' => 'VARCHAR',
                'constraint' => 45,
                'null' => true,
            ],
        ];

        $this->forge->addColumn('pedidos', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('pedidos', ['totem_id', 'totem_name', 'totem_ip']);
    }
}
