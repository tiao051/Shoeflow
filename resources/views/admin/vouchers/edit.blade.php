@extends('admin.layouts.app')

@section('title', 'Edit Voucher')
@section('header', 'Edit Voucher: ' . $voucher->code)

@section('content')
<div class="max-w-4xl mx-auto">
    <form action="{{ route('admin.vouchers.update', $voucher) }}" method="POST" class="bg-white p-8 rounded-xl shadow-sm border border-gray-100">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            <div class="space-y-6">
                <h4 class="font-bold text-gray-900 border-b pb-2">Basic Information</h4>
                
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Voucher Code</label>
                    <input type="text" name="code" value="{{ old('code', $voucher->code) }}" class="w-full border-gray-300 rounded-lg focus:ring-black focus:border-black uppercase font-mono tracking-wider" required>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Description</label>
                    <textarea name="description" rows="3" class="w-full border-gray-300 rounded-lg focus:ring-black focus:border-black">{{ old('description', $voucher->description) }}</textarea>
                </div>

                <div class="flex items-center">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ $voucher->is_active ? 'checked' : '' }} class="sr-only peer">
                        <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-black"></div>
                        <span class="ms-3 text-sm font-medium text-gray-900">Is Active</span>
                    </label>
                </div>
            </div>

            <div class="space-y-6">
                <h4 class="font-bold text-gray-900 border-b pb-2">Rules & Values</h4>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Type</label>
                        <select name="discount_type" id="discount_type" class="w-full border-gray-300 rounded-lg focus:ring-black focus:border-black">
                            <option value="fixed" {{ $voucher->discount_type == 'fixed' ? 'selected' : '' }}>Fixed (VND)</option>
                            <option value="percent" {{ $voucher->discount_type == 'percent' ? 'selected' : '' }}>Percent (%)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Value</label>
                        <input type="number" name="discount_value" value="{{ old('discount_value', $voucher->discount_value) }}" class="w-full border-gray-300 rounded-lg focus:ring-black focus:border-black" required>
                    </div>
                </div>

                <div id="max_discount_container" class="hidden">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Max Discount Amount (VND)</label>
                    <input type="number" name="max_discount_amount" value="{{ old('max_discount_amount', $voucher->max_discount_amount) }}" class="w-full border-gray-300 rounded-lg focus:ring-black focus:border-black bg-gray-50">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Min Order Value</label>
                    <input type="number" name="min_order_value" value="{{ old('min_order_value', $voucher->min_order_value) }}" class="w-full border-gray-300 rounded-lg focus:ring-black focus:border-black">
                </div>

                <div class="grid grid-cols-2 gap-4 bg-gray-50 p-3 rounded-lg border border-gray-200">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 mb-1">REMAINING Quantity</label>
                        <input type="number" name="quantity" value="{{ old('quantity', $voucher->quantity) }}" class="w-full border-gray-300 rounded-lg focus:ring-black focus:border-black text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 mb-1">TOTAL Usage Limit</label>
                        <div class="py-2 px-3 text-sm font-bold text-gray-700">{{ $voucher->usage_limit }}</div>
                        <input type="hidden" name="usage_limit" value="{{ $voucher->usage_limit }}">
                        </div>
                </div>
            </div>
        </div>

        <div class="border-t border-gray-100 pt-6 grid grid-cols-1 md:grid-cols-2 gap-8 mb-6">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Start Date</label>
                <input type="datetime-local" name="start_date" value="{{ old('start_date', $voucher->start_date->format('Y-m-d\TH:i')) }}" class="w-full border-gray-300 rounded-lg focus:ring-black focus:border-black">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">End Date</label>
                <input type="datetime-local" name="end_date" value="{{ old('end_date', $voucher->end_date->format('Y-m-d\TH:i')) }}" class="w-full border-gray-300 rounded-lg focus:ring-black focus:border-black">
            </div>
        </div>

        <div class="flex justify-end gap-4 pt-4">
            <a href="{{ route('admin.vouchers.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg font-bold hover:bg-gray-50 transition text-gray-700">Cancel</a>
            <button type="submit" class="bg-black text-white px-8 py-2 rounded-lg font-bold hover:bg-red-600 transition shadow-lg">Update Voucher</button>
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
    toggleMaxDiscount();
</script>
@endsection