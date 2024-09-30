<!-- resources/views/components/modal.blade.php -->

@if($showModal)
    <div class="fixed inset-0 backdrop-blur-sm overflow-y-auto h-full w-full z-50"
        x-data="{ show: false }"
        x-init="setTimeout(() => show = true, 50)"
        x-show="show"
        x-on:keydown.escape.window="$wire.closeModal()"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform scale-95"
        x-transition:enter-end="opacity-100 transform scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 transform scale-100"
        x-transition:leave-end="opacity-0 transform scale-95"
    >
        <div class="relative top-20 mx-auto p-8 border w-11/12 max-w-md shadow-2xl rounded-3xl bg-white">
            <button wire:click="closeModal" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors duration-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>

            @if ($modalType === 'info' && $selectedProvinsiId)
                <h3 class="text-center text-xl font-semibold text-gray-800 mb-6">Info Prov. {{ $selectedProvinsi->nama }}</h3>
                <div class="overflow-x-auto bg-gray-50 rounded-xl shadow-inner">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Field</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Value</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach(['created_by', 'updated_by', 'deleted_by', 'restored_by', 'created_at', 'updated_at', 'deleted_at', 'restored_at'] as $field)
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ ucfirst(str_replace('_', ' ', $field)) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $selectedProvinsi->$field }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @elseif ($modalType == 'delete')
                <h3 class="text-center text-2xl font-semibold text-gray-800 mb-4">Confirm Deletion</h3>
                <p class="text-center text-gray-600 mb-6">Are you sure you want to delete this provinsi?</p>
                <div class="flex justify-center space-x-4">
                    <button wire:click="deleteProvinsi" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-6 rounded-full focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50 transition duration-200">
                        Yes, Delete
                    </button>
                    <button wire:click="closeModal" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-6 rounded-full focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50 transition duration-200">
                        Cancel
                    </button>
                </div>
            @elseif($modalType == 'create' || $modalType === 'edit')
                <h3 class="text-center text-2xl font-semibold text-gray-800 mb-6">
                    {{ $editingProvinsiId ? 'Edit Provinsi' : 'Create Provinsi' }}
                </h3>

                <form wire:submit.prevent="{{ $editingProvinsiId ? 'updateProvinsi' : 'createProvinsi' }}" class="space-y-6">
                    @foreach(['kode', 'nama', 'ibu_kota'] as $field)
                        <div>
                            <label for="{{ $field }}" class="block text-sm font-medium text-gray-700 mb-1">{{ ucfirst(str_replace('_', ' ', $field)) }}</label>
                            <input type="text" id="{{ $field }}" wire:model="form.{{ $field }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition duration-200">
                            @error('form.' . $field) <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                    @endforeach
                    <div class="flex justify-end">
                        <button type="submit" class="inline-flex justify-center py-2 px-6 border border-transparent shadow-sm text-sm font-medium rounded-full text-white bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200">
                            {{ $editingProvinsiId ? 'Update' : 'Create' }}
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </div>
@endif
