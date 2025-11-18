<?php

    namespace App\Http\Controllers\Backend\Admin\GameManagement;

    use App\Http\Controllers\Controller;
    use App\Services\CategoryService;
    use Illuminate\View\View;
    use Illuminate\Routing\Controllers\HasMiddleware;
    use Illuminate\Routing\Controllers\Middleware;

    class CategoryController extends Controller implements HasMiddleware
    {

        protected CategoryService $service;
        protected $masterView = 'backend.admin.pages.game-management.category';
        public function __construct(CategoryService $service)
        {
            $this->service = $service;
        }

         public static function middleware(): array
        {
            return [
                'auth:admin', // Applies 'auth:admin' to all methods

                // Permission middlewares using the Middleware class
                new Middleware('permission:admin-list', only: ['index']),
                new Middleware('permission:admin-create', only: ['create']),
                new Middleware('permission:admin-edit', only: ['edit']),
                new Middleware('permission:admin-show', only: ['show']),
                new Middleware('permission:admin-trash', only: ['trash']),
            ];
        }


        public function index()
        {
            return view($this->masterView);
        }

        public function create()
        {
            return view($this->masterView);
        }

        public function edit($id):View
        {

            $data = $this->service->findData(decrypt($id));
            return view($this->masterView , [
                'data'  => $data
            ]);
        }
        public function show($id)
        {


            $data = $this->service->findData(decrypt($id));
            if (!$data) {
                abort(404);
            }

            return view($this->masterView , [
                'data'  => $data
            ]);
        }

        public function trash(){

            return view($this->masterView);

        }

}
