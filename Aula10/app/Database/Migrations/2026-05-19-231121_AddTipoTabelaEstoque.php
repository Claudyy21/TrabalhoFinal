<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTipoTabelaEstoque extends Migration
{
    public function up()
    {
        $this->forge->addColumn(
            'estoques', [
                'tipo' => ['type' => 'varchar', 'constraint' => 7, 'null' => true, 'comment' => 'Entrada/Saída']
            ]
        );
    }

    public function down()
    {
        $this-forge->dropColumn('estoques', 'tipo');
    }
}
