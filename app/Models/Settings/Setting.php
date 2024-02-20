<?php

    namespace App\Models\Settings;

    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\SoftDeletes;
    use Illuminate\Support\Carbon;

    /**
     * App\Models\Settings\Setting
     *
     * @property int         $id
     * @property string      $name  Название
     * @property string      $value Значение
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @property Carbon|null $deleted_at
     * @method static Builder|Setting newModelQuery()
     * @method static Builder|Setting newQuery()
     * @method static Builder|Setting onlyTrashed()
     * @method static Builder|Setting query()
     * @method static Builder|Setting whereCreatedAt($value)
     * @method static Builder|Setting whereDeletedAt($value)
     * @method static Builder|Setting whereId($value)
     * @method static Builder|Setting whereName($value)
     * @method static Builder|Setting whereUpdatedAt($value)
     * @method static Builder|Setting whereValue($value)
     * @method static Builder|Setting withTrashed()
     * @method static Builder|Setting withoutTrashed()
     * @mixin \Eloquent
     */
    class Setting extends Model
    {
        use HasFactory, SoftDeletes;

        /**
         * @var string
         */
        protected $table = 'settings';

        /**
         * @var string[]
         */
        protected $fillable = [
            'name',
            'value',
        ];

        /**
         * Формирование массива настроек проекта
         *
         * @param array $res_array
         *
         * @return array
         */
        public static function getToArray(array $res_array = []): array
        {
            foreach (
                self::query()->select([
                    'name',
                    'value'
                ])->get()->toArray() as $value
            ) {
                $res_array += [$value['name'] => $value['value']];
            }
            $res_array += ['logo_new' => null];
            return empty($res_array) ? [] : $res_array;
        }
    }
