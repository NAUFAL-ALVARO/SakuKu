<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Input extends Component
{
    public string $label;
    public string $name;
    public string $type;
    public string $value;
    public bool $required;

    public function __construct(
        string $label = '',
        string $name = '',
        string $type = 'text',
        string $value = '',
        bool $required = false
    ) {
        $this->label = $label;
        $this->name = $name;
        $this->type = $type;
        $this->value = $value;
        $this->required = $required;
    }

    public function render()
    {
        return view('components.input');
    }
}