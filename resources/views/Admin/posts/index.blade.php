<x-default-layout title="Gestion des posts">

    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-base font-semibold leading-6 text-gray-900">Posts</h1>
            <p class="mt-2 text-sm text-gray-700">Interface d'administration du blog.</p>
        </div>
        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
            <a href="{{ route('admin.posts.create') }}"
                class="inline-flex rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Créer
                un post</a>
        </div>
    </div>
    
    <div class="mt-8 flow-root">
        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <table class="min-w-full divide-y divide-gray-300">
                    <thead>
                        <tr>
                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-3">Titre</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"></th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"></th>
                            <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-3"></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @foreach ($posts as $post)
                            <tr class="even:bg-gray-50"> {{-- un resultat sur deux le background est gris clair --}}
                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-3">
                                    {{ $post->title }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"> {{-- whitespace-nowrap permet de maintenir l'ecriture sur la meme ligne sans retour a la ligne --}}
                                    <a href="{{ route('posts.show', ['post' => $post]) }}" target="_blank" {{-- ouvre dans un nouvel onglet target blank --}}
                                        class="text-indigo-600 hover:text-indigo-900">
                                        Voir le post
                                    </a>
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    <a href="{{ route('admin.posts.edit', ['post' => $post]) }}" 
                                        class="text-indigo-600 hover:text-indigo-900">
                                        Editer
                                    </a>
                                </td>
                                <td x-data="{close() { $refs.dialogRef.close() }, {{-- method pour fermer avec le boutton integré a la modal --}}
                                    {{-- Method qui permet de fermer la modal en clicant partour sur la page --}}
                                    closeFromEvent(event){
                                        if(event.currentTarget === event.target){
                                            $refs.dialogRef.close()
                                        }
                                    }
                                
                                    }"
                                    {{-- x-data permet de prioriser l'alpine js avant la route dans le lien <a> qui ne supporte pas la method get  --}}
                                    class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-3">
                                    <a @click="$refs.dialogRef.showModal()" class="text-indigo-600 hover:text-indigo-900">Supprimer</a>

                                    {{-- Modal suppresion --}}

                                    <dialog @click="closeFromEvent(event)" x-ref="dialogRef" class="bg-white rounded-md shadow-sm p-4">
                                        <form method="dialog">
                                            <div class="p-4 md:p-5 text-center">
                                                <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                                </svg>
                                                <h3 class="mb-5 text-lg font-normal text-dark dark:text-gray-600">Etes-vous sur de vouloir supprimer ce post ?</h3>
                                                <a href="{{ route('admin.posts.destroy', ['post' => $post]) }}" @click.prevent='$refs.delete.submit()' data-modal-hide="popup-modal" class="text-white bg-indigo-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-white dark:focus:ring-white-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                                    Oui, Je suis sur
                                                </a>
                                                <button @click="close()" data-modal-hide="popup-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Non, fermer</button>
                                            </div>
                                        </form>
                                    </dialog>

                                    {{-- on passe par un formulaire caché de type POST pour eviter de passer par une method get afin de securiser le csrf --}}
                                    <form x-ref="delete" action="{{ route('admin.posts.destroy', ['post' => $post]) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</x-default-layout>
