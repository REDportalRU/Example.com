<?php

    namespace App\Services\News;

    use App\Http\Controllers\Controller;
    use App\Models\Category;
    use App\Services\Settings\SettingsAdminService;
    use Dflydev\DotAccessData\Data;
    use Illuminate\Support\Str;
    use Inertia\Inertia;
    use Inertia\Response;

    class CategoriesService extends Controller
    {
        /**
         * Пагинация
         *
         * @var object|null
         */
        protected ?object $paginate = null;

        /**
         * Получение пагинации
         *
         * @param int $numPage
         *
         * @return $this
         */
        public function getPaginate(
            int $activePage,
            object $filterService
        ): CategoriesService {
            $this->paginate = Category::query()
                                      ->whereRaw(
                                          'name like ?',
                                          '%' . $filterService->search . '%'
                                      )
                                      ->orderBy($filterService->filter)
                                      ->paginate(
                                          $filterService->perPage,
                                          [
                                              'id',
                                              'sort',
                                              'alias',
                                              'name',
                                              'published',
                                              'created_at',
                                              'updated_at'
                                          ],
                                          'categories',
                                          $activePage
                                      );
            return $this;
        }

        /**
         * Обновление статуса переключателя публикации категории
         *
         * @param int|null $id
         * @param string   $published
         *
         * @return void
         */
        public static function updatePublich(
            int $id = null,
            string $published = 'false'
        ): void {
            Category::query()
                    ->where('id', $id)
                    ->update([
                        'published' => ($published == '1') ? false : true,
                    ]);
        }

        /**
         * Получение категории по ID
         *
         * @param $id
         *
         * @return CategoriesService
         */
        public function getCategoryForUpdate($id): CategoriesService
        {
            $category = Category::query()
                                ->where('id', $id)
                                ->select([
                                    'id',
                                    'sort',
                                    'alias',
                                    'name',
                                    'title',
                                    'description',
                                    'keywords',
                                    'published',
                                ])
                                ->first();

            $this->id              = $category->id;
            $this->sort            = $category->sort;
            $this->alias           = $category->alias;
            $this->name            = $category->name;
            $this->published       = $category->published;
            $this->titlePage       = $category->title;
            $this->descriptionPage = $category->description;
            $this->keywordsPage    = $category->keywords;

            return $this;
        }

        /**
         * Рендер Vue страницы
         *
         * @param string $route
         * @param object $infoPageService
         * @param object $filterService
         *
         * @return Response
         */
        public function InertiaRender(
            string $route,
            object $infoPageService,
            object $filterService
        ): Response {
            $settingsAdminService = new SettingsAdminService;
            $settingsAdmin        = $settingsAdminService->Path();

            return Inertia::render($route, [
                'title'            => $infoPageService->title,
                'description'      => $infoPageService->description,
                'keywords'         => $infoPageService->keywords,
                'menu'             => $infoPageService->menu,
                'breadcrumbsTitle' => $infoPageService->breadcrumbTitle,
                'breadcrumbs'      => $infoPageService->breadcrumbService->getForCategories(),
                'perPage'          => $filterService->perPage,
                'filter'           => $filterService->filter,
                'search'           => $filterService->search,
                'activePage'       => $filterService->activePage,
                'paginate'         => $this->paginate,
            ])->withViewData([
                'title'        => $infoPageService->title,
                'description'  => $infoPageService->description,
                'keywords'     => $infoPageService->keywords,
                'url_app'      => $settingsAdmin['url_app'],
                'url_template' => $settingsAdmin['url_template'],
            ]);
        }

        /**
         * Рендер страницы добавления категории
         *
         * @param string $route
         * @param object $infoPageService
         *
         * @return Response
         */
        public function InertiaRender_Add(
            string $route,
            object $infoPageService
        ): Response {
            $settingsAdminService = new SettingsAdminService;
            $settingsAdmin        = $settingsAdminService->Path();

            return Inertia::render($route, [
                'title'            => $infoPageService->title,
                'description'      => $infoPageService->description,
                'keywords'         => $infoPageService->keywords,
                'menu'             => $infoPageService->menu,
                'breadcrumbsTitle' => $infoPageService->breadcrumbTitle,
                'breadcrumbs'      => $infoPageService->breadcrumbService->getForCategoryAdd(),
            ])->withViewData([
                'title'        => $infoPageService->title,
                'description'  => $infoPageService->description,
                'keywords'     => $infoPageService->keywords,
                'url_app'      => $settingsAdmin['url_app'],
                'url_template' => $settingsAdmin['url_template'],
            ]);
        }

        /**
         * Рендер страницы редактирования категории
         *
         * @param string $route
         * @param object $infoPageService
         *
         * @return Response
         */
        public function InertiaRender_Update(
            string $route,
            object $infoPageService
        ): Response {
            $settingsAdminService = new SettingsAdminService;
            $settingsAdmin        = $settingsAdminService->Path();

            return Inertia::render($route, [
                'title'            => $infoPageService->title,
                'description'      => $infoPageService->description,
                'keywords'         => $infoPageService->keywords,
                'menu'             => $infoPageService->menu,
                'breadcrumbsTitle' => $infoPageService->breadcrumbTitle,
                'breadcrumbs'      => $infoPageService->breadcrumbService->getForCategoryUpdate(),
                'id'               => $this->id,
                'sort'             => $this->sort,
                'alias'            => $this->alias,
                'name'             => $this->name,
                'published'        => $this->published,
                'titlePage'        => $this->titlePage,
                'descriptionPage'  => $this->descriptionPage,
                'keywordsPage'     => $this->keywordsPage,
            ])->withViewData([
                'title'        => $infoPageService->title,
                'description'  => $infoPageService->description,
                'keywords'     => $infoPageService->keywords,
                'url_app'      => $settingsAdmin['url_app'],
                'url_template' => $settingsAdmin['url_template'],
            ]);
        }

        /**
         * Сохранение новой категории
         *
         * @param $categoryRequest
         *
         * @return void
         */
        public static function saveCategory($categoryRequest): void
        {
            Category::query()
                    ->insert([
                        'alias'       => $categoryRequest['alias']
                            ? $categoryRequest['alias']
                            : Str::slug($categoryRequest['name'], '-'),
                        'name'        => $categoryRequest['name'],
                        'title'       => $categoryRequest['titlePage'],
                        'description' => $categoryRequest['descriptionPage'],
                        'keywords'    => $categoryRequest['keywordsPage'],
                        'published'   => ($categoryRequest["published"] == 'true') ? true : false,
                        'created_at'  => date('Y-m-d H:i:s'),
                        'updated_at'  => date('Y-m-d H:i:s'),
                    ]);
        }

        /**
         * Обновление существующей категории
         *
         * @param $id
         * @param $categoryRequest
         *
         * @return void
         */
        public static function storeCategory($id, $categoryRequest): void
        {
            Category::query()
                    ->where('id', $id)
                    ->update([
                        'alias'       => $categoryRequest['alias']
                            ? $categoryRequest['alias']
                            : Str::slug($categoryRequest['name'], '-'),
                        'name'        => $categoryRequest['name'],
                        'title'       => $categoryRequest['titlePage'],
                        'description' => $categoryRequest['descriptionPage'],
                        'keywords'    => $categoryRequest['keywordsPage'],
                        'published'   => ($categoryRequest["published"] == 'true') ? true : false,
                    ]);
        }

        /**
         * Обновление существующей категории
         *
         * @param $id
         *
         * @return void
         */
        public static function deleteCategory($id): void
        {
            if (isset($id)) {
                Category::query()
                        ->where('id', $id)
                        ->delete();
            }
        }
    }
