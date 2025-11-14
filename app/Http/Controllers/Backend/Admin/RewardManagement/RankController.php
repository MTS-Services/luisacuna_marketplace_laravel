<?php

    namespace App\Http\Controllers\Backend\Admin\RewardManagement;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use App\Services\RankService;

    class RankController extends Controller
    {
        protected $masterview = 'backend.admin.pages.reward-management.rank';

        protected RankService $service;
        public function __construct(RankService $service)
        {
            $this->service = $service;
        }

        public function index()
        {
            return view($this->masterview);
        }

        public function show($id)
        {
            $data = $this->service->findData(decrypt($id));
            if (!$data) {
                abort(404);
            }

            // Pass it to the Blade view
            return view('backend.admin.pages.reward-management.rank', compact('data'));
        }
        
        public function create()
        {
            return view($this->masterview);
        }
}
