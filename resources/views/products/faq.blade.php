@extends('layouts.app')

@section('content')
<div class="bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <h1 class="text-5xl font-black text-gray-900 mb-4 tracking-tight">HELP & FAQ</h1>
        <p class="text-gray-600 text-lg mb-12">Find answers to common questions about Converse products and orders.</p>

        <!-- Search -->
        <div class="mb-12">
            <input type="text" placeholder="Search FAQ..." class="w-full px-6 py-4 border-2 border-gray-300 rounded hover:border-gray-900 focus:outline-none focus:border-gray-900 font-semibold">
        </div>

        <!-- FAQ Accordion -->
        <div class="space-y-4">
            @foreach([
                ['question' => 'What is your shipping policy?', 'answer' => 'We offer free shipping on orders over 2 million VND. Standard shipping takes 3-5 business days. Express shipping is available for rush orders.'],
                ['question' => 'How long do returns take?', 'answer' => 'We accept returns within 30 days of purchase. Items must be unworn and in original packaging. Refunds are processed within 7-10 business days.'],
                ['question' => 'Do you have a size guide?', 'answer' => 'Yes! Each product page includes a detailed size guide. We recommend measuring your foot and comparing with our chart for the best fit.'],
                ['question' => 'Are your products authentic?', 'answer' => 'All Converse products sold on our website are 100% authentic and directly from Converse. We only sell genuine products.'],
                ['question' => 'Can I customize my shoes?', 'answer' => 'Yes! We offer customization services on most Converse models. Visit our customization section or contact our support team for details.'],
            ] as $faq)
                <div class="border border-gray-200 rounded" x-data="{ open: false }">
                    <button @click="open = !open" class="w-full px-6 py-4 flex justify-between items-center hover:bg-gray-50 transition">
                        <span class="font-bold text-gray-900 text-left">{{ $faq['question'] }}</span>
                        <svg class="w-5 h-5 transition transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                        </svg>
                    </button>
                    <div x-show="open" class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                        <p class="text-gray-600">{{ $faq['answer'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Contact Support -->
        <div class="mt-16 bg-gray-50 rounded p-8 text-center">
            <h2 class="text-2xl font-black text-gray-900 mb-4 tracking-wide">DIDN'T FIND WHAT YOU'RE LOOKING FOR?</h2>
            <p class="text-gray-600 mb-6">Our customer service team is here to help!</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="mailto:support@converse.vn" class="bg-black text-white px-8 py-3 rounded-full font-bold hover:bg-gray-800 transition">
                    EMAIL US
                </a>
                <a href="https://chat.converse.vn" class="border-2 border-gray-900 text-gray-900 px-8 py-3 rounded-full font-bold hover:bg-gray-50 transition">
                    LIVE CHAT
                </a>
            </div>
        </div>
    </div>
</div>
@endsection