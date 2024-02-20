<?php

    namespace App\Http\Controllers\Site;

    use App\Http\Controllers\Controller;
    use App\Http\Requests\Site\SsetiRequest;
    use App\Services\AuthService;
    use App\Services\FilterService;
    use App\Services\InfoPageService;
    use App\Services\Site\SsetiService;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Http\Request;
    use Inertia\Response;

    class SsetiController extends Controller
    {
        public function __construct()
        {
            $this->middleware('auth');
        }

        /**
         * Список всех соц. сетей
         *
         * @param InfoPageService $infoPageService
         * @param FilterService   $filterService
         * @param SsetiService    $ssetiService
         * @param Request         $request
         *
         * @return RedirectResponse|Response
         */
        public function index(
            InfoPageService $infoPageService,
            FilterService $filterService,
            SsetiService $ssetiService,
            Request $request
        ): RedirectResponse|Response {
            if (AuthService::notVerification([3, 4])) {
                return redirect()->route('statistic.home');
            }

            $infoPageService->setTitle('Соц. сети | Example.com')
                            ->setDescription('Соц. сети')
                            ->setKeywords('Соц. сети')
                            ->setMenu('Sseti')
                            ->setbreadcrumbTitle('Соц. сети');

            $filterService->setPerPage($request["perPage"])
                          ->setFilterArray([
                              1 => 'id',
                              2 => 'name',
                              3 => 'status',
                              4 => 'created_at',
                              5 => 'updated_at',
                          ])
                          ->setFilter($request["filter"])
                          ->setSearch($request['search']);

            return $ssetiService->getPaginate($request['activePage'] ?? 1, $filterService)
                                ->InertiaRender(
                                    'Site/Sseti',
                                    $infoPageService,
                                    $filterService
                                );
        }

        /**
         * Обновление статуса переключателя публикации соц. сети
         *
         * @return RedirectResponse
         */
        public function updatePubliched(): RedirectResponse
        {
            if (AuthService::notVerification([3, 4])) {
                return redirect()->route('statistic.home');
            }

            SsetiService::updatePublich(
                request()->id,
                request()->status
            );
            return redirect()->route('sseti.index', [
                'perPage'    => request()->perPage,
                'filter'     => request()->filter,
                'activePage' => request()->activePage,
                'search'     => request()->search,
            ]);
        }

        /**
         * Страница добавления соц. сети
         *
         * @param InfoPageService $infoPageService
         * @param SsetiService    $ssetiService
         *
         * @return RedirectResponse|Response
         */
        public function add(
            InfoPageService $infoPageService,
            SsetiService $ssetiService
        ): RedirectResponse|Response {
            if (AuthService::notVerification([3, 4])) {
                return redirect()->route('statistic.home');
            }

            $infoPageService->setTitle('Добавить cоц. сеть | Example.com')
                            ->setDescription('Добавить cоц. сеть')
                            ->setKeywords('Добавить cоц. сеть')
                            ->setMenu('Sseti')
                            ->setbreadcrumbTitle('Добавить cоц. сеть');

            return $ssetiService->InertiaRender_Add(
                'Site/SsetiAdd',
                $infoPageService
            );
        }

        /**
         * Страница редактирования соц. сети
         *
         * @param InfoPageService $infoPageService
         * @param SsetiService    $ssetiService
         *
         * @return RedirectResponse|Response
         */
        public function update(
            InfoPageService $infoPageService,
            SsetiService $ssetiService
        ): RedirectResponse|Response {
            if (AuthService::notVerification([3, 4])) {
                return redirect()->route('statistic.home');
            }

            $infoPageService->setTitle('Редактировать cоц. сеть | Example.com')
                            ->setDescription('Редактировать cоц. сеть')
                            ->setKeywords('Редактировать cоц. сеть')
                            ->setMenu('Sseti')
                            ->setbreadcrumbTitle('Редактировать cоц. сеть');

            return $ssetiService->getSsetiForUpdate(request()->id)
                                ->InertiaRender_Update(
                                    'Site/SsetiUpdate',
                                    $infoPageService
                                );
        }

        /**
         * Сохранение новой соц. сети
         *
         * @param SsetiRequest $ssetiRequest
         *
         * @return RedirectResponse
         */
        public function save(
            SsetiRequest $ssetiRequest
        ): RedirectResponse {
            if (AuthService::notVerification([3, 4])) {
                return redirect()->route('statistic.home');
            }

            SsetiService::saveSseti($ssetiRequest);
            return redirect()
                ->route('sseti.index');
        }

        /**
         * Сохранение существующей соц. сети
         *
         * @param SsetiRequest $SsetiRequest
         *
         * @return RedirectResponse
         */
        public function store(
            SsetiRequest $SsetiRequest
        ): RedirectResponse {
            if (AuthService::notVerification([3, 4])) {
                return redirect()->route('statistic.home');
            }

            SsetiService::storeSseti(request()->id, $SsetiRequest);
            return redirect()
                ->route('sseti.index');
        }

        /**
         * Удаление существующей соц. сети
         *
         * @return RedirectResponse
         */
        public function delete(): RedirectResponse
        {
            if (AuthService::notVerification([3, 4])) {
                return redirect()->route('statistic.home');
            }

            if (isset(request()->id)) {
                SsetiService::deleteSseti(request()->id);
            }
            return redirect()->route('sseti.index', [
                'perPage'    => request()->perPage,
                'filter'     => request()->filter,
                'activePage' => request()->activePage,
                'search'     => request()->search,
            ]);
        }
    }
