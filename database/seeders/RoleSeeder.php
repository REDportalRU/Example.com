<?php

    namespace Database\Seeders;

    use Illuminate\Database\Console\Seeds\WithoutModelEvents;
    use Illuminate\Database\Seeder;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Schema;

    class RoleSeeder extends Seeder
    {
        /**
         * Run the database seeds.
         */
        public function run(): void
        {
            if (Schema::hasTable('roles')) {
                DB::table('roles')
                  ->insert([
                      [
                          'name'     => 'Супер-админ',
                          'created_at' => date('Y-m-d H:i:s')
                      ],
                      [
                          'name'       => 'Админ',
                          'created_at' => date('Y-m-d H:i:s')
                      ],
                      [
                          'name'       => 'Новости',
                          'created_at' => date('Y-m-d H:i:s')
                      ],
                      [
                          'name'       => 'Реклама',
                          'created_at' => date('Y-m-d H:i:s')
                      ],
                  ]);
            };
        }
    }
