@extends('admin.layouts.app')

@section('title', 'Vouchers')
@section('header', 'Manage Vouchers')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div class="relative w-64">
        <input type="text" placeholder="Search code..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-black focus:border-black text-sm">
        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
    </div>
    <a href="{{ route('admin.vouchers.create') }}" class="bg-black text-white px-4 py-2 rounded-lg font-bold text-sm hover:bg-gray-800 transition shadow-lg">
        + Create Voucher
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-gray-600">
            <thead class="bg-gray-50 text-gray-500 uppercase font-medium">
                <tr>
                    <th class="px-6 py-3">Code / Desc</th>
                    <th class="px-6 py-3">Discount</th>
                    <th class="px-6 py-3">Usage (Left/Total)</th>
                    <th class="px-6 py-3">Period</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($vouchers as $voucher)
                <tr class="hover:bg-gray-50 transition group">
                    <td class="px-6 py-4">
                        <div class="font-bold text-gray-900 uppercase text-base">{{ $voucher->code }}</div>
                        <div class="text-xs text-gray-400 truncate max-w-[150px]">{{ $voucher->description }}</div>
                    </td>
                    <td class="px-6 py-4">
                        @if($voucher->discount_type == 'percent')
                            <span class="text-blue-600 font-bold text-lg">{{ $voucher->discount_value }}%</span>
                            @if($voucher->max_discount_amount)
                            <div class="text-[10px] text-gray-500">Max: {{ number_format($voucher->max_discount_amount, 0, ',', '.') }}₫</div>
                            @endif
                        @else
                            <span class="text-green-600 font-bold text-lg">{{ number_format($voucher->discount_value, 0, ',', '.') }}₫</span>
                        @endif
                        <div class="text-[10px] text-gray-400 mt-1">Min Order: {{ number_format($voucher->min_order_value, 0, ',', '.') }}₫</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <span class="font-bold {{ $voucher->quantity == 0 ? 'text-red-500' : 'text-gray-900' }}">{{ $voucher->quantity }}</span>
                            <span class="text-gray-400">/ {{ $voucher->usage_limit }}</span>
                        </div>
                        <div class="w-24 h-1.5 bg-gray-200 rounded-full mt-1 overflow-hidden">
                            @php $percent = $voucher->usage_limit > 0 ? ($voucher->quantity / $voucher->usage_limit) * 100 : 0; @endphp
                            <div class="h-full {{ $percent < 20 ? 'bg-red-500' : 'bg-black' }}" style="width: {{ $percent }}%"></div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-xs">
                        <div class="whitespace-nowrap">From: {{ $voucher->start_date->format('d/m/Y H:i') }}</div>
                        <div class="whitespace-nowrap text-gray-500">To: {{ $voucher->end_date->format('d/m/Y H:i') }}</div>
                    </td>
                    <td class="px-6 py-4">
                        @if($voucher->isValid())
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-800">
                                <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5"></span> Active
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-100 text-red-800">
                                <span class="w-1.5 h-1.5 bg-red-500 rounded-full mr-1.5"></span> Expired
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex justify-end gap-3">
                            <a href="{{ route('admin.vouchers.edit', $voucher) }}" class="text-gray-500 hover:text-black transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>
                            <form action="{{ route('admin.vouchers.destroy', $voucher) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-gray-500 hover:text-red-600 transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $vouchers->links() }}
    </div>
</div>
@endsection