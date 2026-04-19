@props(['id' => null, 'title' => 'Eliminar Usuario', 'message' => '¿Estás seguro de eliminar este usuario?'])

<div x-data="{ open: false, userId: null }" 
     x-on:open-delete-modal.window="open = true; userId = $event.detail.id"
     x-cloak>
    
    <!-- Fondo oscuro -->
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black/50 backdrop-blur-sm z-[200]"
         @click="open = false">
    </div>

    <!-- Modal -->
    <div x-show="open"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-md z-[201]">
        
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            <!-- Header -->
            <div class="relative p-6 pb-0">
                <div class="flex items-center justify-center mb-4">
                    <div class="w-14 h-14 rounded-full bg-red-100 flex items-center justify-center">
                        <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </div>
                </div>
                <h3 class="text-xl font-semibold text-center text-gray-900">{{ $title }}</h3>
                <p class="mt-2 text-sm text-center text-gray-500">{{ $message }}</p>
            </div>
            
            <!-- Footer -->
            <div class="flex gap-3 p-6 pt-4">
                <button type="button"
                        @click="open = false"
                        class="flex-1 px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition">
                    Cancelar
                </button>
                <button type="button"
                        x-on:click="if(userId) { $dispatch('confirm-delete', { id: userId }); open = false; }"
                        class="flex-1 px-4 py-2 text-sm font-medium text-white bg-red-500 rounded-lg hover:bg-red-600 transition">
                    Eliminar
                </button>
            </div>
        </div>
    </div>
</div>