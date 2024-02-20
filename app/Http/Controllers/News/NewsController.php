<?php

    namespace App\Http\Controllers\News;

    use App\Http\Controllers\Controller;
    use App\Http\Requests\News\NewsRequest;
    use App\Models\Images;
    use App\Services\AuthService;
    use App\Services\FilterService;
    use App\Services\InfoPageService;
    use App\Services\News\NewsService;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Http\Request;
    use Inertia\Response;

    class NewsController extends Controller
    {
        public function __construct()
        {
            $this->middleware('auth');
        }

        /**
         * Список всех новостей
         *
         * @param InfoPageService $infoPageService
         * @param FilterService   $filterService
         * @param NewsService     $newsService
         * @param Request         $request
         *
         * @return RedirectResponse|Response
         */
        public function index(
            InfoPageService $infoPageService,
            FilterService $filterService,
            NewsService $newsService,
            Request $request
        ): RedirectResponse|Response {
            if (AuthService::notVerification([4])) {
                return redirect()->route('statistic.home');
            }

            $infoPageService->setTitle('Новости | Example.com')
                            ->setDescription('Новости')
                            ->setKeywords('Новости')
                            ->setMenu('News')
                            ->setbreadcrumbTitle('Новости');

            $filterService->setPerPage($request["perPage"])
                          ->setFilterArray([
                              1 => 'id',
                              2 => 'name',
                              3 => 'alias',
                              4 => 'hits',
                              5 => 'published',
                              6 => 'created_at',
                              7 => 'updated_at',
                          ])
                          ->setFilter($request["filter"])
                          ->setSearch($request['search']);

            return $newsService->getPaginate($request['activePage'] ?? 1, $filterService, $request['category'] ?? 0)
                               ->InertiaRender(
                                   'News/News',
                                   $infoPageService,
                                   $filterService,
                                   $request['category'] ?? 0
                               );
        }

        /**
         * Обновление статуса переключателя публикации новости
         *
         * @return RedirectResponse
         */
        public function updatePubliched(): RedirectResponse
        {
            if (AuthService::notVerification([4])) {
                return redirect()->route('statistic.home');
            }

            NewsService::updatePublich(
                request()->id,
                request()->published
            );
            return redirect()->route('news.index', [
                'perPage'    => request()->perPage,
                'filter'     => request()->filter,
                'activePage' => request()->activePage,
                'search'     => request()->search,
            ]);
        }

        /**
         * Страница добавления новости
         *
         * @param InfoPageService $infoPageService
         * @param NewsService     $newsService
         *
         * @return RedirectResponse|Response
         */
        public function add(
            InfoPageService $infoPageService,
            NewsService $newsService
        ): RedirectResponse|Response {
            if (AuthService::notVerification([4])) {
                return redirect()->route('statistic.home');
            }

            $infoPageService->setTitle('Добавить новость | Example.com')
                            ->setDescription('Добавить новость')
                            ->setKeywords('Добавить новость')
                            ->setMenu('News')
                            ->setbreadcrumbTitle('Добавить новость');

            return $newsService->InertiaRender_Add(
                'News/NewsAdd',
                $infoPageService
            );
        }

        /**
         * Страница редактирования новости
         *
         * @param InfoPageService $infoPageService
         * @param NewsService     $newsService
         *
         * @return RedirectResponse|Response
         */
        public function update(
            InfoPageService $infoPageService,
            NewsService $newsService
        ): RedirectResponse|Response {
            if (AuthService::notVerification([4])) {
                return redirect()->route('statistic.home');
            }

            $infoPageService->setTitle('Редактировать новость | Example.com')
                            ->setDescription('Редактировать новость')
                            ->setKeywords('Редактировать новость')
                            ->setMenu('News')
                            ->setbreadcrumbTitle('Редактировать новость');

            return $newsService->getNewsForUpdate(request()->id)
                               ->InertiaRender_Update(
                                   'News/NewsUpdate',
                                   $infoPageService
                               );
        }

        /**
         * Сохранение новости
         *
         * @param NewsRequest $newsRequest
         *
         * @return RedirectResponse
         */
        public function save(
            NewsRequest $newsRequest
        ): RedirectResponse {
            if (AuthService::notVerification([4])) {
                return redirect()->route('statistic.home');
            }

            $news_id = NewsService::saveNews($newsRequest);

            // Добавление изображений
            $image_url = Images::uploadNewsMainImage($news_id);
            !$image_url ?: NewsService::uploadNewsMainImage($news_id, $image_url);

            return redirect()->route('news.index');
        }

        /**
         * Обновление новости
         *
         * @param NewsRequest $newsRequest
         *
         * @return RedirectResponse
         */
        public function store(
            NewsRequest $newsRequest
        ): RedirectResponse {
            if (AuthService::notVerification([4])) {
                return redirect()->route('statistic.home');
            }

            NewsService::storeNews(request()->id, $newsRequest);

            // Добавление изображений
            $image_url = Images::uploadNewsMainImage(request()->id);
            !$image_url ?: NewsService::uploadNewsMainImage(request()->id, $image_url);

            return redirect()->route('news.index');
        }

        /**
         * Удаление новости
         *
         * @return RedirectResponse
         */
        public function delete(): RedirectResponse
        {
            if (AuthService::notVerification([4])) {
                return redirect()->route('statistic.home');
            }

            if (isset(request()->id)) {
                NewsService::deleteNews(request()->id);
            }
            return redirect()->route('news.index', [
                'perPage'    => request()->perPage,
                'filter'     => request()->filter,
                'activePage' => request()->activePage,
                'search'     => request()->search,
            ]);
        }
    }