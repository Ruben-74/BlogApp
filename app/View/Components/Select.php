<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class Select extends Component
{
    // boolien qui va etre egal true si la valeur est une collection 
    public bool $valueIsCollection;

    /**
     * Create a new component instance.
     */
    public function __construct(
        // 3 propieté obligé de renseigner des valeurs 
        public string $name,
        public string $label,
        public Collection $list, //options elements à selectionner (tags et categories)

        // propietes optionnels
        public ?string $id = null,
        public string $optionsValues = 'id', //propriété qui sert pour la valeur reél de l'option
        public string $optionsTexts = 'name', //propiété name à afficher correspondant a l'id selectionné
        public mixed $value = null, // null par défaut | propiété pour recuperer une valeur ou plusieurs (a choix multiples) a venir selectionné dans les selects 
        public bool $multiple = false, // permet d'indiquer par true ou false si la valeur recupéré est a choix multiple ou pas | par defaut c'est choix simple (false)
        public string $help = '', // contient un message d'aide si cela s'avere necessaire
    )
    {
        //on regard si l'id saisi est égal à null si oui on viendra l'affecter la meme valeur de la propiété name 
        $this->id = $this->id ?? $this->name; 

        //methode protegé
        $this->handleValue();

    }

    protected function handleValue() : void { //retourne rien 
        // on regarde si jamais notre formulaire a été precédement soumis et s'il y a une valeur a mettre 
        // pour ce champs value si oui on on recupere la vielle valeur et on prepeuple le champs value (eviter d'ecraser la valeur a chaque soumission de form)
        $this->value = old($this->name) ?? $this->value;
        // on va regarder si notre valeur est un tableau ou pas avec la fonction is_array()
        if (is_array($this->value)) {
            $this->value = collect($this->value); //on transforme le tableau en collection pour pouvoir le manipuler dans les vues
        }
        // on va regarder si notre valeur est une instance de Collection
        $this->valueIsCollection = $this->value instanceof Collection;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.select');
    }
}
