<?php

namespace Aaran\Dashboard\Livewire\Class;

use Livewire\Attributes\Layout;
use Livewire\Component;

class Index extends Component
{
    public $blogs = [];

    #[Layout('Ui::components.layouts.app')]
    public function render()
    {
        return view('dashboard::index');
    }

}
