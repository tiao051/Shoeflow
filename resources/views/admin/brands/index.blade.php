@extends('admin.layouts.app')

@section('title', 'Brands')
@section('header', 'Brand Management')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div x-data="brandManager()">
    
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <form method="GET" action="" class="relative w-full md:w-72">
            <input type="text" 
                name="search" 
                value="{{ request('search') }}"
                placeholder="Type & Hit Enter..." 
                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-black focus:border-black text-sm">
            
            <button type="submit" class="absolute left-3 top-2.5 text-gray-400 hover:text-black">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21L15 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z"></path></svg>
            </button>
        </form>
        <button @click="openModal()" 
                class="bg-black text-white px-4 py-2 rounded-lg font-bold text-sm hover:bg-gray-800 transition flex items-center shadow-lg transform hover:-translate-y-0.5">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Add Brand
        </button>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($brands as $brand)
        <div id="brand-{{ $brand->id }}" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col items-center text-center hover:shadow-md transition group relative" id="brand-{{ $brand->id }}">
            <div class="h-24 w-24 rounded-full bg-gray-50 border border-gray-200 flex items-center justify-center mb-4 overflow-hidden p-2">
                @if($brand->logo)
                    <img src="{{ asset($brand->logo) }}" class="max-h-full max-w-full object-contain">
                @else
                    <span class="text-gray-400 font-bold text-xl">{{ substr($brand->name, 0, 1) }}</span>
                @endif
            </div>
            <h3 class="font-bold text-gray-900 text-lg">{{ $brand->name }}</h3>
            <p class="text-xs text-gray-500 mt-1 line-clamp-2">{{ $brand->description ?? 'No description' }}</p>
            
            <div class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition flex gap-2">
                <button @click='editBrand(@json($brand))' class="bg-blue-50 text-blue-600 p-2 rounded-full hover:bg-blue-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                </button>
                <button @click="deleteBrand({{ $brand->id }})" class="bg-red-50 text-red-600 p-2 rounded-full hover:bg-red-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </button>
            </div>
        </div>
        @endforeach
    </div>
    
    @if($brands->isEmpty())
        <div class="text-center py-12 text-gray-400 bg-white rounded-xl border border-dashed border-gray-300">
            No brands found. Add "Converse" to start!
        </div>
    @endif

    <div x-show="isOpen" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" @click="isOpen = false">
                <div class="absolute inset-0 bg-gray-900 opacity-75"></div>
            </div>

            <div class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md w-full">
                <div class="bg-white px-6 pt-5 pb-4">
                    <h3 class="text-lg font-bold text-gray-900 mb-4" x-text="isEdit ? 'Edit Brand' : 'Add Brand'"></h3>
                    
                    <form @submit.prevent="submitForm" enctype="multipart/form-data">
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Brand Name</label>
                            <input type="text" x-model="formData.name" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-black focus:ring-1 focus:ring-black transition" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                            <textarea x-model="formData.description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-black focus:ring-1 focus:ring-black transition"></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Logo</label>
                            <div class="flex items-center gap-4">
                                <div class="h-20 w-20 rounded-full bg-gray-100 border border-gray-300 overflow-hidden flex-shrink-0 flex items-center justify-center">
                                    <template x-if="imagePreview">
                                        <img :src="imagePreview" class="max-h-full max-w-full object-contain">
                                    </template>
                                    <template x-if="!imagePreview">
                                        <span class="text-gray-400 text-xs">No Logo</span>
                                    </template>
                                </div>
                                <input type="file" @change="handleFileUpload" accept="image/*" class="text-sm text-gray-500">
                            </div>
                        </div>
                        
                        <div class="flex justify-end pt-4 border-t border-gray-100 mt-4">
                            <button type="button" @click="isOpen = false" class="mr-3 px-4 py-2 text-gray-500 hover:text-gray-700 font-bold text-sm">Cancel</button>
                            <button type="submit" class="bg-black text-white px-6 py-2 rounded-lg font-bold hover:bg-gray-800 transition shadow-lg text-sm" x-text="isLoading ? 'Saving...' : 'Save Brand'" :disabled="isLoading"></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function brandManager() {
        return {
            isOpen: false,
            isEdit: false,
            isLoading: false,
            search: '',
            editId: null,
            formData: { name: '', description: '' },
            imageFile: null,
            imagePreview: null,

            matchesSearch(name) {
                if (this.search === '') return true;
                return name.includes(this.search.toLowerCase());
            },

            openModal() {
                this.isEdit = false;
                this.formData = { name: '', description: '' };
                this.imageFile = null;
                this.imagePreview = null;
                this.isOpen = true;
            },

            editBrand(brand) {
                this.isEdit = true;
                this.editId = brand.id;
                this.formData = { name: brand.name, description: brand.description };
                this.imageFile = null;
                if (brand.logo) {
                    this.imagePreview = brand.logo.startsWith('http') ? brand.logo : '/' + brand.logo;
                } else {
                    this.imagePreview = null;
                }
                this.isOpen = true;
            },

            handleFileUpload(event) {
                const file = event.target.files[0];
                if (file) {
                    this.imageFile = file;
                    const reader = new FileReader();
                    reader.onload = (e) => { this.imagePreview = e.target.result; };
                    reader.readAsDataURL(file);
                }
            },

            async submitForm() {
                this.isLoading = true;
                let url = this.isEdit ? `/admin/brands/${this.editId}` : "{{ route('admin.brands.store') }}";
                
                let data = new FormData();
                data.append('name', this.formData.name);
                data.append('description', this.formData.description || '');
                if (this.imageFile) {
                    data.append('logo', this.imageFile);
                }
                if (this.isEdit) {
                    data.append('_method', 'PUT'); 
                }

                try {
                    const response = await fetch(url, {
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}" },
                        body: data
                    });
                    
                    const result = await response.json();
                    if (!response.ok) throw result;

                    this.isOpen = false;
                    Swal.fire({ icon: 'success', title: 'Success', text: result.message, showConfirmButton: false, timer: 1500 })
                    .then(() => window.location.reload());

                } catch (error) {
                    Swal.fire({ icon: 'error', title: 'Oops...', text: error.message || 'Something went wrong' });
                } finally {
                    this.isLoading = false;
                }
            },

            deleteBrand(id) {
                Swal.fire({
                    title: 'Delete brand?',
                    text: "Irreversible action!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#000',
                    confirmButtonText: 'Yes, delete'
                }).then(async (result) => {
                    if (result.isConfirmed) {
                        try {
                            const response = await fetch(`/admin/brands/${id}`, {
                                method: 'DELETE',
                                headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}" }
                            });
                            if (response.ok) {
                                document.getElementById(`brand-${id}`).remove();
                                Swal.fire('Deleted!', 'Brand removed.', 'success');
                            }
                        } catch (e) { console.error(e); }
                    }
                })
            }
        }
    }
</script>
@endsection