@extends('admin.layouts.app')

@section('title', 'Categories')
@section('header', 'Category Management')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div x-data="categoryManager()">
    
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
            Add Category
        </button>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50 text-gray-500 uppercase text-xs font-semibold">
                <tr>
                    <th class="px-6 py-4">Image</th>
                    <th class="px-6 py-4">Name</th>
                    {{-- Đã xóa cột Parent --}}
                    <th class="px-6 py-4">Slug</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                @foreach($categories as $category)
                <tr id="row-{{ $category->id }}" class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4">
                        <div class="h-10 w-10 rounded-lg bg-gray-100 border border-gray-200 overflow-hidden">
                            @if($category->image)
                                <img src="{{ asset($category->image) }}" class="h-full w-full object-cover" alt="{{ $category->name }}">
                            @else
                                <div class="h-full w-full flex items-center justify-center text-gray-400 text-xs">No Img</div>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 font-bold text-gray-900">{{ $category->name }}</td>
                    <td class="px-6 py-4 text-gray-500 italic">{{ $category->slug }}</td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <button @click='editCategory(@json($category))' class="text-blue-600 hover:text-blue-800 font-semibold text-xs uppercase tracking-wide">Edit</button>
                        <button @click="deleteCategory({{ $category->id }})" class="text-red-500 hover:text-red-700 font-semibold text-xs uppercase tracking-wide">Delete</button>
                    </td>
                </tr>
                @endforeach
                @if($categories->isEmpty())
                    <tr><td colspan="4" class="px-6 py-8 text-center text-gray-400">No categories found.</td></tr>
                @endif
            </tbody>
        </table>
    </div>

    <div x-show="isOpen" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" @click="isOpen = false">
                <div class="absolute inset-0 bg-gray-900 opacity-75"></div>
            </div>

            <div class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                <div class="bg-white px-6 pt-5 pb-4">
                    <h3 class="text-lg font-bold text-gray-900 mb-4" x-text="isEdit ? 'Edit Category' : 'Create New Category'"></h3>
                    
                    <form @submit.prevent="submitForm" enctype="multipart/form-data">
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Category Name</label>
                            <input type="text" x-model="formData.name" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-black focus:ring-1 focus:ring-black transition" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                            <textarea x-model="formData.description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-black focus:ring-1 focus:ring-black transition"></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Image</label>
                            <div class="flex items-center gap-4">
                                <div class="h-16 w-16 rounded-lg bg-gray-100 border border-gray-300 overflow-hidden flex-shrink-0">
                                    <template x-if="imagePreview">
                                        <img :src="imagePreview" class="h-full w-full object-cover">
                                    </template>
                                    <template x-if="!imagePreview">
                                        <div class="h-full w-full flex items-center justify-center text-gray-400 text-xs">No Img</div>
                                    </template>
                                </div>
                                <input type="file" @change="handleFileUpload" accept="image/*" class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200">
                            </div>
                        </div>
                        
                        <div class="flex justify-end pt-4 border-t border-gray-100 mt-4">
                            <button type="button" @click="isOpen = false" class="mr-3 px-4 py-2 text-gray-500 hover:text-gray-700 font-bold text-sm">Cancel</button>
                            <button type="submit" class="bg-black text-white px-6 py-2 rounded-lg font-bold hover:bg-gray-800 transition shadow-lg text-sm" x-text="isLoading ? 'Saving...' : 'Save Category'" :disabled="isLoading"></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function categoryManager() {
        return {
            isOpen: false,
            isEdit: false,
            isLoading: false,
            search: '',
            editId: null,
            formData: { name: '', description: '', parent_id: '' },
            imageFile: null,
            imagePreview: null,

            matchesSearch(name) {
                if (this.search === '') return true;
                return name.includes(this.search.toLowerCase());
            },

            openModal() {
                this.isEdit = false;
                this.formData = { name: '', description: '', parent_id: '' };
                this.imageFile = null;
                this.imagePreview = null;
                this.isOpen = true;
            },

            editCategory(category) {
                this.isEdit = true;
                this.editId = category.id;
                this.formData = { 
                    name: category.name, 
                    description: category.description, 
                    parent_id: category.parent_id || '' 
                };
                this.imageFile = null;
                if (category.image) {
                    this.imagePreview = category.image.startsWith('http') ? category.image : (category.image.startsWith('/') ? category.image : '/' + category.image);
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
                let url = this.isEdit ? `/admin/categories/${this.editId}` : "{{ route('admin.categories.store') }}";
                
                let data = new FormData();
                data.append('name', this.formData.name);
                data.append('description', this.formData.description || '');
                if(this.formData.parent_id) data.append('parent_id', this.formData.parent_id);
                if (this.imageFile) {
                    data.append('image', this.imageFile);
                }
                
                if (this.isEdit) {
                    data.append('_method', 'PUT'); 
                }

                try {
                    const response = await fetch(url, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        body: data
                    });
                    
                    const result = await response.json();

                    if (!response.ok) throw result;

                    this.isOpen = false;
                    Swal.fire({ icon: 'success', title: 'Success', text: result.message, showConfirmButton: false, timer: 1500 })
                    .then(() => window.location.reload());

                } catch (error) {
                    Swal.fire({ icon: 'error', title: 'Oops...', text: error.message || (error.errors ? Object.values(error.errors)[0][0] : 'Error') });
                } finally {
                    this.isLoading = false;
                }
            },

            deleteCategory(id) {
                Swal.fire({
                    title: 'Delete this category?',
                    text: "Action cannot be undone!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#000',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then(async (result) => {
                    if (result.isConfirmed) {
                        try {
                            const response = await fetch(`/admin/categories/${id}`, {
                                method: 'DELETE',
                                headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}" }
                            });
                            if (response.ok) {
                                document.getElementById(`row-${id}`).remove();
                                Swal.fire('Deleted!', 'Category has been deleted.', 'success');
                            }
                        } catch (e) { console.error(e); }
                    }
                })
            }
        }
    }
</script>
@endsection