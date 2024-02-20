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
            if (!Schema::hasTable('categories')) {
                Schema::create('categories', function (Blueprint $table) {
                    $table->id();

                    $table->integer('sort')->default(0)->comment('Сортировка');

                    $table->string('name', 191)->comment('Название категории');
                    $table->string('alias', 191)->nullable()->comment('Alias категории');

                    $table->boolean('published')->default(true)->comment('Публикация на сайте');

                    $table->string('title', 190)->nullable()->comment('Title категории');
                    $table->string('description', 190)->nullable()->comment('Description категории');
                    $table->string('keywords', 190)->nullable()->comment('Keywords категории');

                    $table->integer('freq')->default(2)->comment('Частота обновления для SiteMap: 0-always, 1-hourly, 2-daily, 3-weekly, 4-monthly, 5-yearly, 6-never');
                    $table->string('priority', 3)->default('0.9')->comment('Приоритет для SiteMap');

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
            if (Schema::hasTable('categories')) {
                Schema::dropIfExists('categories');
            }
        }
    };
