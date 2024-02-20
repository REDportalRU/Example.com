<?php

    namespace App\Models\Settings;

    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\SoftDeletes;
    use Illuminate\Support\Carbon;

    /**
     * App\Models\Settings\Sseti
     *
     * @property int         $id
     * @property string      $name        Название
     * @property string      $url         Url на соцсети
     * @property string      $icon        Иконка
     * @property string|null $description Описание
     * @property int         $status      Отображение
     * @property int         $head        Отображение в шапке
     * @property int         $foot        Отображение в подвале
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @property Carbon|null $deleted_at
     * @method static Builder|Sseti newModelQuery()
     * @method static Builder|Sseti newQuery()
     * @method static Builder|Sseti onlyTrashed()
     * @method static Builder|Sseti query()
     * @method static Builder|Sseti whereCreatedAt($value)
     * @method static Builder|Sseti whereDeletedAt($value)
     * @method static Builder|Sseti whereDescription($value)
     * @method static Builder|Sseti whereFoot($value)
     * @method static Builder|Sseti whereHead($value)
     * @method static Builder|Sseti whereIcon($value)
     * @method static Builder|Sseti whereId($value)
     * @method static Builder|Sseti whereName($value)
     * @method static Builder|Sseti whereStatus($value)
     * @method static Builder|Sseti whereUpdatedAt($value)
     * @method static Builder|Sseti whereUrl($value)
     * @method static Builder|Sseti withTrashed()
     * @method static Builder|Sseti withoutTrashed()
     * @mixin \Eloquent
     */
    class Sseti extends Model
    {
        use HasFactory, SoftDeletes;

        /**
         * @var string
         */
        protected $table = 'ssetis';

        /**
         * @var string[]
         */
        protected $fillable = [
            'sort',
            'name',
            'url',
            'icon',
            'description',
            'status',
            'head',
            'foot',
        ];

        /**
         * Формирование массива соц. сетей
         *
         * @return array
         */
        public static function getToArray(): array
        {
            $res[] = [];
            foreach (
                self::query()
                    ->select([
                        'sort',
                        'name',
                        'url',
                        'icon',
                        'description'
                    ])
                    ->orderBy('sort')
                    ->get()
                    ->toArray() as $key => $value
            ) {
                $res_array[$key] = ['sort' => $value['sort']];
                $res_array[$key] += ['name' => $value['name']];
                $res_array[$key] += ['url' => $value['url']];
                $res_array[$key] += ['icon' => $value['icon']];
                $res_array[$key] += ['description' => $value['description']];
            }
            return empty($res_array) ? [] : $res_array;
        }
    }
