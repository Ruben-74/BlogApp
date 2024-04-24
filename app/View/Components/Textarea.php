<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Textarea extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $name,
        public string $label,
        public ?string $id = null,
        public string $help = '',
    )
    {
        $this->id = $this->id ?? $this->name; //on regard si l'id saisi est égal à null il prend le meme nom de la variable $name
        // EQUIVALENT A OPERATEUR TERNAIRE : $this->id = $this->id ? $this->id : $this->name;
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.textarea');
    }
}
