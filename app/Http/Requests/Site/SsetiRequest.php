<?php

    namespace App\Http\Requests\Site;

    use Illuminate\Foundation\Http\FormRequest;

    class SsetiRequest extends FormRequest
    {

        /**
         * Маршрут, на который следует перенаправлять пользователей в случае сбоя проверки.
         *
         * @var string
         */
        // protected $redirectRoute = 'sseti.add';

        /**
         * Get the validation rules that apply to the request.
         *
         * @return string[]
         */
        public function rules(): array
        {
            return [
                'name'    => ['required', 'string', 'max:50'],
                'url'     => ['required', 'url', 'max:250'],
                'icon'    => ['required', 'string', 'max:250'],
                'descrip' => ['nullable', 'string', 'max:250'],
                'status'  => ['required', 'string'],
                'head'    => ['required', 'string'],
                'foot'    => ['required', 'string'],
            ];
        }

        /**
         * @return string[]
         */
        public function messages(): array
        {
            return [
                'name.required'   => 'Введите наименование соц. сети.',
                'name.string'     => 'Поле "Наименование" имеет ошибочный формат.',
                'name.max'        => 'Наименование соц. сети не может быть длиннее 50 символов',
                'url.required'    => 'Введите url соц. сети.',
                'url.url'         => 'Поле "Url" имеет ошибочный формат.',
                'url.max'         => 'Url соц. сети не может быть длиннее 250 символов',
                'icon.required'   => 'Укажите иконку соц. сети.',
                'icon.string'     => 'Поле "Иконка" имеет ошибочный формат.',
                'icon.max'        => 'Поле "Иконка" не может быть длиннее 250 символов',
                'descrip.string'  => 'Поле "Публикация на сайте" имеет ошибочный формат.',
                'descrip.max'     => 'Url соц. сети не может быть длиннее 250 символов',
                'status.required' => 'Выберите состояние переключателя публикации соц. сети на сайте',
                'status.string'   => 'Поле "Публикация на сайте" имеет ошибочный формат.',
                'head.required'   => 'Выберите состояние переключателя места отображения соц. сети на сайте',
                'head.string'     => 'Поле "Отобразить вверху" имеет ошибочный формат.',
                'foot.required'   => 'Выберите состояние переключателя места отображения соц. сети на сайте',
                'foot.string'     => 'Поле "Отобразить внизу" имеет ошибочный формат.',
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
            //
        }
    }
