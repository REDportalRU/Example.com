<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\SoftDeletes;

    class Menu extends Model
    {
        use HasFactory, SoftDeletes;

        /**
         * @var string
         */
        protected $table = 'menus';

        /**
         * @var string[]
         */
        protected $fillable = [
            'page_id',
            'sort',
            'name',
            'published',
        ];

        /**
         * Выборка всех записей
         *
         * @return array
         */
        private static function getAll(): array
        {
            return self::query()
                       ->select([
                           'page_id',
                           'name',
                       ])
                       ->where('published', 1)
                       ->orderBy('sort')
                       ->get()
                       ->toArray();
        }

        /**
         * Формирование массива главного меню
         *
         * @param array $res
         *
         * @return array
         */
        public static function getToArray(
            array $res = []
        ): array {
            foreach (
                self::getAll() as $key => $val
            ) {
                $res[$key] = [
                    'alias' => Page::getAliasByID($val['page_id']),
                    'name'  => $val['name'],
                ];
            }

            return empty($res) ? [] : $res;
        }
    }
