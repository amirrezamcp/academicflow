<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class StatsWidget extends Component
{
    public $title;
    public $value;
    public $icon;
    public $color;
    public $description;
    public $trend;

    /**
     * Create a new component instance.
     */
    public function __construct($title, $value, $icon = 'fas fa-chart-line', $color = 'from-blue-500 to-blue-600', $description = '', $trend = null)
    {
        $this->title = $title;
        $this->value = $value;
        $this->icon = $icon;
        $this->color = $color;
        $this->description = $description;
        $this->trend = $trend;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.stats-widget');
    }
}
