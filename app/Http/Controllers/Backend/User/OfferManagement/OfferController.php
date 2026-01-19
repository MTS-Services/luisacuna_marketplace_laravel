<?php

namespace App\Http\Controllers\Backend\User\OfferManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    protected $masterView = 'backend.user.pages.offer-management.offer';





    public function create()
    {
        return view($this->masterView);
    }

    
    public function edit($encrypted_id){

        return view($this->masterView, compact('encrypted_id'));
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     return view($this->masterView);
    // }

    /**
     * Display the specified resource.
     */


    // public function show(string $encryptedId)
    // {
    //     $data = $this->service->findData(decrypt($encryptedId));
    //     if (!$data) {
    //         abort(404);
    //     }
    //     return view($this->masterView, [
    //         'data' => $data
    //     ]);
    // }
    /**
     * Show the form for editing the specified resource.
     */

    // public function edit(string $encryptedId)
    // {
    //     $data = $this->service->findData(decrypt($encryptedId));
    //     if (!$data) {
    //         abort(404);
    //     }
    //     return view($this->masterView, [
    //         'data' => $data
    //     ]);
    // }

    // public function trash()
    // {
    //     return view($this->masterView);
    // }
}
