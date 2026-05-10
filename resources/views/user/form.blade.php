<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-blue-100 dark:bg-blue-900 rounded-lg">
                <i class="fas fa-user-shield text-blue-600 dark:text-blue-400 text-lg"></i>
            </div>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ isset($user) ? 'Edit Data Petugas' : 'Tambah Petugas Baru' }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="p-8">
                    
                    @if ($errors->any())
                        <div class="flex p-4 mb-6 text-sm text-red-800 rounded-xl bg-red-50 dark:bg-red-900/30 dark:text-red-400 border border-red-200 dark:border-red-800/30">
                            <i class="fas fa-exclamation-circle text-lg mr-3 mt-0.5"></i>
                            <div>
                                <span class="font-semibold mb-1 block">Terdapat beberapa kesalahan:</span>
                                <ul class="list-disc pl-4 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <form action="{{ isset($user) ? route('user.update', $user->id) : route('user.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @if(isset($user))
                            @method('PUT')
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                            <!-- Kolom Kiri: Upload Foto -->
                            <div class="md:col-span-1 flex flex-col items-center">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-4 w-full text-center">Foto Profil</label>
                                
                                <div class="relative group cursor-pointer mb-3">
                                    <div class="w-40 h-40 rounded-full overflow-hidden border-4 border-white dark:border-gray-700 shadow-lg bg-gray-100 dark:bg-gray-900 flex items-center justify-center relative">
                                        @if(isset($user) && $user->foto)
                                            <img id="photo-preview" src="{{ Storage::url($user->foto) }}" alt="Preview" class="w-full h-full object-cover">
                                        @else
                                            <img id="photo-preview" src="" alt="Preview" class="w-full h-full object-cover hidden">
                                            <i id="photo-icon" class="fas fa-camera text-4xl text-gray-400 dark:text-gray-500"></i>
                                        @endif
                                        
                                        <!-- Hover Overlay -->
                                        <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                            <span class="text-white text-sm font-medium"><i class="fas fa-upload mr-2"></i>Pilih Foto</span>
                                        </div>
                                    </div>
                                    <input type="file" name="foto" id="foto" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" onchange="previewImage(this)">
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 text-center">Format: JPG, PNG, WEBP<br>Maks: 5MB</p>
                            </div>

                            <!-- Kolom Kanan: Form Data -->
                            <div class="md:col-span-2 space-y-5">
                                <div>
                                    <label for="name" class="block mb-1.5 text-sm font-medium text-gray-700 dark:text-gray-300">Nama Lengkap</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-user text-gray-400"></i>
                                        </div>
                                        <input type="text" name="name" id="name" value="{{ old('name', $user->name ?? '') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-3 dark:bg-gray-700/50 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white transition" placeholder="Masukkan nama lengkap" required>
                                    </div>
                                </div>

                                <div>
                                    <label for="email" class="block mb-1.5 text-sm font-medium text-gray-700 dark:text-gray-300">Alamat Email</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-envelope text-gray-400"></i>
                                        </div>
                                        <input type="email" name="email" id="email" value="{{ old('email', $user->email ?? '') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-3 dark:bg-gray-700/50 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white transition" placeholder="email@contoh.com" required>
                                    </div>
                                </div>

                                <div>
                                    <label for="password" class="block mb-1.5 text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-lock text-gray-400"></i>
                                        </div>
                                        <input type="password" name="password" id="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-3 dark:bg-gray-700/50 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white transition" placeholder="{{ isset($user) ? 'Kosongkan jika tidak ingin diubah' : 'Minimal 6 karakter' }}" {{ isset($user) ? '' : 'required' }}>
                                    </div>
                                    @if(isset($user))
                                        <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400"><i class="fas fa-info-circle mr-1"></i>Abaikan field ini jika tidak ingin mengganti password.</p>
                                    @endif
                                </div>

                                <div>
                                    <label for="role" class="block mb-1.5 text-sm font-medium text-gray-700 dark:text-gray-300">Hak Akses (Role)</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-id-badge text-gray-400"></i>
                                        </div>
                                        <select name="role" id="role" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-3 dark:bg-gray-700/50 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white transition appearance-none" required>
                                            <option value="petugas" {{ old('role', $user->role ?? '') == 'petugas' ? 'selected' : '' }}>Petugas</option>
                                            <option value="admin" {{ old('role', $user->role ?? '') == 'admin' ? 'selected' : '' }}>Administrator</option>
                                        </select>
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-8 border-gray-200 dark:border-gray-700">

                        <div class="flex justify-end gap-3">
                            <a href="{{ route('user.index') }}" class="px-6 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 hover:text-blue-600 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 transition">
                                <i class="fas fa-times mr-2"></i> Batal
                            </a>
                            <button type="submit" class="px-6 py-2.5 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-xl focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/30 transition transform hover:-translate-y-0.5">
                                <i class="fas fa-save mr-2"></i> {{ isset($user) ? 'Simpan Perubahan' : 'Tambah Petugas' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var preview = document.getElementById('photo-preview');
                    var icon = document.getElementById('photo-icon');
                    
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    
                    if(icon) {
                        icon.classList.add('hidden');
                    }
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</x-app-layout>
