@extends('admin.layouts.app')

@section('title', 'Create Voucher')
@section('header', 'Add New Voucher')

@section('content')
<div class="max-w-4xl mx-auto">
    <form action="{{ route('admin.vouchers.store') }}" method="POST" class="bg-white p-8 rounded-xl shadow-sm border border-gray-100">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            <div class="space-y-6">
                <h4 class="font-bold text-gray-900 border-b pb-2">Basic Information</h4>
                
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Voucher Code <span class="text-red-500">*</span></label>
                    <input type="text" name="code" value="{{ old('code') }}" class="w-full border-gray-300 rounded-lg focus:ring-black focus:border-black uppercase font-mono tracking-wider" placeholder="SUMMER2025" required>
                    @error('code') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Description</label>
                    <textarea name="description" rows="3" class="w-full border-gray-300 rounded-lg focus:ring-black focus:border-black" placeholder="Discount for summer collection...">{{ old('description') }}</textarea>
                </div>

                <div class="flex items-center">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" checked class="sr-only peer">
                        <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-black"></div>
                        <span class="ms-3 text-sm font-medium text-gray-900">Activate Immediately</span>
                    </label>
                </div>
            </div>

            <div class="space-y-6">
                <h4 class="font-bold text-gray-900 border-b pb-2">Rules & Values</h4>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Type</label>
                        <select name="discount_type" id="discount_type" class="w-full border-gray-300 rounded-lg focus:ring-black focus:border-black">
                            <option value="fixed" {{ old('discount_type') == 'fixed' ? 'selected' : '' }}>Fixed (VND)</option>
                            <option value="percent" {{ old('discount_type') == 'percent' ? 'selected' : '' }}>Percent (%)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Value</label>
                        <input type="number" name="discount_value" value="{{ old('discount_value') }}" class="w-full border-gray-300 rounded-lg focus:ring-black focus:border-black" placeholder="e.g. 50000 or 15" required>
                    </div>
                </div>

                <div id="max_discount_container" class="hidden">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Max Discount Amount (VND)</label>
                    <input type="number" name="max_discount_amount" value="{{ old('max_discount_amount') }}" class="w-full border-gray-300 rounded-lg focus:ring-black focus:border-black bg-gray-50" placeholder="Limit for % discount">
                    <p class="text-xs text-gray-400 mt-1">Leave empty for no limit.</p>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Min Order Value</label>
                    <input type="number" name="min_order_value" value="{{ old('min_order_value', 0) }}" class="w-full border-gray-300 rounded-lg focus:ring-black focus:border-black">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Total Usage Limit (Quantity)</label>
                    <input type="number" name="usage_limit" value="{{ old('usage_limit', 100) }}" class="w-full border-gray-300 rounded-lg focus:ring-black focus:border-black" required>
                    <p class="text-xs text-gray-400 mt-1">Initial quantity will be set to this value.</p>
                </div>
            </div>
        </div>

        <div class="border-t border-gray-100 pt-6 grid grid-cols-1 md:grid-cols-2 gap-8 mb-6">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Start Date</label>
                <input type="datetime-local" name="start_date" value="{{ old('start_date', now()->format('Y-m-d\TH:i')) }}" class="w-full border-gray-300 rounded-lg focus:ring-black focus:border-black">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">End Date</label>
                <input type="datetime-local" name="end_date" value="{{ old('end_date') }}" class="w-full border-gray-300 rounded-lg focus:ring-black focus:border-black">
                @error('end_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="flex justify-end gap-4 pt-4">
            <a href="{{ route('admin.vouchers.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg font-bold hover:bg-gray-50 transition text-gray-700">Cancel</a>
            <button type="submit" class="bg-black text-white px-8 py-2 rounded-lg font-bold hover:bg-red-600 transition shadow-lg transform hover:-translate-y-0.5">Create Voucher</button>
        </div>
    </form>
</div>

<script>
    const typeSelect = document.getElementById('discount_type');
    const maxDiscountDiv = document.getElementById('max_discount_container');

    function toggleMaxDiscount() {
        if (typeSelect.value === 'percent') {
            maxDiscountDiv.classList.remove('hidden');
        } else {
            maxDiscountDiv.classList.add('hidden');
        }
    }

    typeSelect.addEventListener('change', toggleMaxDiscount);
    // Run on load in case of validation error redirect
    toggleMaxDiscount();
</script>
@endsection