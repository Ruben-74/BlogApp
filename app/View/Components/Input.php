<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\Component;

class Input extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $name,
        public string $label,
        public ?string $value = null,
        public ?string $id = null,
        public string $type = 'text',
        public string $help = '',
    )
    {
        $this->id = $this->id ?? $this->name; //on regard si l'id saisi est égal à null il prend le meme nom de la variable $name
        // EQUIVALENT A OPERATEUR TERNAIRE : $this->id = $this->id ? $this->id : $this->name;
    }


    public function isImage() : bool
    {
        //on va regarder avec str_start_with si le fichier passer en valeur dans $value est une image ou pas 
        //mimetype correspond au /image.jpg.. on utilise la façade Storage pour acceder aux images 
        return  str_starts_with(Storage::mimeType($this->value), 'image/');
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.input');
    }
}
