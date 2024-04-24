<div>

    <label for="{{ $id }}" class="block text-sm font-medium leading-6 text-gray-900">{{ $label }}</label>
    <div class='mt-2'> 
        <textarea 
        
            id="{{ $id }}" 
            name="{{ $name }}" 
            rows="10"
            @class([
                    'form-textarea block w-full shadow-sm rounded-md border-0 py-1.5
                    ring-1 ring-inset focus:ring-2 focus:ring-inset sm:text-sm sm:leading-6',
                
                    'text-red-900 ring-red-300 placeholder:text-red-300 
                    focus:ring-red-500' => $errors->has($name), //on utilise ce css s'il a y une erreur sur le champs 
                
                    'text-gray-900 ring-gray-300 placeholder:text-gray-400 
                    focus:ring-indigo-600' => !$errors->has($name), // s'il y a pas d'erreur on utilise ce css 
            ])
        >
        {{ old($name) ?? $slot }}</textarea> 
        {{-- on laisse l'ancienne valeur name saisi précedement ou la variable $slot qui stockera dans 
        la balise textarea de la vue admin.form.blade.php--}}
    
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
