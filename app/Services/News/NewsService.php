<?php

    namespace App\Services\News;

    use App\Http\Controllers\Controller;
    use App\Models\Category;
    use App\Models\News;
    use App\Models\Tag;
    use App\Services\Settings\SettingsAdminService;
    use Carbon\Carbon;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Str;
    use Inertia\Inertia;
    use Inertia\Response;

    class NewsService extends Controller
    {
        /**
         * Пагинация
         *
         * @var object|null
         */
        protected ?object $paginate  = null;
        private array     $cat_array = [];

        /**
         * Получение пагинации
         *
         * @param int    $activePage
         * @param object $filterService
         *
         * @return $this
         */
        public function getPaginate(
            int $activePage,
            object $filterService,
            int $category,
        ): NewsService {
            if ($category == 0) {
                $this->paginate = News::query()
                                      ->whereRaw(
                                          'name like ?',
                                          '%' . $filterService->search . '%'
                                      )
                                      ->orderBy($filterService->filter, 'desc')
                                      ->paginate(
                                          $filterService->perPage,
                                          [
                                              'id',
                                              'alias',
                                              'name',
                                              'text',
                                              'categories_id',
                                              'tags_id',
                                              'title',
                                              'main_image',
                                              'hits',
                                              'description',
                                              'keywords',
                                              'published',
                                              'created_at',
                                              'updated_at'
                                          ],
                                          'news',
                                          $activePage
                                      );
            } else {
                // Подбор категорий
                News::query()
                    ->select(['id', 'categories_id'])
                    ->chunk(100, function ($news) use ($category) {
                        foreach ($news as $value) {
                            $cat_id = json_decode($value->categories_id, true);
                            foreach ($cat_id as $val) {
                                if (intval($val['id']) == $category) {
                                    $this->cat_array[] = intval($value['id']);
                                }
                            }
                        }
                    });

                $this->paginate = News::query()
                                      ->whereRaw(
                                          'name like ?',
                                          '%' . $filterService->search . '%'
                                      )
                                      ->whereIn('id', $this->cat_array)
                                      ->orderBy($filterService->filter, 'desc')
                                      ->paginate(
                                          $filterService->perPage,
                                          [
                                              'id',
                                              'alias',
                                              'name',
                                              'text',
                                              'categories_id',
                                              'tags_id',
                                              'title',
                                              'main_image',
                                              'hits',
                                              'description',
                                              'keywords',
                                              'published',
                                              'created_at',
                                              'updated_at'
                                          ],
                                          'news',
                                          $activePage
                                      );
            }
            return $this;
        }

        /**
         * Обновление статуса переключателя публикации новости
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
            News::query()
                ->where('id', $id)
                ->update([
                    'published' => ($published == '1') ? false : true,
                ]);
        }

        /**
         * Получение новости по ID
         *
         * @param $id
         *
         * @return NewsService
         */
        public function getNewsForUpdate($id): NewsService
        {
            $news = News::query()
                        ->where('id', $id)
                        ->select([
                            'id',
                            'alias',
                            'name',
                            'text',
                            'main_image',
                            'categories_id',
                            'tags_id',
                            'title',
                            'description',
                            'keywords',
                            'published',
                            'created_at',
                        ])
                        ->first();

            $this->id            = $news->id;
            $this->alias         = $news->alias;
            $this->name          = $news->name;
            $this->text          = $news->text;
            $this->categories_id = json_decode($news->categories_id, true);
            $this->tags_id       = json_decode($news->tags_id, true);
            $this->title         = $news->title;
            $this->main_image    = $news->main_image;
            $this->description   = $news->description;
            $this->keywords      = $news->keywords;
            $this->published     = $news->published;
            $date_time           = explode(' ', $news->created_at);
            $this->dateNews      = $date_time[0];
            $this->timeNews      = $date_time[1];

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
            object $filterService,
            int $category,
        ): Response {
            $settingsAdminService = new SettingsAdminService;
            $settingsAdmin        = $settingsAdminService->Path();

            return Inertia::render($route, [
                'title'            => $infoPageService->title,
                'description'      => $infoPageService->description,
                'keywords'         => $infoPageService->keywords,
                'menu'             => $infoPageService->menu,
                'breadcrumbsTitle' => $infoPageService->breadcrumbTitle,
                'breadcrumbs'      => $infoPageService->breadcrumbService->getForNews(),
                'perPage'          => $filterService->perPage,
                'filter'           => $filterService->filter,
                'search'           => $filterService->search,
                'activePage'       => $filterService->activePage,
                'paginate'         => $this->paginate,
                'categories'       => Category::query()->select(['id', 'name'])->get()->toArray(),
                'category'         => $category,
            ])->withViewData([
                'title'        => $infoPageService->title,
                'description'  => $infoPageService->description,
                'keywords'     => $infoPageService->keywords,
                'url_app'      => $settingsAdmin['url_app'],
                'url_template' => $settingsAdmin['url_template'],
            ]);
        }

        /**
         * Рендер страницы добавления новости
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
                'breadcrumbs'      => $infoPageService->breadcrumbService->getForNewsAdd(),
                'categories'       => Category::query()
                                              ->select([
                                                  'id',
                                                  'name'
                                              ])
                                              ->get()
                                              ->toArray(),
                'tags'             => Tag::query()
                                         ->select([
                                             'id',
                                             'name'
                                         ])
                                         ->get()
                                         ->toArray(),
            ])->withViewData([
                'title'        => $infoPageService->title,
                'description'  => $infoPageService->description,
                'keywords'     => $infoPageService->keywords,
                'url_app'      => $settingsAdmin['url_app'],
                'url_template' => $settingsAdmin['url_template'],
            ]);
        }

        /**
         * Рендер страницы редактирования новости
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
                'breadcrumbs'      => $infoPageService->breadcrumbService->getForNewsUpdate(),
                'id'               => $this->id,
                'alias'            => $this->alias,
                'name'             => $this->name,
                'text'             => $this->text,
                'main_image'       => $this->main_image,
                'categories_id'    => $this->categories_id,
                'categories'       => Category::query()
                                              ->select([
                                                  'id',
                                                  'name'
                                              ])
                                              ->get()
                                              ->toArray(),
                'tags_id'          => $this->tags_id,
                'tags'             => Tag::query()
                                         ->select([
                                             'id',
                                             'name'
                                         ])
                                         ->get()
                                         ->toArray(),
                'titlePage'        => $this->title,
                'descriptionPage'  => $this->description,
                'keywordsPage'     => $this->keywords,
                'published'        => $this->published,
                'dateNews'         => $this->dateNews,
                'timeNews'         => $this->timeNews,
            ])->withViewData([
                'title'        => $infoPageService->title,
                'description'  => $infoPageService->description,
                'keywords'     => $infoPageService->keywords,
                'url_app'      => $settingsAdmin['url_app'],
                'url_template' => $settingsAdmin['url_template'],
            ]);
        }

        /**
         * Предобразованby
         *
         * @param string|null $dateNews
         * @param string|null $timeNews
         *
         * @return string
         */
        public static function setDateTime(
            string|null $dateNews,
            string|null $timeNews,
        ): string {
            return $dateNews != null
                ? $timeNews != null
                    ? $dateNews . ' ' . $timeNews
                    : $dateNews . ' 00:00:00'
                : Carbon::now()->toDateTimeString();
        }

        /**
         * Сохранение новости
         *
         * @param $newsRequest
         *
         * @return int
         */
        public static function saveNews(
            $newsRequest
        ): int {
            return DB::table('news')->insertGetId([
                'name'          => $newsRequest['name'],
                'alias'         => ($newsRequest['alias'])
                    ? $newsRequest['alias']
                    : Str::slug($newsRequest['name'], '-'),
                'text'          => $newsRequest['text'],
                'categories_id' => json_encode($newsRequest['categories_id'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                'tags_id'       => json_encode($newsRequest['tags_id'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                'title'         => $newsRequest['titlePage'],
                'description'   => $newsRequest['descriptionPage'],
                'keywords'      => $newsRequest['keywordsPage'],
                'published'     => ($newsRequest["published"] == '1') ? true : false,
                'created_at'    => NewsService::setDateTime($newsRequest["dateNews"], $newsRequest["timeNews"]),
            ]);
        }

        /**
         * Обновление новости
         *
         * @param $id
         * @param $newsRequest
         *
         * @return void
         */
        public
        static function storeNews(
            $id,
            $newsRequest
        ): void {
            News::query()
                ->where('id', $id)
                ->update([
                    'name'          => $newsRequest['name'],
                    'alias'         => ($newsRequest['alias'])
                        ? $newsRequest['alias']
                        : Str::slug($newsRequest['name'], '-'),
                    'text'          => $newsRequest['text'],
                    'categories_id' => json_encode($newsRequest['categories_id'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                    'tags_id'       => json_encode($newsRequest['tags_id'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                    'title'         => $newsRequest['titlePage'],
                    'description'   => $newsRequest['descriptionPage'],
                    'keywords'      => $newsRequest['keywordsPage'],
                    'published'     => ($newsRequest["published"] == 'true') ? true : false,
                    'created_at'    => NewsService::setDateTime($newsRequest["dateNews"], $newsRequest["timeNews"]),
                ]);
        }

        /**
         * Удаление новости
         *
         * @param $id
         *
         * @return void
         */
        public
        static function deleteNews(
            $id
        ): void {
            if (isset($id)) {
                News::query()
                    ->where('id', $id)
                    ->delete();
            }
        }

        /**
         * Замена логотипа сайта
         *
         * @param int    $news_id
         * @param string $image_url
         *
         * @return bool|int
         */
        public
        static function uploadNewsMainImage(
            int $news_id,
            string $image_url
        ): bool|int {
            return News::query()
                       ->where('id', $news_id)
                       ->update([
                           'main_image' => $image_url
                       ]);
        }
    }
