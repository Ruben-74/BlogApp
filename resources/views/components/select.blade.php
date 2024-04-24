<div>
    <label for="{{ $id }}" class="block text-sm font-medium leading-6 text-gray-900">{{ $label }}</label>
    <div class='mt-2'> 
        <select
        
            id="{{ $id }}" 
            {{-- si on est dans un select name a choix multiple ? on rajoute les [] car c'est un tableau sinon (:) rien (choix simple)--}}
            name="{{ $name . ($multiple ? '[]' : '' ) }}" 
            @class([ // css prit en charge dans le cas ou il y a pas de condition d'erreur
                    'block w-full shadow-sm rounded-md border-0 py-1.5
                    ring-1 ring-inset focus:ring-2 focus:ring-inset sm:max-w-xs sm:text-sm sm:leading-6',
                
                    // on utilise ces classes css en cas d'une erreur sur le champs 
                    'text-red-900 ring-red-300 focus:ring-red-500' => $errors->has($name), 
                    // s'il y a pas d'erreur on utilise ces classes css 
                    'text-gray-900 ring-gray-300 focus:ring-indigo-600' => !$errors->has($name), 
                    //on charge le css pour un select a choix simple (=> si jamais on est pas a choix multiple)
                    'form-select' => !$multiple,
                    //on charge le css pour un select a choix multiple (=> si jamais on est pas a choix simple)
                    'form-multiselect' => $multiple,
            ])
            {{-- Si jamais ma propriété $multiple est égal a true ($multiple) alors on mettra l'attribut multiple sur l'element html --}}
            @if($multiple) multiple @endif
        >
        
            {{-- On charge les items des collection tags et categories dans un foreach  --}}
            @foreach ($list as $item)
                <option 
                    value="{{ $item->$optionsValues }}"
                    {{-- persister et chargé les tags ou categories choisi precedement dans le cas d'une erreur ou edition de post  --}}
                    {{-- On regarde si les elements qui étaient selectionné avant sont presents dans la collection qu'on souhaite modifier si oui on la preselectionne sinon non --}}
                    @selected($valueIsCollection ? $value->contains($item->$optionsValues) :  {{-- la fonction contains va comparer si l'id present dans la bdd correspond a l'id de l'item qu'on cherche a modifier  --}}
                    $item->$optionsValues == $value) {{-- sinon c'est un choix simple passé en attribut --}} 
                >
                    {{ $item->$optionsTexts }} {{-- on recupere le nom lié a chaque items de la collection list --}}
                </option>
            @endforeach
        </select> 
    
    </div>

    {{-- Fait apparitre la phrase d'erreur stylisé en rouge --}}
    @error($name)
        <p class="mt-2 text-sm text-red-600 ">{{ $message }}</p>
    @enderror

    {{-- Phrase d'aide pour l'utilisateur --}}
    @if ($help)
        <p class="mt-2 text-sm text-indigo-500 ">{{ $help }}</p>
    @endif

</div>