<?php

namespace App\Livewire\Layouts;

use Illuminate\View\View;
use Livewire\Component;

class App extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('layouts.app');
    }
}
