<script src="https://cdn.tailwindcss.com"></script>
<style>
    /* Setting Inter font for the entire footer */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');
    
    .converse-footer {
        font-family: 'Inter', sans-serif;
        background-color: #ffffff;
        color: #000000;
    }

    /* Common style for links */
    .footer-link {
        @apply text-sm text-gray-700 hover:text-black transition duration-150;
    }

    /* Style for column titles */
    .footer-col-title {
        @apply font-bold text-lg mb-4 uppercase;
    }

    /* Base style for the Explore grid items (not present in the provided code, but kept for general utility) */
    .explore-grid-item-base {
        @apply flex items-center p-4 border-gray-200 transition duration-150 hover:bg-gray-50;
    }
    
    /* Email subscription input and button */
    .email-input-group {
        @apply flex w-full max-w-sm;
    }
    .email-input {
        @apply flex-grow p-3 border border-gray-300 rounded-l-lg text-sm focus:ring-0 focus:border-black;
    }
    .email-submit-btn {
        @apply bg-black text-white p-3 rounded-r-lg hover:bg-gray-800 transition duration-150;
    }
</style>

<footer class="converse-footer border-t border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    
        <!-- SECTION 2: 3 ICON & MAIN LINK COLUMNS -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 py-10 border-b border-gray-200 text-center">
            
            <!-- Column 1: Fast, Free Shipping -->
            <div class="flex flex-col items-center md:border-r md:border-gray-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-black mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                </svg>
                <h3 class="font-bold text-lg mb-1">FAST, FREE SHIPPING</h3>
                <p class="text-xs text-gray-500">Free Shipping on every order</p>
            </div>

            <!-- Column 2: Worry-Free Returns -->
            <div class="flex flex-col items-center md:border-r md:border-gray-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-black mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m3.98-2.908a2.9 2.9 0 00-4.04 0L4 7.68M19 14v5h-.581m-15.356-2A8.001 8.001 0 0019.418 15m-3.98 2.908a2.9 2.9 0 004.04 0L20 16.32" />
                </svg>
                <h3 class="font-bold text-lg mb-1">WORRY-FREE RETURNS</h3>
                <p class="text-xs text-gray-500">Terms & conditions apply</p>
            </div>

            <!-- Column 3: Follow Us -->
            <div class="flex flex-col items-center">
                <div class="flex space-x-4 mb-3">
                    <!-- Placeholder Social Icon 1 (Facebook/Instagram/etc.) -->
                    <a href="#" class="text-black hover:text-gray-600">
                        <svg viewBox="0 0 24 24" class="h-6 w-6" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm3.5 6.5h-2v2h2v2h-2v4H9v-4H7v-2h2V7.5a2.5 2.5 0 012.5-2.5h2V6h1.5a.5.5 0 010 1h-1v1.5z"/></svg>
                    </a>
                    <!-- Placeholder Social Icon 2 -->
                    <a href="#" class="text-black hover:text-gray-600">
                        <svg viewBox="0 0 24 24" class="h-6 w-6" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm3.5 6.5h-2v2h2v2h-2v4H9v-4H7v-2h2V7.5a2.5 2.5 0 012.5-2.5h2V6h1.5a.5.5 0 010 1h-1v1.5z"/></svg>
                    </a>
                </div>
                <h3 class="font-bold text-lg mb-1">FOLLOW US</h3>
                <p class="text-xs text-gray-500">Keep up with the latest Converse</p>
            </div>
        </div>
        
        <!-- SECTION 4: COPYRIGHT & LEGAL -->
        <div class="text-center py-6 border-t border-gray-100">
            <p class="text-xs text-gray-500">
                &copy; Copyright 2023 Magna Management Asia (MMA) Co., Ltd. All rights reserved.
            </p>
        </div>
        
    </div>
</footer>