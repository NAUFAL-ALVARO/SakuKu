<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Card extends Component
{
    public string $title;
    public ?string $icon;
    public string $variant;

    public function __construct(string $title = '', ?string $icon = null, string $variant = 'default')
    {
        $this->title = $title;
        $this->icon = $icon;
        $this->variant = $variant;
    }

    public function render()
    {
        return view('components.card');
    }
}