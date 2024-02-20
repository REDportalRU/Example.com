<?php

    namespace App\Http\Controllers\Site;

    use App\Http\Controllers\Controller;
    use App\Http\Requests\Site\PagesRequest;
    use App\Services\AuthService;
    use App\Services\FilterService;
    use App\Services\InfoPageService;
    use App\Services\Site\PagesService;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Http\Request;
    use Inertia\Response;

    class PagesController extends Controller
    {
        public function __construct()
        {
            $this->middleware('auth');
        }

        /**
         * Список всех страниц
         *
         * @param InfoPageService $infoPageService
         * @param FilterService   $filterService
         * @param PagesService    $pagesService
         * @param Request         $request
         *
         * @return RedirectResponse|Response
         */
        public function index(
            InfoPageService $infoPageService,
            FilterService $filterService,
            PagesService $pagesService,
            Request $request
        ): RedirectResponse|Response {
            if (AuthService::notVerification([3, 4])) {
                return redirect()->route('statistic.home');
            }

            $infoPageService->setTitle('Страницы | Example.com')
                            ->setDescription('Страницы')
                            ->setKeywords('Страницы')
                            ->setMenu('Pages')
                            ->setbreadcrumbTitle('Страницы');

            $filterService->setPerPage($request["perPage"])
                          ->setFilterArray([
                              1 => 'id',
                              2 => 'name',
                              3 => 'alias',
                              4 => 'published',
                              5 => 'created_at',
                              6 => 'updated_at',
                          ])
                          ->setFilter($request["filter"])
                          ->setSearch($request['search']);

            return $pagesService->getPaginate($request['activePage'] ?? 1, $filterService)
                                ->InertiaRender(
                                    'Site/Pages',
                                    $infoPageService,
                                    $filterService
                                );
        }

        /**
         * Обновление статуса переключателя публикации страницы
         *
         * @return RedirectResponse
         */
        public function updatePubliched(): RedirectResponse
        {
            if (AuthService::notVerification([3, 4])) {
                return redirect()->route('statistic.home');
            }

            PagesService::updatePublich(
                request()->id,
                request()->published
            );
            return redirect()->route('pages.index', [
                'perPage'    => request()->perPage,
                'filter'     => request()->filter,
                'activePage' => request()->activePage,
                'search'     => request()->search,
            ]);
        }

        /**
         * Страница добавления страницы
         *
         * @param InfoPageService $infoPageService
         * @param PagesService    $pagesService
         *
         * @return RedirectResponse|Response
         */
        public function add(
            InfoPageService $infoPageService,
            PagesService $pagesService
        ): RedirectResponse|Response {
            if (AuthService::notVerification([3, 4])) {
                return redirect()->route('statistic.home');
            }

            $infoPageService->setTitle('Добавить страницу | Example.com')
                            ->setDescription('Добавить страницу')
                            ->setKeywords('Добавить страницу')
                            ->setMenu('Pages')
                            ->setbreadcrumbTitle('Добавить страницу');

            return $pagesService->InertiaRender_Add(
                'Site/PageAdd',
                $infoPageService
            );
        }

        /**
         * Страница редактирования страницы
         *
         * @param InfoPageService $infoPageService
         * @param PagesService    $pagesService
         *
         * @return RedirectResponse|Response
         */
        public function update(
            InfoPageService $infoPageService,
            PagesService $pagesService
        ): RedirectResponse|Response {
            if (AuthService::notVerification([3, 4])) {
                return redirect()->route('statistic.home');
            }

            $infoPageService->setTitle('Редактировать страницу | Example.com')
                            ->setDescription('Редактировать страницу')
                            ->setKeywords('Редактировать страницу')
                            ->setMenu('Pages')
                            ->setbreadcrumbTitle('Редактировать страницу');

            return $pagesService->getPageForUpdate(request()->id)
                                ->InertiaRender_Update(
                                    'Site/PageUpdate',
                                    $infoPageService
                                );
        }

        /**
         * Сохранение новой страницы
         *
         * @param PagesRequest $pagesRequest
         *
         * @return RedirectResponse
         */
        public function save(
            PagesRequest $pagesRequest
        ): RedirectResponse {
            if (AuthService::notVerification([3, 4])) {
                return redirect()->route('statistic.home');
            }

            PagesService::savePage($pagesRequest);
            return redirect()->route('pages.index');
        }

        /**
         * Сохранение существующей страницы
         *
         * @param PagesRequest $pagesRequest
         *
         * @return RedirectResponse
         */
        public function store(
            PagesRequest $pagesRequest
        ): RedirectResponse {
            if (AuthService::notVerification([3, 4])) {
                return redirect()->route('statistic.home');
            }

            PagesService::storePage(request()->id, $pagesRequest);
            return redirect()->route('pages.index');
        }

        /**
         * Удаление существующей страницы
         *
         * @return RedirectResponse
         */
        public function delete(): RedirectResponse
        {
            if (AuthService::notVerification([3, 4])) {
                return redirect()->route('statistic.home');
            }

            if (isset(request()->id)) {
                PagesService::deletePage(request()->id);
            }
            return redirect()->route('pages.index', [
                'perPage'    => request()->perPage,
                'filter'     => request()->filter,
                'activePage' => request()->activePage,
                'search'     => request()->search,
            ]);
        }
    }