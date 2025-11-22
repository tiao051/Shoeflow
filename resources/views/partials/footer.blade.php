<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        /* Hiệu ứng hover nhẹ cho icon */
        .footer-icon-group:hover svg {
            transform: translateY(-3px);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        /* Màu icon khi hover */
        .footer-icon-group:hover .icon-path {
            fill: #444; /* Màu xám đậm khi hover */
        }
    </style>
</head>
<body>

    <footer class="bg-white text-black border-t border-gray-200 pt-14 pb-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">            
            
            <div class="grid grid-cols-1 md:grid-cols-3 divide-y md:divide-y-0 md:divide-x divide-gray-200 mb-12">            
                
                <div class="group footer-icon-group flex flex-col items-center justify-center px-4 py-8 md:py-0">
                    <div class="mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-black transition duration-300" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M3.375 4.5C2.339 4.5 1.5 5.34 1.5 6.375V13.5h12V6.375c0-1.036-.84-1.875-1.875-1.875h-8.25zM13.5 15h-12v2.625c0 1.035.84 1.875 1.875 1.875h.375a3 3 0 116 0h3a.75.75 0 00.75-.75V15z" />
                            <path d="M8.25 19.5a1.5 1.5 0 10-3 0 1.5 1.5 0 003 0zM15.75 6.75a.75.75 0 00-.75.75v11.25c0 .087.015.17.042.248a3 3 0 015.958.464c.853-.175 1.522-.935 1.464-1.883a18.659 18.659 0 00-3.732-10.104 1.837 1.837 0 00-1.47-.725H15.75z" />
                            <path d="M19.5 19.5a1.5 1.5 0 10-3 0 1.5 1.5 0 003 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-black uppercase tracking-tight mb-2 text-center">Fast, Free Shipping</h3>
                    <p class="text-sm text-gray-500 font-medium text-center">Free Shipping on every order</p>
                </div>

                <div class="group footer-icon-group flex flex-col items-center justify-center px-4 py-8 md:py-0">
                    <div class="mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-black transition duration-300" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.755 10.059a7.5 7.5 0 0112.548-3.364l1.903 1.903h-3.183a.75.75 0 100 1.5h4.992a.75.75 0 00.75-.75V4.356a.75.75 0 00-1.5 0v3.18l-1.9-1.9A9 9 0 003.306 9.67a.75.75 0 101.45.388zm15.408 3.352a.75.75 0 00-.919.53 7.5 7.5 0 01-12.548 3.364l-1.902-1.903h3.183a.75.75 0 000-1.5H2.984a.75.75 0 00-.75.75v4.992a.75.75 0 001.5 0v-3.18l1.9 1.9a9 9 0 0015.059-4.035.75.75 0 00-.53-.918z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-black uppercase tracking-tight mb-2 text-center">Worry-Free Returns</h3>
                    <p class="text-sm text-gray-500 font-medium text-center">Terms & conditions apply</p>
                </div>

                <div class="group flex flex-col items-center justify-center px-4 py-8 md:py-0">
                    <div class="mb-4 flex space-x-5">
                        <a href="#" class="transform hover:scale-110 transition duration-200">
                            <svg class="h-10 w-10 text-black" viewBox="0 0 24 24" fill="currentColor">
                                <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="#" class="transform hover:scale-110 transition duration-200">
                            <svg class="h-10 w-10 text-black" viewBox="0 0 24 24" fill="currentColor">
                                <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.451 2.53c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                    <h3 class="text-lg font-black uppercase tracking-tight mb-2 text-center">Follow Us</h3>
                    <p class="text-sm text-gray-500 font-medium text-center">Keep up with the latest Converse</p>
                </div>
            </div>         
            <div class="text-center pt-4 border-t border-gray-100">
                <p class="text-[12px] text-gray-600 tracking-wide">
                    &copy; Copyright 2023 Magna Management Asia (MMA) Co., Ltd. All rights reserved.
                </p>
            </div>
        </div>
    </footer>

</body>
</html>