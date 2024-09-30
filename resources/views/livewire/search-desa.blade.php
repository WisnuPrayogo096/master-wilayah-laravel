<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-900 ml-2">Daftar Kelurahan/Desa</h1>
        </div>
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="p-6" >
                <div class="flex justify-between items-center space-x-4 mb-3">
                    <!-- Tombol Kembali -->
                    <button class="back-button bg-gradient-to-r from-blue-500 to-indigo-600 text-white py-2.5 px-3 rounded-xl ml-2 hover:shadow-lg hover:scale-105 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50 transition-all duration-300 ease-in-out transform"
                        x-on:click="window.location.href='{{ $this->backPage() }}';">
                        <span class="flex items-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                        </span>
                    </button>

                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <input type="search" class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" wire:model.live.debounce.300ms="search" placeholder="Cari nama...">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                        <button wire:click="openCreateModal" class="create-button bg-gradient-to-r from-blue-500 to-indigo-600 text-white py-2.5 px-2.5 rounded-xl hover:shadow-lg hover:scale-110 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-300 ease-in-out transform">
                            <span class="flex items-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                            </span>
                        </button>
                    </div>
                </div>

                @if($wilayahs->count() > 0)
                    <div class="max-h-[500px] overflow-x-auto relative">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50 sticky top-0 z-10">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                    {{-- <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ibu Kota</th> --}}
                                    <th scope="col" class="px-6 py-3 text-center align-middle text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                    <th scope="col" class="px-6 py-3 text-center align-middle text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori Wilayah</th>
                                    <th scope="col" class="px-6 py-3 text-center align-middle text-xs font-medium text-gray-500 uppercase tracking-wider">Kode Negara</th>
                                    <th colspan="1" scope="col" class="px-6 py-3 text-center align-middle text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($wilayahs as $desa)
                                <tr class="hover:bg-gray-50 transition-colors duration-200" wire:key="desa-{{ $desa->id }}">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ ($wilayahs->currentPage() - 1) * $wilayahs->perPage() + $loop->iteration }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $desa->kode }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $desa->nama }}
                                        <button wire:click="openInfoModal({{ $desa->id }})" wire:key="info-button-{{ $desa->id }}" class="info-button text-blue-600 ml-3 hover:text-blue-800 focus:outline-none transition duration-300 ease-in-out transform hover:scale-110">
                                            <i class="fas fa-info-circle"></i>
                                        </button>
                                    </td>
                                    {{-- <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $desa->ibu_kota }}</td> --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-center align-middle text-sm text-gray-500">{{ $desa->type }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center align-middle text-sm text-gray-500">{{ $desa->kategori_wilayah }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center align-middle text-sm text-gray-500">{{ $desa->kode_negara }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center align-middle text-sm text-gray-500">
                                        <button wire:click="openEditModal({{ $desa->id }})" class="update-button text-yellow-600 mr-4 hover:text-yellow-800 focus:outline-none transition duration-300 ease-in-out transform hover:scale-110">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button wire:click="confirmDelete({{ $desa->id }})" class="delete-button text-red-600 hover:text-red-800 focus:outline-none transition duration-300 ease-in-out transform hover:scale-110">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $wilayahs->links('livewire::tailwind') }}
                    </div>
                @else
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mt-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-yellow-700">
                                    Tidak ada hasil yang ditemukan untuk kata kunci "{{ $search }}".
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Modal Section -->
                <!-- info -->
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

                            @if ($modalType === 'info' && $selectedDesaId)
                                <h3 class="text-center text-xl font-semibold text-gray-800 mb-6">Info {{ $selectedDesa->nama }}</h3>
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
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $selectedDesa->$field }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @elseif ($modalType == 'delete')
                                <h3 class="text-center text-2xl font-semibold text-gray-800 mb-4">Confirm Deletion</h3>
                                <p class="text-center text-gray-600 mb-6">Are you sure you want to delete?</p>
                                <div class="flex justify-center space-x-4">
                                    <button wire:click="deleteDesa" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-6 rounded-full focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50 transition duration-200">
                                        Yes, Delete
                                    </button>
                                    <button wire:click="closeModal" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-6 rounded-full focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50 transition duration-200">
                                        Cancel
                                    </button>
                                </div>
                            @elseif($modalType == 'create' || $modalType === 'edit')
                                <h3 class="text-center text-2xl font-semibold text-gray-800 mb-6">
                                    {{ $editingDesaId ? 'Edit Desa' : 'Create Desa' }}
                                </h3>

                                <form wire:submit.prevent="{{ $editingDesaId ? 'updateDesa' : 'createDesa' }}" class="space-y-6">
                                    {{-- @foreach(['kode', 'nama', 'ibu_kota'] as $field) --}}
                                    @foreach(['kode', 'nama'] as $field)
                                        <div>
                                            <label for="{{ $field }}" class="block text-sm font-medium text-gray-700 mb-1">{{ ucfirst(str_replace('_', ' ', $field)) }}</label>
                                            <input type="text" id="{{ $field }}" wire:model="form.{{ $field }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition duration-200">
                                            @error('form.' . $field) <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                        </div>
                                    @endforeach
                                    <div>
                                        <label for="kategori_wilayah" class="block text-sm font-medium text-gray-700 mb-1">Kategori Wilayah</label>
                                        <select id="kategori_wilayah" wire:model="form.kategori_wilayah" class="py-2 px-4 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition duration-200">
                                            <option value="">Pilih Kategori</option>
                                            <option value="DESA">Desa</option>
                                            <option value="KEL.">Kelurahan</option>
                                        </select>
                                        @error('form.kategori_wilayah') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="flex justify-end">
                                        <button type="submit" class="inline-flex justify-center py-2 px-6 border border-transparent shadow-sm text-sm font-medium rounded-full text-white bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200">
                                            {{ $editingDesaId ? 'Update' : 'Create' }}
                                        </button>
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- alert -->
                <div
                    x-data="{ show: false, message: '' }"
                    x-show="show"
                    x-on:notify.window="show = true; message = $event.detail; setTimeout(() => show = false, 4000)"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform scale-90"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    x-transition:leave="transition ease-in duration-300"
                    x-transition:leave-start="opacity-100 transform scale-100"
                    x-transition:leave-end="opacity-0 transform scale-90"
                    class="fixed top-4 right-4 max-w-md w-full bg-blue-500 text-white py-3 px-6 rounded-lg shadow-lg z-50 flex items-center justify-between"
                    wire:ignore
                >
                    <!-- Icon (info) -->
                    <div class="mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 18.5c3.038 0 5.5-2.462 5.5-5.5s-2.462-5.5-5.5-5.5-5.5 2.462-5.5 5.5 2.462 5.5 5.5 5.5z" />
                        </svg>
                    </div>

                    <!-- Message -->
                    <p x-text="message" class="text-sm font-medium flex-grow"></p>

                    <!-- Close button -->
                    <button @click="show = false" class="text-white hover:text-green-100 focus:outline-none">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
