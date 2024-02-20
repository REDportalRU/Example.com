<?php

    namespace App\Services;

    use App\Http\Controllers\Controller;

    class InfoPageService extends Controller
    {
        /**
         * Метатеги
         *
         * @var string
         */
        public string $title       = '';
        public string $description = '';
        public string $keywords    = '';

        /**
         * Активный пункт меню
         *
         * @var string
         */
        public string $menu = '';

        /**
         * Заголовок для Breadcrumb
         *
         * @var string
         */
        public string $breadcrumbTitle = '';

        /**
         * Ссылки для Breadcrumb
         *
         * @var BreadcrumbService
         */
        public ?object $breadcrumbService;

        public function __construct()
        {
            $this->breadcrumbService = new BreadcrumbService();
        }

        /**
         * Установка Title
         *
         * @param string $title
         *
         * @return InfoPageService
         */
        public function setTitle(string $title): InfoPageService
        {
            $this->title = $title;
            return $this;
        }

        /**
         * Установка Description
         *
         * @param string $description
         *
         * @return InfoPageService
         */
        public function setDescription(string $description): InfoPageService
        {
            $this->description = $description;
            return $this;
        }

        /**
         * Установка Keywords
         *
         * @param string $keywords
         *
         * @return InfoPageService
         */
        public function setKeywords(string $keywords): InfoPageService
        {
            $this->keywords = $keywords;
            return $this;
        }

        /**
         * Установка пункта меню
         *
         * @param string $menu
         *
         * @return InfoPageService
         */
        public function setMenu(string $menu): InfoPageService
        {
            $this->menu = $menu;
            return $this;
        }

        /**
         * Установка заголовка Breadcrumb
         *
         * @param string $breadcrumbTitle
         *
         * @return $this
         */
        public function setbreadcrumbTitle(string $breadcrumbTitle): InfoPageService
        {
            $this->breadcrumbTitle = $breadcrumbTitle;
            return $this;
        }
    }
