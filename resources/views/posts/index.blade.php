<x-default-layout>

    <div class="space-y-10 md:space-y-16">

        {{-- On multiplie les posts pour faire une liste avec foreach  --}}

        @forelse ($posts as $post)
            
        <x-post :post="$post" list /> {{-- en mettant l'attribut list il passe a true automatiquement --}}
        
        @empty {{-- @empty permet dans un forelse plutot que dans un foreach de marquer un message dans le cas ou on trouve pas le post --}}
        
        <p class="text-slate-400 text-center">Aucun résultat.</p>
        
        @endforelse

        {{ $posts->links() }} {{-- Pagination --}}

    </div>

</x-default-layout>
