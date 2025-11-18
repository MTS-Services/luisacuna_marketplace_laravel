<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\Audit;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
class AuditingController extends Controller implements HasMiddleware
{
    protected $masterView = 'backend.admin.pages.auditing';


public static function middleware(): array
        {
            return [
                'auth:admin', // Applies 'auth:admin' to all methods

                // Permission middlewares using the Middleware class
                new Middleware('permission:admin-list', only: ['index']),
                new Middleware('permission:admin-view', only: ['view']),
            ];
        }
    public function index()
    {
        return view($this->masterView);
    }
    /**
     * Display the specified resource.
     */
    public function view(string $id)
    {
        $data = Audit::find($id);
        if (!$data) {
            abort(404);
        }
        return view($this->masterView, [
            'data' => $data
        ]);
    }
}
