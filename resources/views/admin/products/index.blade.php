@extends('admin.layouts.app')

@section('title', 'Products')
@section('header', 'Product Management')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    /* CSS to hide arrows in number inputs */
    input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button { 
        -webkit-appearance: none; 
        margin: 0; 
    }
    input[type=number] {
        -moz-appearance: textfield;
    }
</style>

<div x-data="productManager()">
    
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
            Add Product
        </button>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse whitespace-nowrap">
                <thead class="bg-gray-50 text-gray-500 uppercase text-xs font-semibold">
                    <tr>
                        <th class="px-6 py-4">Image</th>
                        <th class="px-6 py-4">Info</th>
                        <th class="px-6 py-4">Price</th>
                        <th class="px-6 py-4">Attributes</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                    @foreach($products as $product)
                    <tr id="row-{{ $product->id }}" class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">
                            <div class="h-14 w-14 rounded-lg bg-gray-100 border border-gray-200 overflow-hidden relative">
                                @if($product->image)
                                    <img src="{{ asset($product->image) }}" class="h-full w-full object-cover">
                                @else
                                    <div class="h-full w-full flex items-center justify-center text-gray-400 text-xs">No Img</div>
                                @endif
                                @if($product->is_new)
                                    <div class="absolute top-0 right-0 bg-red-500 text-white text-[9px] px-1 font-bold">NEW</div>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-gray-900 truncate w-48" title="{{ $product->name }}">{{ $product->name }}</div>
                            <div class="text-xs text-gray-500 mt-1">Cat: {{ $product->category->name ?? 'N/A' }}</div>
                            <div class="text-xs text-gray-500">Brand: {{ $product->brand }}</div>
                        </td>
                        <td class="px-6 py-4">
                            @if($product->sale_price)
                                <div class="text-red-600 font-bold">{{ number_format($product->sale_price, 0, ',', '.') }}₫</div>
                                <div class="text-gray-400 text-xs line-through">{{ number_format($product->price, 0, ',', '.') }}₫</div>
                            @else
                                <div class="text-gray-900 font-bold">{{ number_format($product->price, 0, ',', '.') }}₫</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-xs">
                            <div>Color: <span class="font-semibold">{{ $product->color }}</span></div>
                            <div>Stock: <span class="{{ $product->stock > 0 ? 'text-green-600 font-bold' : 'text-red-500 font-bold' }}">{{ $product->stock }}</span></div>
                        </td>
                        <td class="px-6 py-4">
                            @if($product->is_active)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Active</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">Hidden</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <button @click='editProduct(@json($product))' class="text-blue-600 hover:text-blue-800 font-semibold text-xs uppercase">Edit</button>
                            <button @click="deleteProduct({{ $product->id }})" class="text-red-500 hover:text-red-700 font-semibold text-xs uppercase">Delete</button>
                        </td>
                    </tr>
                    @endforeach
                    @if($products->isEmpty())
                        <tr><td colspan="6" class="px-6 py-10 text-center text-gray-400">No products found.</td></tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <div x-show="isOpen" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" @click="isOpen = false">
                <div class="absolute inset-0 bg-gray-900 opacity-75"></div>
            </div>

            <div class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl w-full">
                <div class="bg-white px-6 pt-5 pb-4">
                    <h3 class="text-lg font-bold text-gray-900 mb-4" x-text="isEdit ? 'Edit Product' : 'Add New Product'"></h3>
                    
                    <form @submit.prevent="submitForm" enctype="multipart/form-data">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            
                            <div class="md:col-span-2 space-y-4">
                                <div>
                                    <label class="block text-gray-700 text-xs font-bold mb-1 uppercase">Product Name</label>
                                    <input type="text" x-model="formData.name" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-black focus:border-black text-sm" required>
                                </div>
                                
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="relative">
                                        <label class="block text-gray-700 text-xs font-bold mb-1 uppercase">Category</label>
                                        <div class="relative">
                                            <select x-model="formData.category_id" 
                                                    class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg appearance-none focus:outline-none focus:border-gray-400 text-sm pr-10" 
                                                    required>
                                                <option value="">Select Category</option>
                                                @foreach($categories as $cat)
                                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-gray-700 text-xs font-bold mb-1 uppercase">Brand</label>
                                        <input type="text" x-model="formData.brand" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-black focus:border-black text-sm" required>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-gray-700 text-xs font-bold mb-1 uppercase">Color</label>
                                        <input type="text" x-model="formData.color" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-black focus:border-black text-sm" placeholder="e.g. Black" required>
                                    </div>
                                    <div>
                                        <label class="block text-gray-700 text-xs font-bold mb-1 uppercase">Stock</label>
                                        <input type="number" x-model="formData.stock" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-black focus:border-black text-sm" placeholder="Quantity" required>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-gray-700 text-xs font-bold mb-1 uppercase">Price</label>
                                        <input type="number" x-model="formData.price" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-black focus:border-black text-sm" required>
                                    </div>
                                    <div>
                                        <label class="block text-gray-700 text-xs font-bold mb-1 uppercase">Sale Price</label>
                                        <input type="number" x-model="formData.sale_price" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-black focus:border-black text-sm">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-gray-700 text-xs font-bold mb-1 uppercase">Description</label>
                                    <textarea x-model="formData.description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-black focus:border-black text-sm"></textarea>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-gray-700 text-xs font-bold mb-2 uppercase">Product Image</label>
                                    <label class="block cursor-pointer group">
                                        <input type="file" class="hidden" @change="handleFileUpload" accept="image/*">
                                        <div class="h-48 w-full rounded-xl border-2 border-dashed border-gray-300 flex flex-col items-center justify-center text-gray-400 hover:border-black hover:text-black hover:bg-gray-50 transition relative overflow-hidden bg-white">
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
                                                    <svg class="mx-auto h-10 w-10 mb-2" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                    </svg>
                                                    <span class="text-xs font-semibold">Click to upload</span>
                                                </div>
                                            </template>
                                        </div>
                                    </label>
                                </div>

                                <div class="bg-gray-50 p-4 rounded-lg space-y-3 border border-gray-100">
                                    <div class="flex items-center justify-between">
                                        <label for="is_active" class="text-sm font-medium text-gray-900 cursor-pointer">Active Status</label>
                                        <input type="checkbox" 
                                            id="is_active" 
                                            x-model="formData.is_active" 
                                            @change="if(formData.is_active) formData.is_new = false"
                                            class="h-5 w-5 text-black border-gray-300 rounded cursor-pointer focus:ring-0 focus:outline-none">
                                    </div>

                                    <div class="flex items-center justify-between">
                                        <label for="is_new" class="text-sm font-medium text-gray-900 cursor-pointer">New Arrival</label>
                                        <input type="checkbox" 
                                            id="is_new" 
                                            x-model="formData.is_new" 
                                            @change="if(formData.is_new) formData.is_active = false"
                                            class="h-5 w-5 text-black border-gray-300 rounded cursor-pointer focus:ring-0 focus:outline-none">
                                    </div>
                                </div>
                            </div>

                        </div>
                        
                        <div class="flex justify-end pt-6 border-t border-gray-100 mt-6">
                            <button type="button" @click="isOpen = false" class="mr-3 px-4 py-2 text-gray-500 hover:text-gray-700 font-bold text-sm uppercase">Cancel</button>
                            <button type="submit" class="bg-black text-white px-6 py-2 rounded-lg font-bold hover:bg-gray-800 transition shadow-lg text-sm uppercase" x-text="isLoading ? 'Saving...' : 'Save Product'" :disabled="isLoading"></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function productManager() {
        return {
            isOpen: false,
            isEdit: false,
            isLoading: false,
            search: '',
            editId: null,
            formData: { 
                name: '', category_id: '', brand: '', color: '', 
                price: '', sale_price: '', stock: '', // Stock default is empty string
                description: '', is_active: true, is_new: false 
            },
            imageFile: null,
            imagePreview: null,

            openModal() {
                this.isEdit = false;
                this.formData = { 
                    name: '', category_id: '', brand: '', color: '', 
                    price: '', sale_price: '', stock: '', 
                    description: '', is_active: true, is_new: false 
                };
                this.imageFile = null;
                this.imagePreview = null;
                this.isOpen = true;
            },

            editProduct(product) {
                this.isEdit = true;
                this.editId = product.id;
                this.formData = { 
                    name: product.name, 
                    category_id: product.category_id,
                    brand: product.brand,
                    color: product.color,
                    price: product.price,
                    sale_price: product.sale_price,
                    stock: product.stock,
                    description: product.description,
                    is_active: Boolean(product.is_active),
                    is_new: Boolean(product.is_new)
                };
                this.imageFile = null;
                if (product.image) {
                    this.imagePreview = product.image.startsWith('http') ? product.image : '/' + product.image;
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
                let url = this.isEdit ? `/admin/products/${this.editId}` : "{{ route('admin.products.store') }}";
                
                let data = new FormData();
                data.append('name', this.formData.name);
                data.append('category_id', this.formData.category_id);
                data.append('brand', this.formData.brand);
                data.append('color', this.formData.color);
                data.append('price', this.formData.price);
                if(this.formData.sale_price) data.append('sale_price', this.formData.sale_price);
                data.append('stock', this.formData.stock);
                data.append('description', this.formData.description || '');
                
                if(this.formData.is_active) data.append('is_active', '1');
                if(this.formData.is_new) data.append('is_new', '1');

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
                    Swal.fire({ icon: 'success', title: 'Success', text: result.message, showConfirmButton: false, timer: 1500 })
                    .then(() => window.location.reload());

                } catch (error) {
                    Swal.fire({ icon: 'error', title: 'Error', text: error.message || (error.errors ? Object.values(error.errors)[0][0] : 'Something went wrong') });
                } finally {
                    this.isLoading = false;
                }
            },

            deleteProduct(id) {
                Swal.fire({
                    title: 'Delete this product?',
                    text: "Action cannot be undone!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#000',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then(async (result) => {
                    if (result.isConfirmed) {
                        try {
                            const response = await fetch(`/admin/products/${id}`, {
                                method: 'DELETE',
                                headers: { 
                                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                                    'Accept': 'application/json' 
                                }
                            });
                            
                            if (response.ok) {
                                document.getElementById(`row-${id}`).remove();
                                Swal.fire('Deleted!', 'Product has been deleted.', 'success');
                            }
                        } catch (e) { console.error(e); }
                    }
                })
            }
        }
    }
</script>
@endsection