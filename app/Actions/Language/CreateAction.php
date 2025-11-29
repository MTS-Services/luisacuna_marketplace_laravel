<?php

namespace App\Actions\Language;

use App\Models\Language;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Repositories\Contracts\LanguageRepositoryInterface;

class CreateAction
{
    public function __construct(
        protected LanguageRepositoryInterface $interface
    ) {}


    public function execute(array $data): Language
    {
        return DB::transaction(function () use ($data) {
            

            if ($data) {
                $sanitizedName = strtolower(str_replace(' ', '_', $data['locale']));
                $prefix = $sanitizedName . '-' . time() . '-' . uniqid();
                $fileName = $prefix . '-' . $data['file']->getClientOriginalName();
                $data['file'] = Storage::disk('public')->putFileAs('languages', $data['file'], $fileName);
            } else {
                unset($data['file']);
            }
            $language = $this->interface->create($data);
            // Dispatch event
            // event(new LanguageCreated($language));
            return $language->fresh();
        });
    }
}
