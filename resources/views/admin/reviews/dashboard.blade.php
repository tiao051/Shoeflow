@extends('admin.layouts.app')

@section('title', 'Review Analytics')
@section('header', 'Customer Feedback & Strategy')

@section('content')
<div class="p-6" x-data="reviewAnalytics()">
    
    <!-- Header Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <h3 class="text-gray-500 text-sm font-medium">Total Reviews</h3>
            <p class="text-3xl font-bold text-gray-800 mt-2">1,248</p>
            <span class="text-green-500 text-xs font-bold">+12% this month</span>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <h3 class="text-gray-500 text-sm font-medium">Average Rating</h3>
            <div class="flex items-end mt-2">
                <p class="text-3xl font-bold text-gray-800 mr-2">4.7</p>
                <div class="flex text-yellow-400 mb-1">
                    ★★★★★
                </div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex flex-col justify-center items-center">
            <button @click="generateReport" 
                    :disabled="isLoading"
                    class="w-full h-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg font-bold shadow-lg hover:shadow-xl transition transform hover:-translate-y-0.5 disabled:opacity-70 disabled:cursor-not-allowed flex flex-col items-center justify-center gap-2">
                <template x-if="!isLoading">
                    <span>✨ Generate AI Strategy Report</span>
                </template>
                <template x-if="isLoading">
                    <div class="flex items-center">
                        <svg class="animate-spin h-5 w-5 mr-3 text-white" xmlns="[http://www.w3.org/2000/svg](http://www.w3.org/2000/svg)" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Analyzing Data...
                    </div>
                </template>
                <span class="text-[10px] font-normal opacity-80">Powered by Gemini AI</span>
            </button>
        </div>
    </div>

    <!-- AI Report Content Area -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden min-h-[400px]">
        <div class="p-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
            <h2 class="font-bold text-gray-800 flex items-center gap-2">
                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>
                AI Strategic Analysis
            </h2>
            <span class="text-xs text-gray-500" x-show="lastUpdated">Last updated: <span x-text="lastUpdated"></span></span>
        </div>

        <div class="p-8">
            <!-- Empty State -->
            <div x-show="!reportHtml && !isLoading" class="text-center py-10">
                <div class="bg-gray-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
                <h3 class="text-gray-900 font-medium text-lg">No Report Generated Yet</h3>
                <p class="text-gray-500 mt-2 max-w-md mx-auto">Click the button above to let AI analyze recent customer reviews and generate a development strategy.</p>
            </div>

            <!-- Report Content -->
            <div x-show="reportHtml" class="prose max-w-none animate-fade-in-up">
                <div x-html="reportHtml"></div>
            </div>
        </div>
    </div>

</div>

<script>
    function reviewAnalytics() {
        return {
            isLoading: false,
            reportHtml: '',
            lastUpdated: null,

            async generateReport() {
                this.isLoading = true;
                this.reportHtml = ''; // Clear old report
                
                try {
                    // Call the Controller Endpoint
                    const response = await fetch('/admin/reviews/analyze-ai', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    });
                    
                    const data = await response.json();
                    
                    // Simulate typing effect or just show it
                    this.reportHtml = data.html;
                    this.lastUpdated = new Date().toLocaleString();
                    
                } catch (error) {
                    console.error('Error:', error);
                    alert('Failed to generate report. Please try again.');
                } finally {
                    this.isLoading = false;
                }
            }
        }
    }
</script>

<style>
    /* Simple fade in animation */
    .animate-fade-in-up {
        animation: fadeInUp 0.5s ease-out;
    }
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection