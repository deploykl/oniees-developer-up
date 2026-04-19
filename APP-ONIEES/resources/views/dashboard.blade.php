<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <x-welcome />
                    
                    <!-- Botones de prueba -->
                    <div class="mt-8 flex gap-4 justify-center flex-wrap">
                        <button onclick="window.toast?.success('✅ Éxito!')" 
                                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            Toast Success
                        </button>
                        <button onclick="window.toast?.error('❌ Error!')" 
                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                            Toast Error
                        </button>
                        <button onclick="window.toast?.info('ℹ️ Info')" 
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Toast Info
                        </button>
                        <button onclick="window.toast?.warning('⚠️ Warning')" 
                                class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                            Toast Warning
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Dashboard cargado');
        
        // Mostrar toast de bienvenida desde la sesión
        @if(session('toast_message'))
            console.log('Mensaje flash encontrado: {{ session('toast_message') }}');
            setTimeout(function() {
                if (window.toast) {
                    window.toast.{{ session('toast_type', 'success') }}('{{ session('toast_message') }}');
                } else {
                    alert('{{ session('toast_message') }}');
                }
            }, 800);
        @else
            console.log('No hay mensaje flash en sesión');
        @endif
    });
</script>