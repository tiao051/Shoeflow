@extends('admin.layouts.app')

@section('title', 'Categories')
@section('header', 'Category Management')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div x-data="categoryManager()">
    
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <form method="GET" action="{{ route('admin.categories.index') }}" class="relative w-full md:w-72">
            <input type="text" 
                name="search" 
                value="{{ request('search') }}"
                placeholder="Search category..." 
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
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse whitespace-nowrap">
                <thead class="bg-gray-50 text-gray-500 uppercase text-xs font-semibold">
                    <tr>
                        <th class="px-6 py-4">Image</th>
                        <th class="px-6 py-4">Category Name</th>
                        <th class="px-6 py-4">Slug</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                    @forelse($categories as $category)
                    <tr id="row-{{ $category->id }}" class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">
                            <div class="h-12 w-12 rounded-lg bg-gray-100 border border-gray-200 overflow-hidden relative flex items-center justify-center">
                                @if($category->image)
                                    <img src="{{ asset($category->image) }}" class="h-full w-full object-cover">
                                @else
                                    <span class="text-xs font-bold text-gray-400">IMG</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-gray-900">{{ $category->name }}</div>
                            <div class="text-xs text-gray-500 mt-0.5">{{ $category->products_count ?? 0 }} products</div>
                        </td>
                        <td class="px-6 py-4">
                            <code class="text-xs bg-gray-50 px-2 py-1 rounded border border-gray-200">{{ $category->slug }}</code>
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <button @click='editCategory(@json($category))' class="text-blue-600 hover:text-blue-800 font-semibold text-xs uppercase">Edit</button>
                            <button @click="deleteCategory({{ $category->id }})" class="text-red-500 hover:text-red-700 font-semibold text-xs uppercase">Delete</button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-gray-400">No categories found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $categories->links() }}
        </div>
    </div>

    <div x-show="isOpen" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" @click="isOpen = false">
                <div class="absolute inset-0 bg-gray-900 opacity-75"></div>
            </div>

            <div class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                <div class="bg-white px-6 pt-5 pb-4">
                    <h3 class="text-lg font-bold text-gray-900 mb-4" x-text="isEdit ? 'Edit Category' : 'Add New Category'"></h3>
                    
                    <form @submit.prevent="submitForm" enctype="multipart/form-data">
                        <div class="space-y-4">
                            
                            <div>
                                <label class="block text-gray-700 text-xs font-bold mb-1 uppercase">Category Name</label>
                                <input type="text" x-model="formData.name" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-black focus:border-black text-sm" required>
                            </div>

                            <div>
                                <label class="block text-gray-700 text-xs font-bold mb-2 uppercase">Category Image</label>
                                <label class="block cursor-pointer group">
                                    <input type="file" class="hidden" @change="handleFileUpload" accept="image/*">
                                    <div class="h-40 w-full rounded-xl border-2 border-dashed border-gray-300 flex flex-col items-center justify-center text-gray-400 hover:border-black hover:text-black hover:bg-gray-50 transition relative overflow-hidden bg-white">
                                        <template x-if="imagePreview">
                                            <div class="h-full w-full relative">
                                                <img :src="imagePreview" class="h-full w-full object-cover">
                                                <div class="absolute inset-0 bg-black/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-200">
                                                    <span class="text-white text-xs font-bold uppercase tracking-wider">Change Image</span>
                                                </div>
                                            </div>
                                        </template>
                                        <template x-if="!imagePreview">
                                            <div class="text-center p-4">
                                                <svg class="mx-auto h-10 w-10 mb-2" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                                <span class="text-xs font-semibold">Click to upload</span>
                                            </div>
                                        </template>
                                    </div>
                                </label>
                            </div>

                        </div>
                        
                        <div class="flex justify-end pt-6 border-t border-gray-100 mt-6">
                            <button type="button" @click="isOpen = false" class="mr-3 px-4 py-2 text-gray-500 hover:text-gray-700 font-bold text-sm uppercase">Cancel</button>
                            <button type="submit" class="bg-black text-white px-6 py-2 rounded-lg font-bold hover:bg-gray-800 transition shadow-lg text-sm uppercase" x-text="isLoading ? 'Saving...' : 'Save Category'" :disabled="isLoading"></button>
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
            editId: null,
            formData: { 
                name: ''
            },
            imageFile: null,
            imagePreview: null,

            openModal() {
                this.isEdit = false;
                this.formData = { 
                    name: ''
                };
                this.imageFile = null;
                this.imagePreview = null;
                this.isOpen = true;
            },

            editCategory(category) {
                this.isEdit = true;
                this.editId = category.id;
                this.formData = { 
                    name: category.name
                };
                this.imageFile = null;
                
                if (category.image) {
                    this.imagePreview = category.image.startsWith('http') ? category.image : '/' + category.image;
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
                            'X-CSRF-TOKEN': "{{ csrf_token() }}",
                            'Accept': 'application/json' 
                        },
                        body: data
                    });
                    
                    const result = await response.json();
                    if (!response.ok) throw result;

                    this.isOpen = false;
                    Swal.fire({ 
                        icon: 'success', 
                        title: 'Success', 
                        text: result.message, 
                        showConfirmButton: false, 
                        timer: 1500 
                    }).then(() => window.location.reload());

                } catch (error) {
                    let errorMessage = 'Something went wrong';
                    if (error.errors) {
                        errorMessage = Object.values(error.errors)[0][0];
                    } else if (error.message) {
                        errorMessage = error.message;
                    }
                    Swal.fire({ icon: 'error', title: 'Error', text: errorMessage });
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
                                headers: { 
                                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                                    'Accept': 'application/json' 
                                }
                            });
                            
                            const resultData = await response.json();

                            if (response.ok) {
                                document.getElementById(`row-${id}`).remove();
                                Swal.fire('Deleted!', resultData.message || 'Category deleted.', 'success');
                            } else {
                                Swal.fire('Error!', resultData.message || 'Could not delete.', 'error');
                            }
                        } catch (e) { 
                            console.error(e);
                            Swal.fire('Error!', 'Network or server error.', 'error');
                        }
                    }
                })
            }
        }
    }
</script>
@endsection