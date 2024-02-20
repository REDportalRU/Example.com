<?php

    namespace App\Http\Requests\Site;

    use Illuminate\Foundation\Http\FormRequest;

    class PagesRequest extends FormRequest
    {

        /**
         * Маршрут, на который следует перенаправлять пользователей в случае сбоя проверки.
         *
         * @var string
         */
        // protected $redirectRoute = 'users.add';

        /**
         * Get the validation rules that apply to the request.
         *
         * @return string[]
         */
        public function rules(): array
        {
            return [
                'name'        => ['required', 'string', 'max:150'],
                'alias'       => ['nullable', 'string', 'max:150'],
                'text'        => ['nullable', 'string', 'max:10000'],
                'title'       => ['nullable', 'string', 'max:190'],
                'description' => ['nullable', 'string', 'max:190'],
                'keywords'    => ['nullable', 'string', 'max:190'],
                'published'   => ['required', 'string'],
            ];
        }

        /**
         * @return string[]
         */
        public function messages(): array
        {
            return [
                'name.required'      => 'Введите наименование страницы.',
                'name.string'        => 'Поле "Наименование" имеет ошибочный формат.',
                'name.max'           => 'Поле "Наименование" не может быть длиннее 150 символов',
                'alias.string'       => 'Поле "Алиас" имеет ошибочный формат.',
                'alias.max'          => 'Поле "Алиас" не может быть длиннее 150 символов',
                'text.string'        => 'Поле "Текст страницы" имеет ошибочный формат.',
                'text.max'           => 'Поле "Текст страницы" не может быть длиннее 150 символов',
                'title.string'       => 'Поле "Title" имеет ошибочный формат.',
                'title.max'          => 'Поле "Title" не может быть длиннее 190 символов',
                'description.string' => 'Поле "Description" имеет ошибочный формат.',
                'description.max'    => 'Поле "Description" не может быть длиннее 190 символов',
                'keywords.string'    => 'Поле "Keywords" имеет ошибочный формат.',
                'keywords.max'       => 'Поле "Keywords" не может быть длиннее 190 символов',
                'published.required' => 'Выберите состояние переключателя публикации категории на сайте',
                'published.string'   => 'Поле "Публикация категории" имеет ошибочный формат.',
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
