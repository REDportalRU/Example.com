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
            if (!Schema::hasTable('news')) {
                Schema::create('news', function (Blueprint $table) {
                    $table->id();

                    $table->string('alias', 190)->nullable()->comment('Алиас новости');

                    $table->string('name', 190)->comment('Заголовок');
                    $table->text('text')->nullable()->comment('Текст новости');

                    $table->text('categories_id')->default('[]')->comment('JSON-список ID-категорий');
                    $table->text('tags_id')->default('[]')->nullable()->comment('JSON-список ID тегов');
                    $table->text('main_image')->nullable()->comment('Главная картинка новости');
                    $table->integer('hits')->default(0)->comment('Просмотры новости');

                    $table->string('title', 190)->nullable()->comment('Title новости');
                    $table->string('description', 190)->nullable()->comment('Description новости');
                    $table->string('keywords', 190)->nullable()->comment('Keywords новости');

                    $table->integer('freq')->default(2)->comment('Частота обновления для SiteMap: 0-always, 1-hourly, 2-daily, 3-weekly, 4-monthly, 5-yearly, 6-never');
                    $table->string('priority', 3)->default('0.8')->comment('Приоритет для SiteMap');

                    $table->boolean('published')->default(true)->comment('Публикация на сайте');

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
            if (Schema::hasTable('news')) {
                Schema::dropIfExists('news');
            }
        }
    };
