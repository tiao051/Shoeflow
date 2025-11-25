@extends('admin.layouts.app')

@section('title', 'Support Chat')
@section('header', 'Customer Support')

@section('content')
<div class="h-[calc(100vh-130px)] flex bg-white rounded-xl shadow-lg overflow-hidden" x-data="chatApp()">
    
    <!-- LEFT SIDEBAR: CONVERSATION LIST -->
    <div class="w-1/3 border-r border-gray-200 flex flex-col">
        <div class="p-4 border-b border-gray-200 bg-gray-50">
            <h2 class="font-bold text-lg text-gray-800">Conversations</h2>
        </div>

        <div class="flex-1 overflow-y-auto">
            <template x-if="conversations.length === 0">
                <div class="p-4 text-center text-gray-500 text-sm">No conversations yet.</div>
            </template>

            <template x-for="user in conversations" :key="user.id">
                <div @click="selectUser(user)" 
                     class="p-4 flex items-center cursor-pointer hover:bg-gray-50 transition border-b border-gray-100 relative"
                     :class="activeUser && activeUser.id === user.id ? 'bg-blue-50 border-l-4 border-l-black' : ''">
                    
                    <!-- Avatar -->
                    <div class="relative">
                        <img :src="user.avatar ? '/storage/' + user.avatar : 'https://ui-avatars.com/api/?name=' + user.name" 
                             class="w-12 h-12 rounded-full object-cover border border-gray-200">
                        <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-white rounded-full"></span>
                    </div>

                    <!-- User Info & Preview -->
                    <div class="ml-4 flex-1 overflow-hidden">
                        <div class="flex justify-between items-center mb-1">
                            <h3 class="font-bold text-sm truncate" :class="user.unread_count > 0 ? 'text-black' : 'text-gray-700'" x-text="user.name"></h3>
                            <span class="text-[10px] text-gray-400">Now</span>
                        </div>
                        
                        <!-- Preview Message: We strip HTML tags here to keep the sidebar clean -->
                        <p class="text-sm truncate" 
                           :class="user.unread_count > 0 ? 'font-bold text-gray-900' : 'text-gray-500'"
                           x-text="user.messages.length > 0 ? (user.messages[0].is_admin ? 'You: ' : '') + user.messages[0].message.replace(/(<([^>]+)>)/gi, '') : 'No messages'"></p>
                    </div>

                    <!-- Unread Badge -->
                    <template x-if="user.unread_count > 0">
                        <div class="ml-2 bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full shadow-sm" x-text="user.unread_count"></div>
                    </template>
                </div>
            </template>
        </div>
    </div>

    <!-- RIGHT SIDE: CHAT AREA -->
    <div class="w-2/3 flex flex-col bg-white">
        
        <!-- Chat Header -->
        <div class="p-4 border-b border-gray-200 flex justify-between items-center bg-gray-50 h-16">
            <template x-if="activeUser">
                <div class="flex items-center">
                    <img :src="activeUser.avatar ? '/storage/' + activeUser.avatar : 'https://ui-avatars.com/api/?name=' + activeUser.name" class="w-10 h-10 rounded-full mr-3">
                    <div>
                        <h3 class="font-bold text-gray-800" x-text="activeUser.name"></h3>
                        <span class="text-xs text-green-500 flex items-center"><span class="w-2 h-2 bg-green-500 rounded-full mr-1"></span> Active Now</span>
                    </div>
                </div>
            </template>
            <template x-if="!activeUser">
                <div class="text-gray-500 font-medium">Select a conversation to start chatting</div>
            </template>
        </div>

        <!-- Messages Container -->
        <div class="flex-1 p-4 overflow-y-auto bg-white space-y-4" id="messages-container">
            <template x-if="isLoading">
                <div class="flex justify-center mt-10"><span class="text-gray-400">Loading messages...</span></div>
            </template>

            <template x-for="msg in messages" :key="msg.id">
                <div class="flex w-full" :class="msg.is_admin ? 'justify-end' : 'justify-start'">
                    <div class="max-w-[70%] px-4 py-2 rounded-2xl text-sm shadow-sm relative group"
                         :class="msg.is_admin ? 'bg-black text-white rounded-br-none' : 'bg-gray-100 text-gray-800 rounded-bl-none'">
                        
                        <!-- FIXED: Use x-html to render HTML tags like <b> and <br> -->
                        <div x-html="msg.message"></div>
                        
                        <span class="text-[9px] opacity-0 group-hover:opacity-70 transition absolute -bottom-5 block w-max" 
                              :class="msg.is_admin ? 'right-0 text-gray-400' : 'left-0 text-gray-400'">
                            Just now
                        </span>
                    </div>
                </div>
            </template>
        </div>

        <!-- Chat Input -->
        <div class="p-4 border-t border-gray-100" x-show="activeUser">
            <form @submit.prevent="sendMessage" class="flex items-center gap-2">
                <input type="text" x-model="newMessage" placeholder="Type a message..." 
                       class="flex-1 px-4 py-3 bg-gray-100 border-0 rounded-full focus:ring-2 focus:ring-black focus:bg-white transition text-sm">
                <button type="submit" :disabled="!newMessage.trim()" 
                        class="p-3 bg-black text-white rounded-full hover:bg-gray-800 disabled:opacity-50 transition shadow-lg transform active:scale-95">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function chatApp() {
        return {
            conversations: [],
            activeUser: null,
            messages: [],
            newMessage: '',
            isLoading: false,
            adminId: {{ Auth::id() }},

            init() {
                this.fetchConversations();
                this.listenForNewMessages();
            },

            listenForNewMessages() {
                // Listen to channel 'admin.chat'
                window.Echo.private('admin.chat')
                    .listen('.message.sent', (e) => {
                        const msg = e.message;
                        const senderId = msg.user_id;

                        // 1. If message is sent by Admin (possibly from another device/tab)
                        if (msg.is_admin) {
                            if (this.activeUser && this.activeUser.id === senderId) {
                                this.messages.push(msg);
                                this.scrollToBottom();
                            }
                            return; 
                        }

                        // 2. Handle incoming messages from USER
                        const userIndex = this.conversations.findIndex(u => u.id === senderId);

                        if (userIndex === -1) {
                            // CASE A: Brand new user (not in sidebar list)
                            // Create new user object from event data
                            const newUser = {
                                id: msg.user.id,
                                name: msg.user.name,
                                avatar: msg.user.avatar,
                                unread_count: 1, // New message, so unread
                                messages: [msg]  // Latest message
                            };
                            // Add to top of list
                            this.conversations.unshift(newUser);
                            this.playNotificationSound();
                        } else {
                            // CASE B: User already exists in sidebar
                            const user = this.conversations[userIndex];
                            
                            // Update preview message
                            user.messages = [msg];

                            // Move user to top
                            this.conversations.splice(userIndex, 1);
                            this.conversations.unshift(user);

                            // If currently chatting with this user -> Show message immediately
                            if (this.activeUser && this.activeUser.id === senderId) {
                                this.messages.push(msg);
                                this.scrollToBottom();
                                this.markAsRead(senderId); // Mark as read immediately
                            } else {
                                // If not chatting -> Increment unread count
                                user.unread_count++;
                                this.playNotificationSound();
                            }
                        }
                    });
            },

            async fetchConversations() {
                try {
                    const res = await fetch('/admin/chat/conversations');
                    this.conversations = await res.json();
                } catch (e) { console.error(e); }
            },

            async selectUser(user) {
                this.activeUser = user;
                this.isLoading = true;
                
                // Reset unread UI immediately
                const idx = this.conversations.findIndex(u => u.id === user.id);
                if (idx !== -1) this.conversations[idx].unread_count = 0;

                try {
                    const res = await fetch(`/admin/chat/messages/${user.id}`);
                    this.messages = await res.json();
                    this.scrollToBottom();
                    this.markAsRead(user.id);
                } catch (e) { console.error(e); } 
                finally { this.isLoading = false; }
            },

            async sendMessage() {
                if (!this.newMessage.trim()) return;

                const payload = {
                    message: this.newMessage,
                    target_user_id: this.activeUser.id
                };
                
                // 1. OPTIMISTIC UI UPDATE
                // Push message to UI immediately for smooth experience
                this.messages.push({
                    id: Date.now(), // Temp ID
                    message: this.newMessage,
                    is_admin: true,
                    created_at: new Date().toISOString()
                });
                this.scrollToBottom();
                
                // Update sidebar preview
                const idx = this.conversations.findIndex(u => u.id === this.activeUser.id);
                if (idx !== -1) {
                    this.conversations[idx].messages = [{ message: this.newMessage, is_admin: true }];
                    const user = this.conversations.splice(idx, 1)[0];
                    this.conversations.unshift(user);
                }

                const msgToSend = this.newMessage;
                this.newMessage = '';

                try {
                    // 2. SEND TO SERVER
                    await fetch('/admin/chat/send', {
                        method: 'POST',
                        headers: { 
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            
                            // Send Socket ID to exclude current user from broadcast (prevent duplicate Echo events)
                            'X-Socket-ID': window.Echo.socketId() 
                        },
                        body: JSON.stringify(payload)
                    });
                } catch (e) { console.error('Send failed', e); }
            },

            async markAsRead(userId) {
                await fetch('/admin/chat/read', {
                    method: 'POST',
                    headers: { 
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ user_id: userId })
                });
            },

            playNotificationSound() {
                // Optional: Play sound on new message
                // const audio = new Audio('/sounds/notification.mp3');
                // audio.play().catch(e => {}); 
            },

            scrollToBottom() {
                this.$nextTick(() => {
                    const container = document.getElementById('messages-container');
                    if (container) container.scrollTop = container.scrollHeight;
                });
            }
        }
    }
</script>
@endsection