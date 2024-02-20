<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration {
        /**
         * Run the migrations.
         */
        public function up(): void
        {
            if (!Schema::hasTable('menus')) {
                Schema::create('menus', function (Blueprint $table) {
                    $table->id();
                    $table->bigInteger('page_id')->default(0)->comment('ID-страницы');

                    $table->integer('sort')->default(0)->comment('Сортировка');

                    $table->string('name', 191)->comment('Название меню');

                    $table->boolean('published')->default(true)->comment('Публикация на сайте');
                    $table->boolean('head')->default(0)->comment('Отображение вверху');
                    $table->boolean('foot')->default(0)->comment('Отображение внизу');

                    $table->timestamps();
                    $table->softDeletes();
                });
            }
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            if (Schema::hasTable('menus')) {
                Schema::dropIfExists('menus');
            }
        }
    };
