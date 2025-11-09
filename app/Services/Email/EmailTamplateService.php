<?php

namespace App\Services;

use App\Models\EmailTemplate;
use Illuminate\Support\Facades\DB;
use Exception;

class EmailTemplateService
{
    /**
     * সব Email Templates ফেরত দেয়
     */
    public function getAll()
    {
        return EmailTemplate::latest()->get();
    }

    /**
     * একক Template ফেরত দেয়
     */
    public function getById($id)
    {
        return EmailTemplate::findOrFail($id);
    }

    /**
     * নতুন Template তৈরি করে
     */
    public function create(array $data)
    {
        return EmailTemplate::create($data);
    }

    /**
     * Template আপডেট করে
     */
    public function update($id, array $data)
    {
        $template = $this->getById($id);
        $template->update($data);
        return $template;
    }

    /**
     * Template Soft Delete (Trash এ পাঠানো)
     */
    public function softDelete($id)
    {
        $template = $this->getById($id);
        return $template->delete();
    }

    /**
     * সব Trashed Templates ফেরত দেয়
     */
    public function getTrashed()
    {
        return EmailTemplate::onlyTrashed()->get();
    }

    /**
     * Restore করে
     */
    public function restore($id)
    {
        $template = EmailTemplate::onlyTrashed()->findOrFail($id);
        return $template->restore();
    }

    /**
     * Permanently Delete করে
     */
    public function forceDelete($id)
    {
        $template = EmailTemplate::onlyTrashed()->findOrFail($id);
        return $template->forceDelete();
    }
}
