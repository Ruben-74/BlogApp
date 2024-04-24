<div>
    <div>
        <label for="{{ $id }}"
            class="block text-sm font-medium leading-6 text-gray-900">{{ $label }}</label>
        <div @class([
            'mt-2',
            'relative rounded-md shadow-sm' => $errors->has($name) && $type !== 'file',
        ])> {{-- ajouter dans les champs les classes dan la div pour s'adapter a la bonne mise en page => en cas d'erreur de saisi et (&&) si c'est pas un champs de type file--}}
            <input 

               id="{{ $id }}" 
               name="{{ $name }}" 
               type="{{ $type }}"

               @if($type !== 'file')

                    value="{{ old($name) ?? $value }}"
                    {{-- old() - Recuperer l'ancienne valeur du champ si elle existe sinon elle sera null --}} 
                    
                    @class([ 
                            'form-input block w-full rounded-md border-0 py-1.5
                            ring-1 ring-inset focus:ring-2 focus:ring-inset sm:text-sm sm:leading-6',
                        
                            'pr-10 text-red-900 ring-red-300 placeholder:text-red-300 
                            focus:ring-red-500' => $errors->has( $name), //on utilise les classes s'il y une erreur sur le champs
                        
                            'text-gray-900 shadow-sm ring-gray-300 placeholder:text-gray-400 
                            focus:ring-indigo-600' => !$errors->has($name), //on utilise les classes s'il y aucune erreur sur le champs (! operateur recupere son inverse)
                        ])
                
               @endif
            >
            {{-- Pour faire apparaitre l'icon SVG sur la droite s'il ya une erreur detecté --}}
            @error($name && $type !== 'file')
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                    <svg class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
            @enderror
        </div>

        {{-- Fait apparitre la phrase d'erreur stylisé en rouge --}}
        @error($name)
            <p class="mt-2 text-sm text-red-600 ">{{ $message }}</p>
        @enderror

        {{-- Phrase d'aide pour l(utilisateur) --}}
        @if ($help)
            <p class="mt-2 text-sm text-indigo-500 ">{{ $help }}</p>
        @endif

        @if ($type == 'file' && $value)
            <p class="mt-3 text-sm text-gray-500">Fichier actuel : {{ $value }}</p>
            {{-- Acceder a une method publique on utilise le $isImage() pour savoir si c'est bien une image et on l'affiche --}}
            @if($isImage())
                <img class="mt-2 maw-w-full max-h-48 rounded-md border-0 ring shadow-sm focus:ring ring-indigo-500" src="{{ asset('storage/' . $value) }}" alt="Image {{ $value }}">  
            @endif

        @endif
    </div>
</div>



{{-- Tailwind css
  
mt-2 : margin-top de 8px

rounded-md : bords arrondies medium
shadow-sm : box-shadow small
ring-1 : rajoute un anneau box-shadow autour de l'element 
relative : position relative
md: rendu medium
w-2/3 : prend la place de 2/3 en longeur 
pr-10 : padding-right de 40 px 
flex-shrink-0 : permet de prendre toute la place d'un bloc en horizontale
focus:ring-red-500: quand le champs aura le focus on clique dessus : l'anneau sera rouge de 500 

@class : permet de modifier le css d'un element en fonction de son etat (sous condition)

@class(['mt-2', 'relative rounded-md shadow-sm' => $errors->has($name)])

$errors : contient tous les erreur du formulaire 

si $errors -> contient une erreur has($name) -> tu utilisera les 3 classes relative rounded-md shadow-sm dans la div sinon elle 
contiendra que le mt-2
--}}
