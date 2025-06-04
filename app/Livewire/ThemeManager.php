<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Cookie;

class ThemeManager extends Component
{
    public function setTheme($theme)
    {
        Cookie::queue('theme', $theme);
        $this->dispatch('theme-changed', theme: $theme);
    }

    public function render()
    {
        return view('livewire.theme-manager');
    }
} 