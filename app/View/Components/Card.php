<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Card extends Component
{
    public $title;
    public $icon;
    public $class;
    public $badge;

    /**
     * Create a new component instance.
     */
    public function __construct($title = null, $icon = null, $class = '', $badge = null)
    {
        $this->title = $title;
        $this->icon = $icon;
        $this->class = $class;
        $this->badge = $badge;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.card');
    }
}
