<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('groups')->insert([
            'name' => 'Favoritos',
        ]);
        
        $this->command->info('Grupo "Favoritos" criado com sucesso');

        DB::table('groups')->insert([
            'name' => 'Colegas de trabalho',
        ]);
        
        $this->command->info('Grupo "Colegas de trabalho" criado com sucesso');

        DB::table('groups')->insert([
            'name' => 'Família',
        ]);
        
        $this->command->info('Grupo "Família" criado com sucesso');

        DB::table('groups')->insert([
            'name' => 'Amigos',
        ]);
        
        $this->command->info('Grupo "Amigos" criado com sucesso');

        DB::table('groups')->insert([
            'name' => 'Contatos de Emergência',
        ]);
        
        $this->command->info('Grupo "Contatos de Emergência" criado com sucesso');
    }
}
