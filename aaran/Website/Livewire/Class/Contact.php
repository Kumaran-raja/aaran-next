<?php

namespace Aaran\Website\Livewire\Class;

use Livewire\Attributes\Layout;
use Livewire\Component;

class Contact extends Component
{
    #[Layout('Ui::components.layouts.web')]
    public function render()
    {
        return view('website::contact');
    }

}
