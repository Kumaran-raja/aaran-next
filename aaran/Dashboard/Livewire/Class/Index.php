<?php

namespace Aaran\Dashboard\Livewire\Class;

use Livewire\Attributes\Layout;
use Livewire\Component;

class Index extends Component
{

    public string $data = 'sundar';

//    #[Layout('components.layouts.app')]
    public function render()
    {
        return view('dashboard::index');
    }

}
