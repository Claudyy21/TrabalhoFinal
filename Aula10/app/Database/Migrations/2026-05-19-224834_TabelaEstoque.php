<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TabelaEstoque extends Migration
{
    public function up()
    {
        $this->forge->addField(
            [
                'id' => [
                'type' => 'int', 
                'constraint' => 11, 
                'auto_increment' => true, 
                'unsigned' => true],

                'id_produto'=>[
                'type' => 'int', 
                'constraint' => 11],

                'quantidade'=>[
                'type' => 'int', 
                'constraint' => 11],

                'fornecedor'=>[
                'type' => 'varchar', 
                'constraint' => 255,
                'null'=>true],
        
                'observacao'=>[
                'type' => 'varchar', 
                'constraint' => 255,
                'null'=>true],

                'created_at'=>[
                'type' => 'datetime', 
                'null'=>true],

                'updated_at'=>[
                'type' => 'datetime', 
                'null'=>true],
            ]
        );

        $this->forge->addKey('id', true);
        $this->forge->createTable('estoques');
    
    }

    public function down()
    {
        $this->forge->dropTable('estoques');
    }
}
