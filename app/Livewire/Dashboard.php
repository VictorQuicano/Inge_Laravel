<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    public array $menu;

    public function mount():void
    {
        $this->menu = auth()->user()->hasRole('admin') ? config('menu.admin') : config('menu.assistant');
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
