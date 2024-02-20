<?php

    namespace Database\Seeders;

    use Illuminate\Database\Seeder;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Schema;

    class MenuSeeder extends Seeder
    {
        /**
         * Run the database seeds.
         */
        public function run(): void
        {
            if (Schema::hasTable('menus')) {
                DB::table('menus')
                  ->insert([
                      [
                          'page_id'    => 1,
                          'sort'       => 1,
                          'name'       => 'Главная',
                          'published'  => true,
                          'head'       => true,
                          'foot'       => true,
                          'created_at' => date('Y-m-d H:i:s'),
                      ],
                      [
                          'page_id'    => 0,
                          'sort'       => 2,
                          'name'       => 'Новости',
                          'published'  => true,
                          'head'       => true,
                          'foot'       => true,
                          'created_at' => date('Y-m-d H:i:s'),
                      ],
                      [
                          'page_id'    => 2,
                          'sort'       => 3,
                          'name'       => 'PDF-рассылка',
                          'published'  => true,
                          'head'       => true,
                          'foot'       => true,
                          'created_at' => date('Y-m-d H:i:s'),
                      ],
                      [
                          'page_id'    => 3,
                          'sort'       => 4,
                          'name'       => 'Реклама',
                          'published'  => true,
                          'head'       => true,
                          'foot'       => true,
                          'created_at' => date('Y-m-d H:i:s'),
                      ],
                      [
                          'page_id'    => 4,
                          'sort'       => 5,
                          'name'       => 'Оплата',
                          'published'  => true,
                          'head'       => true,
                          'foot'       => true,
                          'created_at' => date('Y-m-d H:i:s'),
                      ],
                      [
                          'page_id'    => 5,
                          'sort'       => 6,
                          'name'       => 'Контакты',
                          'published'  => true,
                          'head'       => true,
                          'foot'       => true,
                          'created_at' => date('Y-m-d H:i:s'),
                      ],
                      [
                          'page_id'    => 6,
                          'sort'       => 7,
                          'name'       => 'Дополнительный пункт',
                          'published'  => true,
                          'head'       => true,
                          'foot'       => true,
                          'created_at' => date('Y-m-d H:i:s'),
                      ],
                      [
                          'page_id'    => 7,
                          'sort'       => 8,
                          'name'       => 'Дополнительный пункт',
                          'published'  => true,
                          'head'       => true,
                          'foot'       => true,
                          'created_at' => date('Y-m-d H:i:s'),
                      ],
                      [
                          'page_id'    => 8,
                          'sort'       => 9,
                          'name'       => 'Дополнительный пункт',
                          'published'  => true,
                          'head'       => true,
                          'foot'       => true,
                          'created_at' => date('Y-m-d H:i:s'),
                      ],
                  ]);
            }
        }
    }
