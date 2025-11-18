<?php

namespace App\Http\Controllers\Backend\Admin\GameManagement;

use App\Http\Controllers\Controller;
use App\Services\ServerService;
use GuzzleHttp\Middleware;

class ServerController extends Controller
{
    public function __construct(protected ServerService $service)
    {

    }

    //
    public $master = 'backend.admin.pages.game-management.server';

    public static function middleware(): array
        {
            return [
                'auth:admin', // Applies 'auth:admin' to all methods

                // Permission middlewares using the Middleware class
                new Middleware('permission:admin-list', only: ['index']),
                new Middleware('permission:admin-create', only: ['create']),
            ];
        }

    public function index(){

        return view($this->master);
    }

    public function create(){

        return view($this->master);

    }

    public function edit($encryptedId){

        $data = $this->service->findData(decrypt($encryptedId));

        if(! $data){
            abort(404);
        }


        return view($this->master, [

            'data' => $data,
        ]);

    }

    public function show($encryptedId){


        $data = $this->service->findData(decrypt($encryptedId));


        if(! $data){
            abort(404);
        }

        return view($this->master, [
            'data' => $data
        ]);
    }

    public function trash(){

        return view($this->master);

    }
}
