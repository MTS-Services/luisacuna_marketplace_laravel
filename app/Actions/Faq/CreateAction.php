<?php

namespace App\Actions\Faq;

use App\Models\Faq;
use Illuminate\Support\Facades\DB;
use App\Repositories\Contracts\FaqRepositoryInterface;

use Illuminate\Support\Facades\Storage;


class CreateAction
{

    public function __construct(protected FaqRepositoryInterface $interface)
    {
    }


    public function execute(array $data): Faq
    {
        return DB::transaction(function () use ($data) {


            $newData = $this->interface->create($data);

            return $newData->fresh();
        });
    }

}
