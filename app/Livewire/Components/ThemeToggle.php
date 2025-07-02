<?php

namespace App\Livewire\Components;

use Livewire\Component;

class ThemeToggle extends Component
{
    public bool $dark = false;

    public function mount()
    {
        $this->dark = session('dark', false);
    }

    public function toggle()
    {
        $this->dark = !$this->dark;
        session(['dark' => $this->dark]);
    }
    public function render()
    {
        return view('livewire.components.theme-toggle');
    }
}
