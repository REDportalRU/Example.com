<?php

    namespace Database\Seeders;

    use Illuminate\Database\Seeder;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Schema;

    class TemplateSeeder extends Seeder
    {
        /**
         * Run the database seeds.
         */
        public function run(): void
        {
            if (Schema::hasTable('templates')) {
                DB::table('templates')
                  ->insert([
                      [
                          'name'       => 'Главный шаблон',
                          'text'       => '',
                          'published'  => true,
                          'created_at' => date('Y-m-d H:i:s'),
                      ],
                      [
                          'name'       => 'Слайдер новостей №1',
                          'text'       => '',
                          'published'  => true,
                          'created_at' => date('Y-m-d H:i:s'),
                      ],
                      [
                          'name'       => 'Слайдер новостей №2',
                          'text'       => '',
                          'published'  => true,
                          'created_at' => date('Y-m-d H:i:s'),
                      ],
                      [
                          'name'       => 'Слайдер новостей №3',
                          'text'       => '',
                          'published'  => true,
                          'created_at' => date('Y-m-d H:i:s'),
                      ],
                      [
                          'name'       => 'Слайдер новостей №4',
                          'text'       => '',
                          'published'  => true,
                          'created_at' => date('Y-m-d H:i:s'),
                      ],
                      [
                          'name'       => 'Шаблон новостей №1',
                          'text'       => '',
                          'published'  => true,
                          'created_at' => date('Y-m-d H:i:s'),
                      ],
                      [
                          'name'       => 'Шаблон новостей №2',
                          'text'       => '',
                          'published'  => true,
                          'created_at' => date('Y-m-d H:i:s'),
                      ],
                      [
                          'name'       => 'Шаблон новостей №3',
                          'text'       => '',
                          'published'  => true,
                          'created_at' => date('Y-m-d H:i:s'),
                      ],
                      [
                          'name'       => 'Шаблон новостей №4',
                          'text'       => '',
                          'published'  => true,
                          'created_at' => date('Y-m-d H:i:s'),
                      ],
                      [
                          'name'       => 'HTML-шаблон новостей',
                          'text'       => '',
                          'published'  => true,
                          'created_at' => date('Y-m-d H:i:s'),
                      ],
                      [
                          'name'       => 'Новости в шапке сайта',
                          'text'       => '',
                          'published'  => true,
                          'created_at' => date('Y-m-d H:i:s'),
                      ],
                  ]);
            }
        }
    }
