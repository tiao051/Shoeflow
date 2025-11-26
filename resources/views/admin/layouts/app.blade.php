<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #c1c1c1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #a8a8a8; }
    </style>
</head>
<body class="bg-gray-100 text-gray-800 font-sans antialiased">
    
    <div x-data="{ sidebarOpen: false }" class="flex h-screen overflow-hidden">
        
        <aside class="fixed inset-y-0 left-0 z-50 w-64 bg-black text-white transform transition-transform duration-300 lg:static lg:translate-x-0"
               :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
            
            <div class="flex items-center justify-center h-16 bg-gray-900 shadow-md border-b border-gray-800">
                <span class="text-xl font-black uppercase tracking-widest text-white">SHOES<span class="text-yellow-500">DELREY</span></span>
            </div>

            <nav class="mt-6 px-4 space-y-2">
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-yellow-500 text-black' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
                    Dashboard
                </a>

                <div x-data="{ open: {{ request()->routeIs('admin.categories.*') ? 'true' : 'false' }} }">
                    <button @click="open = !open"
                            class="w-full flex items-center justify-between px-4 py-3 text-sm font-medium rounded-lg hover:bg-gray-800 hover:text-white transition-colors {{ request()->routeIs('admin.categories.*') ? 'text-white' : 'text-gray-400' }}">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                            Catalog
                        </div>
                        <svg class="w-4 h-4 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    </button>

                    <div x-show="open" x-cloak x-transition.origin.top class="pl-12 mt-1 space-y-1">
                        <a href="{{ route('admin.products.index') }}" class="block px-4 py-2 text-sm text-gray-400 hover:text-white hover:bg-gray-800 rounded-md transition-colors">
                            Products
                        </a>
                        <a href="{{ route('admin.categories.index') }}"
                           class="block px-4 py-2 text-sm rounded-md transition-colors {{ request()->routeIs('admin.categories.*') ? 'text-yellow-500 bg-gray-800 font-bold' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                           Categories
                        </a>
                    </div>
                </div>

                <a href="{{ route('admin.orders.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.orders.*') ? 'bg-yellow-500 text-black' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                    Orders
                </a>
                 <a href="{{ route('admin.reviews.index') }}" 
                    class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.reviews.*') ? 'bg-yellow-500 text-black' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    Review Analytics
                </a>
                <a href="{{ route('admin.vouchers.index') }}" 
                    class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors 
                    {{ request()->routeIs('admin.vouchers.*') ? 'bg-yellow-500 text-black' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                    Vouchers
                </a>
                </a>
                <a href="{{ route('admin.customers.index') }}" 
                    class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.customers.*') ? 'bg-yellow-500 text-black' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                    Customers
                </a>
                <a href="{{ route('admin.chat') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.chat') ? 'bg-yellow-500 text-black' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" /></svg>
                    Support Chat
                </a>
            </nav>
        </aside>

        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="flex items-center justify-between px-6 py-4 bg-white shadow-sm border-b">
                <div class="flex items-center">
                    <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 lg:hidden mr-4">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6H20M4 12H20M4 18H11" /></svg>
                    </button>
                    <h2 class="text-xl font-bold text-gray-800">@yield('header', 'Admin Dashboard')</h2>
                </div>

                <div class="flex items-center gap-4 ml-auto">
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="flex items-center gap-2 focus:outline-none hover:bg-gray-50 p-2 rounded-lg transition">
                            <div class="text-right hidden md:block">
                                <span class="block text-sm font-bold text-gray-700">{{ Auth::user()->name }}</span>
                                <span class="block text-xs text-gray-500">Administrator</span>
                            </div>
                            <img class="h-8 w-8 rounded-full object-cover border border-gray-200" src="{{ Auth::user()->avatar ? asset('storage/'.Auth::user()->avatar) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name) }}" alt="Admin">
                            <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </button>
                        <div x-show="open" @click.away="open = false" x-cloak class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 ring-1 ring-black ring-opacity-5 z-50">
                            <form method="POST" action="{{ route('admin.logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 font-bold">Log out</button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6">
                @yield('content')
            </main>
        </div>
        
        <div x-show="sidebarOpen" @click="sidebarOpen = false" x-cloak class="fixed inset-0 z-40 bg-black bg-opacity-50 lg:hidden"></div>
    </div>
</body>

<div id="video-call-modal" class="fixed inset-0 z-[9999] bg-gray-900 hidden flex flex-col">
    <div class="absolute top-0 w-full p-4 flex justify-between items-center z-10 bg-gradient-to-b from-black/50 to-transparent">
        <div class="text-white font-bold text-lg flex items-center gap-2">
            <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
            <span id="call-status-text">Connecting...</span>
        </div>
    </div>

    <div class="flex-1 relative flex items-center justify-center bg-black">
        <video id="remote-video" autoplay playsinline class="w-full h-full object-contain"></video>
        
        <div class="absolute bottom-24 right-4 w-32 h-48 bg-gray-800 rounded-lg overflow-hidden border-2 border-white shadow-xl group">
            <video id="local-video" autoplay playsinline muted class="w-full h-full object-cover transform scale-x-[-1]"></video>
            <div id="local-video-off" class="absolute inset-0 bg-gray-700 flex items-center justify-center text-white font-bold">
                CAM OFF
            </div>
        </div>
    </div>

    <div class="absolute bottom-8 left-0 w-full flex justify-center gap-6 items-center">
        <button id="btn-toggle-mic" class="p-4 bg-gray-600 rounded-full text-white hover:bg-gray-500 transition transform hover:scale-110 shadow-lg">
            <svg id="icon-mic-on" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path></svg>
            <svg id="icon-mic-off" class="w-6 h-6 hidden text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z" clip-rule="evenodd" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2"/></svg>
        </button>
        
        <button id="end-call-btn" class="p-4 bg-red-600 rounded-full text-white hover:bg-red-700 transition transform hover:scale-110 shadow-lg">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2M5 3a2 2 0 00-2 2v1c0 8.284 6.716 15 15 15h1a2 2 0 002-2v-3.28a1 1 0 00-.684-.948l-4.493-1.498a1 1 0 00-1.21.502l-1.13 2.257a11.042 11.042 0 01-5.444-5.444l2.257-1.13a1 1 0 00.502-1.21L9.228 3.683A1 1 0 008.279 3H5z"></path></svg>
        </button>

        <button id="btn-toggle-cam" class="p-4 bg-red-500 rounded-full text-white hover:bg-red-600 transition transform hover:scale-110 shadow-lg">
             <svg id="icon-cam-off" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg>
             <svg id="icon-cam-on" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" /></svg>
        </button>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // --- 1. BIẾN & CẤU HÌNH ---
    const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const ADMIN_ID = {{ auth()->id() ?? 'null' }};
    const rtcConfig = { iceServers: [{ urls: "stun:stun.l.google.com:19302" }] };

    let localStream = null;
    let peerConnection = null;
    let currentCallUserId = null; 
    
    let isMicOn = true; 
    let isCamOn = false; 
    
    let iceCandidatesQueue = [];
    let isRemoteDescriptionSet = false;

    // Âm thanh
    const ringtone = new Audio("{{ asset('sounds/ringtone.mp3') }}");
    ringtone.loop = true;

    // UI Elements
    const videoModal = document.getElementById('video-call-modal');
    const localVideoOff = document.getElementById('local-video-off');
    const btnMic = document.getElementById('btn-toggle-mic');
    const btnCam = document.getElementById('btn-toggle-cam');
    const iconMicOn = document.getElementById('icon-mic-on');
    const iconMicOff = document.getElementById('icon-mic-off');
    const iconCamOn = document.getElementById('icon-cam-on');
    const iconCamOff = document.getElementById('icon-cam-off');
    const endCallBtn = document.getElementById('end-call-btn');

    // --- 2. CÁC HÀM HỖ TRỢ (Định nghĩa trước khi dùng) ---

    function fixSDP(sdp) {
        if (!sdp) return '';
        return sdp.split(/\r\n|\r|\n/).filter(line => line.trim().length > 0).join('\r\n') + '\r\n';
    }

    function stopRingtone() {
        if (ringtone) {
            ringtone.pause();
            ringtone.currentTime = 0;
        }
    }

    function sendSignal(type, payload, toUserId) {
        fetch('/chat/signal', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN },
            body: JSON.stringify({ type: type, payload: payload, to_user_id: toUserId }),
            keepalive: true 
        }).catch(err => console.error("Signal error:", err));
    }

    // --- 3. HÀM TẮT CUỘC GỌI (Core Logic) ---
    // Hàm này giờ đã nằm chung scope với stopRingtone nên sẽ không bị lỗi nữa
    function terminateCall(isInitiator = true) {
        console.log("Admin Terminating call. Initiator:", isInitiator);

        // 1. Tắt chuông ngay lập tức
        stopRingtone();

        // 2. Ẩn UI ngay
        if (videoModal) videoModal.classList.add('hidden');
        
        // 3. Đóng Swal nếu đang hiện (Popup cuộc gọi đến)
        if (Swal.isVisible()) {
            Swal.close();
        }

        // 4. Tắt Media
        if (localStream) {
            localStream.getTracks().forEach(track => {
                track.stop();
                track.enabled = false;
            });
        }

        // 5. Ngắt WebRTC
        if (peerConnection) {
            peerConnection.onicecandidate = null;
            peerConnection.ontrack = null;
            peerConnection.close();
        }

        // 6. Gửi tín hiệu tắt cho User (Nếu Admin là người bấm tắt)
        if (isInitiator && currentCallUserId) {
            sendSignal('hangup', {}, currentCallUserId);
        }

        // 7. Reset biến
        localStream = null;
        peerConnection = null;
        currentCallUserId = null;
        iceCandidatesQueue = [];

        // 8. Reload trang nhẹ để reset state sạch sẽ (Optional)
        setTimeout(() => {
            window.location.reload();
        }, 100);
    }

    // --- 4. LẮNG NGHE SỰ KIỆN TỪ SERVER (Pusher/Echo) ---
    if (ADMIN_ID && window.Echo) {
        console.log('Admin listening on chat.' + ADMIN_ID);
        
        window.Echo.private(`chat.${ADMIN_ID}`)
            .listen('.CallSignalEvent', (e) => {
                console.log("Signal received:", e.data.type);

                // A. USER TẮT MÁY / HỦY CUỘC GỌI
                if (e.data.type === 'hangup') {
                    terminateCall(false); // false vì Admin là người bị tắt
                    return;
                }

                // B. CÓ CUỘC GỌI ĐẾN (Voice Request / Offer)
                if (e.data.type === 'voice' || e.data.type === 'offer') {
                    iceCandidatesQueue = []; 
                    isRemoteDescriptionSet = false;
                    handleIncomingCall(e.data);
                }
                
                // C. WEBRTC SIGNALS
                if (peerConnection) {
                    if (e.data.type === 'answer') {
                            const answerDesc = new RTCSessionDescription({ type: 'answer', sdp: fixSDP(e.data.data.sdp) });
                            peerConnection.setRemoteDescription(answerDesc).then(() => {
                            isRemoteDescriptionSet = true;
                            flushIceQueue();
                            });
                    }
                    if (e.data.type === 'candidate') {
                        const candidate = new RTCIceCandidate(e.data.data);
                        if (isRemoteDescriptionSet) {
                            peerConnection.addIceCandidate(candidate).catch(e => console.error(e));
                        } else {
                            iceCandidatesQueue.push(candidate);
                        }
                    }
                }
            });
    }

    // --- 5. XỬ LÝ CUỘC GỌI ĐẾN ---
    function handleIncomingCall(data) {
        // Chơi nhạc chuông
        var playPromise = ringtone.play();
        if (playPromise !== undefined) playPromise.catch(e => console.warn("Autoplay blocked"));

        // Avatar mặc định nếu null
        let avatarUrl = data.avatar && data.avatar !== 'default.png' ? data.avatar : `https://ui-avatars.com/api/?name=${encodeURIComponent(data.from_name || 'User')}&background=random`;

        Swal.fire({
            title: `Call from ${data.from_name}`,
            text: 'Incoming Support Call...',
            imageUrl: avatarUrl,
            imageWidth: 80, imageHeight: 80, imageAlt: 'User',
            // Fix lỗi 404 ảnh: Nếu ảnh lỗi thì thay bằng ảnh mặc định
            didOpen: () => {
                const img = Swal.getImage();
                if(img) {
                    img.onerror = () => { img.src = "https://ui-avatars.com/api/?name=User&background=random"; };
                }
            },
            showDenyButton: true, confirmButtonText: 'Answer 📞', denyButtonText: 'Decline ❌',
            confirmButtonColor: '#10B981', denyButtonColor: '#EF4444', 
            allowOutsideClick: false, backdrop: `rgba(0,0,0,0.8)`
        }).then(async (result) => {
            stopRingtone(); // Tắt chuông khi bấm nút
            if (result.isConfirmed) {
                await startCallSequence(data);
            } else if (result.isDenied || result.dismiss === Swal.DismissReason.backdrop) {
                // Từ chối -> Gửi hangup
                sendSignal('hangup', {}, data.from_user_id);
            }
        });
    }

    async function startCallSequence(data) {
        currentCallUserId = data.from_user_id; 
        videoModal.classList.remove('hidden');
        document.getElementById('call-status-text').innerText = "Connecting...";
        
        try {
            localStream = await navigator.mediaDevices.getUserMedia({ video: true, audio: true });
            document.getElementById('local-video').srcObject = localStream;

            // Mặc định tắt Cam
            const videoTrack = localStream.getVideoTracks()[0];
            if(videoTrack) { videoTrack.enabled = false; isCamOn = false; updateCamUI(); }
            isMicOn = true; updateMicUI();

            createPeerConnection(data.from_user_id);

            if (data.type === 'offer') {
                await peerConnection.setRemoteDescription(new RTCSessionDescription({ type: 'offer', sdp: fixSDP(data.data.sdp) }));
                isRemoteDescriptionSet = true;
                flushIceQueue();
                const answer = await peerConnection.createAnswer();
                await peerConnection.setLocalDescription(answer);
                sendSignal('answer', answer, data.from_user_id);
            } else {
                const offer = await peerConnection.createOffer();
                await peerConnection.setLocalDescription(offer);
                sendSignal('offer', offer, data.from_user_id);
            }
        } catch (err) {
            alert("Device Error: " + err.message);
            terminateCall(true);
        }
    }

    function createPeerConnection(targetUserId) {
        peerConnection = new RTCPeerConnection(rtcConfig);
        localStream.getTracks().forEach(track => peerConnection.addTrack(track, localStream));

        peerConnection.ontrack = (event) => {
            document.getElementById('remote-video').srcObject = event.streams[0];
            document.getElementById('call-status-text').innerText = "Connected";
        };

        peerConnection.onicecandidate = (event) => {
            if (event.candidate) {
                sendSignal('candidate', event.candidate, targetUserId);
            }
        };
    }

    function flushIceQueue() {
        iceCandidatesQueue.forEach(candidate => peerConnection.addIceCandidate(candidate).catch(e => {}));
        iceCandidatesQueue = [];
    }

    // --- 6. EVENT LISTENERS UI ---
    if(endCallBtn) {
        endCallBtn.addEventListener('click', () => {
            terminateCall(true); // Admin chủ động tắt
        });
    }

    btnMic.addEventListener('click', () => {
        if (localStream && localStream.getAudioTracks()[0]) {
            isMicOn = !isMicOn;
            localStream.getAudioTracks()[0].enabled = isMicOn;
            updateMicUI();
        }
    });
    btnCam.addEventListener('click', () => {
        if (localStream && localStream.getVideoTracks()[0]) {
            isCamOn = !isCamOn;
            localStream.getVideoTracks()[0].enabled = isCamOn;
            updateCamUI();
        }
    });

    function updateMicUI() { 
        if (isMicOn) {
            btnMic.classList.replace('bg-red-500', 'bg-gray-600'); btnMic.classList.replace('hover:bg-red-600', 'hover:bg-gray-500');
            iconMicOn.classList.remove('hidden'); iconMicOff.classList.add('hidden');
        } else {
            btnMic.classList.replace('bg-gray-600', 'bg-red-500'); btnMic.classList.replace('hover:bg-gray-500', 'hover:bg-red-600');
            iconMicOn.classList.add('hidden'); iconMicOff.classList.remove('hidden');
        }
    }
    function updateCamUI() { 
        if (isCamOn) {
            btnCam.classList.replace('bg-red-500', 'bg-gray-600'); btnCam.classList.replace('hover:bg-red-600', 'hover:bg-gray-500');
            iconCamOn.classList.remove('hidden'); iconCamOff.classList.add('hidden'); localVideoOff.classList.add('hidden');
        } else {
            btnCam.classList.replace('bg-gray-600', 'bg-red-500'); btnCam.classList.replace('hover:bg-gray-500', 'hover:bg-red-600');
            iconCamOn.classList.add('hidden'); iconCamOff.classList.remove('hidden'); localVideoOff.classList.remove('hidden');
        }
    }
});
</script>
</html>