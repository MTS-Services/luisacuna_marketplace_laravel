<?php

namespace App\Http\Controllers\Backend\Admin\GameManagement;

use App\Http\Controllers\Controller;
use App\Services\RarityService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Rarity;
use App\Models\Game;


class RarityController extends Controller
{

   protected $masterView = 'backend.admin.pages.game-management.rarity';


    protected RarityService $service;
        public function __construct(RarityService $service)
        {
            $this->service = $service;
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

       public function trash()
        {
            $data = $this->service->getTrash();

            return view($this->masterView, ['page' => 'admin.gm.rarity.trash']);

        }

}
