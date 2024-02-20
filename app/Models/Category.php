<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\SoftDeletes;

    class Category extends Model
    {
        use HasFactory, SoftDeletes;

        /**
         * @var string
         */
        protected $table = 'categories';

        /**
         * @var string[]
         */
        protected $fillable = [
            'sort',
            'alias',
            'name',
            'published',
        ];

        /**
         * Формирование массива меню категорий
         *
         * @return array
         */
        public static function getToArray(): array
        {
            $res_array = self::query()
                             ->select([
                                 'alias',
                                 'name',
                             ])
                             ->where('published', 1)
                             ->orderBy('sort')
                             ->get()
                             ->toArray();

            return empty($res_array) ? [] : $res_array;
        }
    }
