<?php

namespace App\Http\Controllers\Backend\Admin\GameManagement;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Services\Game\GameService;

class GameController extends Controller
{
    //
    protected GameService $gameService;

    public Game $game ;
    public function __construct(GameService $gameService)
    {
        $this->gameService = $gameService;
    }
    public $masterView = 'backend.admin.pages.game-management.game.index';
    public function index()
    {
        return view($this->masterView);
    }

    public function create()
    {
        return view($this->masterView);
    }

    public function show($id)
    {
        $this->game = $this->gameService->findOrFail($id);

        return view($this->masterView, [
            'game' => $this->game,
        ]);
    }

    public function trash()
    {
        return view($this->masterView);
    }
}
