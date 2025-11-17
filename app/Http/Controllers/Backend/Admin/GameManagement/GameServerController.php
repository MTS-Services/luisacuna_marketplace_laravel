<?php

namespace App\Http\Controllers\Backend\Admin\GameManagement;

use App\Http\Controllers\Controller;
use App\Models\GameServer;
use App\Services\GameServerService;

class GameServerController extends Controller
{
    public function __construct(protected GameServerService $service)
    {
     
    }
    
    //
    public $master = 'backend.admin.pages.game-management.game_server';

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
