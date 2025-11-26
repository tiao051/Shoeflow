<div class="top-bar visible bg-gray-100 text-gray-800 text-xs py-2 border-b border-gray-200">
    <div class="top-bar-content container mx-auto px-4 relative flex justify-between items-center h-6">
        <div class="top-bar-item flex items-center space-x-2 z-10">
            <img src="https://www.converse.vn/media/wysiwyg/VN_Flag.jpg" alt="VN" class="w-4 h-3 rounded shadow">
            <span class="font-medium">VN</span>
        </div>

        <div class="absolute inset-0 flex justify-center items-center promo-content text-center font-bold text-xs pointer-events-none">
            <a href="#" class="hover:underline pointer-events-auto text-black">
                <span>Up to 400K off for order from 2 mil - Shop Now!</span>
            </a>
        </div>

        <div class="flex items-center space-x-6 text-xs font-normal text-gray-600 z-10">
           <a href="{{ route('stores.index') }}" class="top-bar-item hover:text-black hidden md:flex items-center space-x-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span>Store Locator</span>
            </a>
            <a href="#" id="startCallButton" role="button" class="top-bar-item hover:text-black hidden lg:flex items-center space-x-1 transition duration-150 ease-in-out group">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600 group-hover:text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.128a11.056 11.056 0 005.44 5.44l1.128-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.948V19a2 2 0 01-2 2h-1C9.717 21 3 14.283 3 6V5z" />
                </svg>
                <span class="font-semibold">Call Staff</span>
            </a>
        </div>
    </div>
</div>
<hr class="border-gray-200 hidden md:block" />

<header class="bg-white sticky top-0 z-[20] shadow-md">
    <div class="container mx-auto px-4 header-content flex items-center justify-between h-16">
        
        <a href="{{ url('/') }}" class="logo text-2xl font-extrabold tracking-widest text-black flex-shrink-0">CONVERSE</a>
        
        <div class="nav-center hidden lg:flex space-x-8 mx-12 text-sm">
            <a href="{{ route('products.run-star-trainer') }}" class="font-bold hover:text-gray-600 transition-colors">Run Star Trainer</a>
            <a href="{{ route('fits.index') }}" class="font-bold hover:text-gray-600 transition-colors">Fits with Converse</a>
            <a href="{{ route('limited.index') }}" class="font-bold hover:text-gray-600 transition-colors">Limited Edition</a>
            <a href="{{ route('products.sale') }}" class="sale font-bold text-red-600 hover:text-red-800 transition-colors">Sale Up To 50%</a>
        </div>

        <div class="nav-right space-x-6 ml-auto relative flex items-center flex-shrink-0">
            
            <a href="/profile" class="header-icon hover:text-gray-600 transition-colors hidden md:block">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </a>

            <a href="/wishlist" class="header-icon hover:text-gray-600 transition-colors hidden md:block">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 22l7.682-7.318a4.5 4.5 0 00-6.364-6.364L12 7.682l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
            </a>
            
            <a href="{{ route('cart.index') }}" class="header-icon hover:text-gray-600 transition-colors relative">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
            
                <span id="cart-count" class="absolute -top-2 -right-2 bg-red-600 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full">
                    {{ $cartCount ?? 0 }}
                </span>
            </a>

            <div id="search-container" class="relative z-50 h-16 w-16 -mr-8 -my-6 flex-shrink-0">
                
                <form action="{{ route('search.index') }}" method="GET" 
                    id="search-form"
                    class="absolute right-0 top-0 h-full bg-white flex items-center shadow-2xl border border-black transition-all duration-500 ease-in-out w-16 overflow-visible">
                    
                    <input type="text" 
                            name="q"
                            id="search-input"
                            placeholder="Search something..." 
                            class="w-full h-full bg-transparent outline-none border-none text-base font-medium text-black placeholder-gray-500 pl-6 pr-16 opacity-0 pointer-events-none transition-opacity duration-300"
                            autocomplete="off">

                    <button type="submit" 
                            class="absolute right-0 top-0 h-16 w-16 bg-black text-white border-l border-black flex items-center justify-center hover:bg-gray-800 transition-colors cursor-pointer z-10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>

                    <div id="search-suggestions" 
                        class="absolute top-full left-0 w-full max-h-80 overflow-y-auto bg-white border border-t-0 border-black shadow-xl hidden z-40">
                    </div>
                </form>
            </div>
            
            <button class="hamburger ml-4 lg:hidden header-icon hover:text-gray-600 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
    </div>

    <div class="mobile-menu hidden lg:hidden bg-white border-t border-gray-200 py-4 absolute w-full" id="mobileMenu">
        <a href="#" class="block px-4 py-2 hover:bg-gray-100">Run Star Trainer</a>
        <a href="#" class="block px-4 py-2 hover:bg-gray-100">Men</a>
        <a href="#" class="block px-4 py-2 hover:bg-gray-100">Women</a>
        <a href="#" class="block px-4 py-2 hover:bg-gray-100">Limited Edition</a>
        <a href="#" class="block px-4 py-2 hover:bg-gray-100 sale text-red-600">Sale Up To 50%</a>
        <a href="#" class="block px-4 py-2 hover:bg-gray-100 border-t mt-2">Sign In</a>
    </div>

    {{-- CHAT BOX START --}}
    @auth
    <button id="chat-open-btn"
    class="fixed bottom-6 right-6 z-50 bg-black text-white p-3 rounded-full shadow-2xl hover:bg-red-600 transition duration-300 transform hover:scale-110"
    title="Open Chat Box">
        <svg xmlns="http://www.w3.org/2000/svg" 
            class="h-8 w-8" 
            fill="none" 
            viewBox="0 0 24 24" 
            stroke="currentColor" 
            stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 4v-4z" />
        </svg>
    </button>

    <div id="chat-popup" 
     class="fixed bottom-[100px] right-6 z-[49] bg-white rounded-xl shadow-2xl border border-gray-200 
            transform translate-y-4 opacity-0 scale-95 transition-all duration-300 pointer-events-none invisible flex flex-col
            w-[calc(100vw-24px)] h-[calc(100vh-120px)] 
            max-w-full bottom-3 right-3                  
            sm:w-[350px] sm:h-[400px]                
            sm:bottom-[100px] sm:right-6              
            sm:max-w-sm">

        <div class="p-4 bg-black text-white rounded-t-xl flex justify-between items-center flex-shrink-0">
            <h4 class="font-bold text-base uppercase">Customer Support</h4>
            <button id="chat-close-btn" class="text-gray-300 hover:text-white transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="flex-grow p-4 overflow-y-auto bg-gray-50 space-y-3" id="chat-history">
            </div>

        <div class="p-3 border-t flex items-center flex-shrink-0">
            <input type="text" placeholder="Type a message..." id="chat-input"
                class="flex-grow p-2 border border-gray-300 rounded-l-lg text-sm focus:border-black focus:ring-0 outline-none">
            
            <button id="chat-send-btn" class="bg-black text-white p-2 rounded-r-lg hover:bg-red-600 transition duration-200 ml-[-1px]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 rotate-90" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                </svg>
            </button>
        </div>
    </div>
    @endauth
    {{-- CHAT BOX END --}}
    <div id="calling-overlay" class="fixed inset-0 bg-black bg-opacity-80 z-[100] hidden flex flex-col items-center justify-center text-white transition-opacity duration-300">
        <div class="animate-pulse mb-6">
            <img src="https://ui-avatars.com/api/?name=Admin&background=random" class="w-24 h-24 rounded-full border-4 border-white shadow-lg">
        </div>
        <h2 class="text-2xl font-bold mb-2">Calling Support...</h2>
        <p class="text-gray-300 mb-8">Please wait while we connect you.</p>
        
        <button id="cancel-call-btn" class="bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-8 rounded-full shadow-lg transition transform hover:scale-105 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2M5 3a2 2 0 00-2 2v1c0 8.284 6.716 15 15 15h1a2 2 0 002-2v-3.28a1 1 0 00-.684-.948l-4.493-1.498a1 1 0 00-1.21.502l-1.13 2.257a11.042 11.042 0 01-5.444-5.444l2.257-1.13a1 1 0 00.502-1.21L9.228 3.683A1 1 0 008.279 3H5z" />
            </svg>
            End Call
        </button>
    </div>
</header>
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
            <div id="local-video-off" class="absolute inset-0 bg-gray-700 flex items-center justify-center hidden">
                <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                </svg>
            </div>
        </div>
    </div>

    <div class="absolute bottom-8 left-0 w-full flex justify-center gap-6 items-center">
        <button id="btn-toggle-mic" class="p-4 rounded-full text-white transition transform hover:scale-110 shadow-lg bg-gray-600 hover:bg-gray-500">
            <svg id="icon-mic-on" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path></svg>
            <svg id="icon-mic-off" class="w-6 h-6 hidden text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z" clip-rule="evenodd" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2"/></svg>
        </button>

        <button id="end-call-btn" class="p-4 bg-red-600 rounded-full text-white hover:bg-red-700 transition transform hover:scale-110 shadow-lg">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2M5 3a2 2 0 00-2 2v1c0 8.284 6.716 15 15 15h1a2 2 0 002-2v-3.28a1 1 0 00-.684-.948l-4.493-1.498a1 1 0 00-1.21.502l-1.13 2.257a11.042 11.042 0 01-5.444-5.444l2.257-1.13a1 1 0 00.502-1.21L9.228 3.683A1 1 0 008.279 3H5z"></path></svg>
        </button>

        <button id="btn-toggle-cam" class="p-4 rounded-full text-white transition transform hover:scale-110 shadow-lg bg-red-500 hover:bg-red-600">
             <svg id="icon-cam-off" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg>
             <svg id="icon-cam-on" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" /></svg>
        </button>
    </div>
</div>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // --- 0. CONFIG ---
    const BASE_URL = '{{ asset('/') }}';
    const AUTH_USER_ID = {{ auth()->id() ?? 'null' }};
    const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    const rtcConfig = { iceServers: [{ urls: "stun:stun.l.google.com:19302" }] };

    // --- VARIABLES ---
    let localStream = null;
    let peerConnection = null;
    let isMicOn = true;    
    let isCamOn = false;   
    let currentRemoteUserId = null; // ID của Admin đang kết nối

    // --- DOM ELEMENTS ---
    const videoModal = document.getElementById('video-call-modal');
    const callingOverlay = document.getElementById('calling-overlay');
    const startCallBtn = document.getElementById('startCallButton');
    const cancelCallBtn = document.getElementById('cancel-call-btn');
    const endCallBtn = document.getElementById('end-call-btn');
    
    const btnMic = document.getElementById('btn-toggle-mic');
    const btnCam = document.getElementById('btn-toggle-cam');
    const iconMicOn = document.getElementById('icon-mic-on');
    const iconMicOff = document.getElementById('icon-mic-off');
    const iconCamOn = document.getElementById('icon-cam-on');
    const iconCamOff = document.getElementById('icon-cam-off');
    const localVideoOff = document.getElementById('local-video-off');

    // Chat Elements
    const chatPopup = document.getElementById('chat-popup');
    const chatInput = document.getElementById('chat-input');
    const sendBtn = document.getElementById('chat-send-btn');
    const chatHistory = document.getElementById('chat-history');
    const openBtn = document.getElementById('chat-open-btn');
    const closeBtn = document.getElementById('chat-close-btn');
    const CHAT_STATE_KEY = 'chatPopupState';

    // --- 1. WEBRTC FUNCTIONS ---

    function fixSDP(sdp) {
        if (!sdp) return '';
        const lines = sdp.split(/\r\n|\r|\n/);
        return lines.filter(l => l.trim().length > 0).join('\r\n') + '\r\n';
    }

    function sendSignal(type, payload, toUserId) {
        // Nếu toUserId null (chưa kết nối), vẫn gửi để backend có thể xử lý broadcast tắt
        fetch('/chat/signal', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN },
            body: JSON.stringify({ type: type, payload: payload, to_user_id: toUserId }),
            keepalive: true
        });
    }

    // HÀM QUAN TRỌNG: TẮT CUỘC GỌI
    function terminateCall(isInitiator = true) {
        console.log("User terminating call. Initiator:", isInitiator);

        // 1. Gửi tín hiệu Hangup (Chỉ gửi nếu mình là người chủ động tắt)
        if (isInitiator) {
             sendSignal('hangup', {}, currentRemoteUserId);
        }

        // 2. Dừng Media
        if (localStream) {
            localStream.getTracks().forEach(track => {
                track.stop();
                track.enabled = false;
            });
        }

        // 3. Đóng kết nối
        if (peerConnection) {
            peerConnection.close();
        }

        // 4. Reset UI & Biến
        localStream = null;
        peerConnection = null;
        currentRemoteUserId = null;

        if (videoModal) videoModal.classList.add('hidden');
        if (callingOverlay) callingOverlay.classList.add('hidden');
    }

    async function initCallMediaAndConnection(remoteUserId, offerData) {
        try {
            currentRemoteUserId = remoteUserId; // Lưu ID Admin để gửi hangup sau này

            localStream = await navigator.mediaDevices.getUserMedia({ video: true, audio: true });

            // Default Cam Off
            const videoTrack = localStream.getVideoTracks()[0];
            if(videoTrack) videoTrack.enabled = false; 
            isCamOn = false; updateCamUI(); 
            isMicOn = true; updateMicUI();

            const localVideo = document.getElementById('local-video');
            if (localVideo) localVideo.srcObject = localStream;

            createPeerConnection(remoteUserId);

            const fixedSdpString = fixSDP(offerData.sdp);
            const sessionDesc = new RTCSessionDescription({ type: offerData.type, sdp: fixedSdpString });
            await peerConnection.setRemoteDescription(sessionDesc);
            
            const answer = await peerConnection.createAnswer();
            await peerConnection.setLocalDescription(answer);
            
            sendSignal('answer', answer, remoteUserId);

        } catch (err) {
            console.error("Media Error:", err);
            alert("Connection Error: " + err.message);
            terminateCall(true);
        }
    }

    function createPeerConnection(targetUserId) {
        peerConnection = new RTCPeerConnection(rtcConfig);
        if (localStream) localStream.getTracks().forEach(track => peerConnection.addTrack(track, localStream));

        peerConnection.ontrack = (event) => {
            const remoteVideo = document.getElementById('remote-video');
            if (remoteVideo) remoteVideo.srcObject = event.streams[0];
            const statusText = document.getElementById('call-status-text');
            if (statusText) statusText.innerText = "Connected";
        };

        peerConnection.onicecandidate = (event) => {
            if (event.candidate) sendSignal('candidate', event.candidate, targetUserId);
        };
    }

    // --- 2. LISTENERS ---

    // Xử lý Echo
    if (AUTH_USER_ID) {
        initChatAndCall();
    }

    function initChatAndCall() {
        loadMessagesFromServer();
        const state = localStorage.getItem(CHAT_STATE_KEY);
        if (state === 'open') openChatUI();

        let echoCheck = setInterval(() => {
            if (window.Echo) {
                clearInterval(echoCheck);
                console.log('Echo loaded. Listening.' + AUTH_USER_ID);

                window.Echo.private(`chat.${AUTH_USER_ID}`)
                    .listen('.message.sent', (e) => {
                        if (e.message.is_admin) {
                            createMessage(e.message.message, false);
                            if (chatPopup.classList.contains('invisible')) openChatUI();
                        }
                    })
                    .listen('.CallSignalEvent', async (e) => {
                        console.log("Signal Received:", e.data.type);

                        // ADMIN TẮT / TỪ CHỐI
                        if (e.data.type === 'hangup') {
                            terminateCall(false); 
                            return; 
                        }

                        if (e.data.type === 'offer') {
                            if (callingOverlay) callingOverlay.classList.add('hidden');
                            if (videoModal) videoModal.classList.remove('hidden');
                            await initCallMediaAndConnection(e.data.from_user_id, e.data.data);
                        }
                        else if (e.data.type === 'answer') {
                            if (peerConnection) {
                                const answerSdp = fixSDP(e.data.data.sdp);
                                await peerConnection.setRemoteDescription(new RTCSessionDescription({ type: e.data.data.type, sdp: answerSdp }));
                            }
                        }
                        else if (e.data.type === 'candidate') {
                            if (peerConnection) await peerConnection.addIceCandidate(new RTCIceCandidate(e.data.data));
                        }
                    });
            }
        }, 500); 
    }

    // BUTTON EVENTS
    if (startCallBtn) {
        startCallBtn.addEventListener('click', function(e) {
            e.preventDefault();
            if (!AUTH_USER_ID) { Swal.fire({ icon: 'warning', title: 'Login Required', text: 'Please login first!' }); return; }
            
            Swal.fire({
                title: 'Contact Support?', text: "Start voice/video call?", icon: 'question',
                showCancelButton: true, confirmButtonText: 'Yes, Call Now!'
            }).then((result) => {
                if (result.isConfirmed) {
                    if (callingOverlay) callingOverlay.classList.remove('hidden');
                    // Gửi tín hiệu rung chuông
                    fetch('/chat/signal', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN },
                        body: JSON.stringify({ type: 'voice', signal: 'ringing' })
                    }).catch(err => {
                        console.error(err);
                        if (callingOverlay) callingOverlay.classList.add('hidden');
                    });
                }
            });
        });
    }

    if (cancelCallBtn) {
        cancelCallBtn.addEventListener('click', function() {
            // Hủy khi đang chờ (chưa có ID admin, nhưng vẫn gọi terminateCall để gửi hangup rỗng hoặc reset UI)
            terminateCall(true);
        });
    }
    
    if (endCallBtn) {
        endCallBtn.addEventListener('click', function() {
            terminateCall(true);
        });
    }

    // UI Buttons (Cam/Mic)
    if(btnMic) btnMic.addEventListener('click', () => { if(localStream && localStream.getAudioTracks()[0]) { isMicOn = !isMicOn; localStream.getAudioTracks()[0].enabled = isMicOn; updateMicUI(); } });
    if(btnCam) btnCam.addEventListener('click', () => { if(localStream && localStream.getVideoTracks()[0]) { isCamOn = !isCamOn; localStream.getVideoTracks()[0].enabled = isCamOn; updateCamUI(); } });

    function updateMicUI() {
        if (isMicOn) { btnMic.classList.replace('bg-red-500', 'bg-gray-600'); btnMic.classList.replace('hover:bg-red-600', 'hover:bg-gray-500'); iconMicOn?.classList.remove('hidden'); iconMicOff?.classList.add('hidden'); }
        else { btnMic.classList.replace('bg-gray-600', 'bg-red-500'); btnMic.classList.replace('hover:bg-gray-500', 'hover:bg-red-600'); iconMicOn?.classList.add('hidden'); iconMicOff?.classList.remove('hidden'); }
    }
    function updateCamUI() {
        if (isCamOn) { btnCam.classList.replace('bg-red-500', 'bg-gray-600'); btnCam.classList.replace('hover:bg-red-600', 'hover:bg-gray-500'); iconCamOn?.classList.remove('hidden'); iconCamOff?.classList.add('hidden'); localVideoOff?.classList.add('hidden'); }
        else { btnCam.classList.replace('bg-gray-600', 'bg-red-500'); btnCam.classList.replace('hover:bg-gray-500', 'hover:bg-red-600'); iconCamOn?.classList.add('hidden'); iconCamOff?.classList.remove('hidden'); localVideoOff?.classList.remove('hidden'); }
    }

    // Chat Functions (Giữ nguyên logic chat cũ)
    function openChatUI() { chatPopup.classList.remove('invisible', 'opacity-0', 'translate-y-4', 'scale-95', 'pointer-events-none'); chatPopup.classList.add('opacity-100', 'translate-y-0', 'scale-100'); scrollToBottom(); localStorage.setItem(CHAT_STATE_KEY, 'open'); }
    function closeChatUI() { chatPopup.classList.remove('opacity-100', 'translate-y-0', 'scale-100'); chatPopup.classList.add('opacity-0', 'translate-y-4', 'scale-95', 'pointer-events-none'); setTimeout(() => chatPopup.classList.add('invisible'), 300); localStorage.setItem(CHAT_STATE_KEY, 'closed'); }
    function scrollToBottom() { if (chatHistory) chatHistory.scrollTop = chatHistory.scrollHeight; }
    
    openBtn?.addEventListener('click', () => { if (chatPopup.classList.contains('invisible')) openChatUI(); else closeChatUI(); });
    closeBtn?.addEventListener('click', closeChatUI);
    sendBtn?.addEventListener('click', handleSendMessage);
    chatInput?.addEventListener('keypress', function(e) { if (e.key === 'Enter') { e.preventDefault(); handleSendMessage(); } });

    function createMessage(text, isUser) {
        const messageWrapper = document.createElement('div'); messageWrapper.classList.add('flex', isUser ? 'justify-end' : 'justify-start');
        const messageBody = document.createElement('div'); messageBody.classList.add('p-3', 'rounded-xl', 'max-w-[80%]', 'text-sm', 'shadow-sm', 'break-words', isUser ? 'bg-red-600' : 'bg-gray-200', isUser ? 'text-white' : 'text-gray-800', isUser ? 'rounded-br-none' : 'rounded-tl-none');
        messageBody.innerHTML = text; messageWrapper.appendChild(messageBody); chatHistory.appendChild(messageWrapper); scrollToBottom();
    }
    async function handleSendMessage() {
        const text = chatInput.value.trim(); if (!text) return;
        createMessage(text, true); chatInput.value = ''; chatInput.focus();
        try { await fetch('/chat/send', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN, 'X-Socket-ID': window.Echo ? window.Echo.socketId() : null }, body: JSON.stringify({ message: text }) }); } catch (error) { console.error('Error sending message:', error); }
    }
    async function loadMessagesFromServer() {
        try { const response = await fetch('/chat/messages'); const messages = await response.json(); chatHistory.innerHTML = `<div class="flex justify-start"><div class="bg-gray-200 text-gray-800 p-3 rounded-xl rounded-tl-none max-w-[80%] text-sm shadow-sm break-words">Hi there! How can Converse help you today?</div></div>`; messages.forEach(msg => { createMessage(msg.message, !msg.is_admin); }); scrollToBottom(); } catch (e) { console.error("Error loading history:", e); }
    }
    
    // Search UI (Giữ nguyên)
    const container = document.getElementById('search-container'); const form = document.getElementById('search-form'); const input = document.getElementById('search-input'); const suggestionsBox = document.getElementById('search-suggestions'); let debounceTimer;
    function openSearch() { form.classList.remove('w-16'); form.classList.add('w-[300px]'); input.classList.remove('opacity-0', 'pointer-events-none'); input.classList.add('opacity-100', 'pointer-events-auto'); }
    function closeSearch() { if (document.activeElement !== input) { form.classList.remove('w-[300px]'); form.classList.add('w-16'); input.classList.remove('opacity-100', 'pointer-events-auto'); input.classList.add('opacity-0', 'pointer-events-none'); suggestionsBox.classList.add('hidden'); } }
    if (container) { container.addEventListener('mouseenter', openSearch); container.addEventListener('mouseleave', closeSearch); }
    if (input) { input.addEventListener('focus', openSearch); input.addEventListener('blur', function() { setTimeout(closeSearch, 200); }); input.addEventListener('input', function() { const keyword = this.value.trim(); clearTimeout(debounceTimer); if (keyword.length < 2) { suggestionsBox.classList.add('hidden'); suggestionsBox.innerHTML = ''; return; } debounceTimer = setTimeout(() => { fetchSuggestions(keyword); }, 200); }); }
    function fetchSuggestions(keyword) { fetch(`/search/suggestions?q=${encodeURIComponent(keyword)}`).then(response => response.json()).then(products => { if (products.length > 0) { renderSuggestions(products); suggestionsBox.classList.remove('hidden'); } else { suggestionsBox.innerHTML = '<div class="p-3 text-sm text-gray-500">No results found.</div>'; suggestionsBox.classList.remove('hidden'); } }); }
    function renderSuggestions(products) { const html = products.map(product => { const imagePath = product.image || 'images/placeholder.jpg'; return `<a href="/products/${product.slug || product.id}" class="flex items-center p-3 hover:bg-gray-100 border-b transition-colors"><img src="${BASE_URL}${imagePath}" class="w-10 h-10 object-cover mr-3 border" onerror="this.src='${BASE_URL}images/placeholder.jpg';"><div><div class="text-sm font-bold text-black line-clamp-1">${product.name}</div><div class="text-xs text-red-600 font-semibold">${new Intl.NumberFormat('en-US').format(product.price)} VND</div></div></a>`; }).join(''); suggestionsBox.innerHTML = html; }
});
</script>