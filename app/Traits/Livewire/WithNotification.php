<?php

namespace App\Traits\Livewire;

trait WithNotification
{
    public function success($message)
    {
        session()->flash('success', $message);
    }
    public function error($message)
    {
        session()->flash('error', $message);
    }
    public function warning($message)
    {
        session()->flash('warning', $message);
    }
    public function info($message)
    {
        session()->flash('info', $message);
    }
    public function danger($message)
    {
        session()->flash('danger', $message);
    }
}
