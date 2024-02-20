<?php

    namespace App\Http\Requests\News;

    use Illuminate\Foundation\Http\FormRequest;

    class NewsRequest extends FormRequest
    {

        /**
         * Маршрут, на который следует перенаправлять пользователей в случае сбоя проверки.
         *
         * @var string
         */
        // protected $redirectRoute = 'news.add';

        /**
         * Get the validation rules that apply to the request.
         *
         * @return string[]
         */
        public function rules(): array
        {
            return [
                'categories_id' => ['required', 'array', 'max:5000'],
                'tags_id'       => ['nullable', 'array', 'max:5000'],

                'name'  => ['required', 'string', 'max:150'],
                'alias' => ['nullable', 'string', 'max:150'],
                'text'  => ['nullable', 'string', 'max:50000'],

                'title'       => ['nullable', 'string', 'max:190'],
                'description' => ['nullable', 'string', 'max:190'],
                'keywords'    => ['nullable', 'string', 'max:190'],
                'published'   => ['required', 'string'],

                'dateNews' => ['nullable', 'string'],
                'timeNews' => ['nullable', 'string'],
            ];
        }

        /**
         * @return string[]
         */
        public function messages(): array
        {
            return [
                'categories_id.required' => 'Выберите категорию для новости.',
                'categories_id.array'    => 'Поле "Категория" имеет ошибочный формат.',
                'categories_id.max'      => 'Поле "Категория" не может быть длиннее 5000 символов',

                'tags_id.array' => 'Поле "Теги" имеет ошибочный формат.',
                'tags_id.max'   => 'Поле "Теги" не может быть длиннее 5000 символов',

                'name.required' => 'Введите наименование новости.',
                'name.string'   => 'Поле "Наименование" имеет ошибочный формат.',
                'name.max'      => 'Поле "Наименование" не может быть длиннее 150 символов',
                'alias.string'  => 'Поле "Алиас" имеет ошибочный формат.',
                'alias.max'     => 'Поле "Алиас" не может быть длиннее 150 символов',
                'text.string'   => 'Поле "Текст новости" имеет ошибочный формат.',
                'text.max'      => 'Поле "Текст новости" не может быть длиннее 50000 символов',

                'title.string'       => 'Поле "Title" имеет ошибочный формат.',
                'title.max'          => 'Поле "Title" не может быть длиннее 190 символов',
                'description.string' => 'Поле "Description" имеет ошибочный формат.',
                'description.max'    => 'Поле "Description" не может быть длиннее 190 символов',
                'keywords.string'    => 'Поле "Keywords" имеет ошибочный формат.',
                'keywords.max'       => 'Поле "Keywords" не может быть длиннее 190 символов',
                'published.required' => 'Выберите состояние переключателя публикации новости на сайте',
                'published.string'   => 'Поле "Публикация новости" имеет ошибочный формат.',
            ];
        }

        /**
         * Determine if the user is authorized to make this request.
         */
        public function authorize(): bool
        {
            return true;
        }

        /**
         * @return void
         */
        protected function prepareForValidation(): void
        {
        }
    }
