@extends('admin.layouts.app')

@section('title', 'Support Chat')
@section('header', 'Customer Support')

@section('content')
<div x-data="adminChat()" x-init="initAdmin()" class="flex h-[calc(100vh-150px)] bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    
    <div class="w-1/3 border-r border-gray-200 bg-gray-50 flex flex-col">
        <div class="p-4 border-b border-gray-200 font-bold text-gray-700">Conversations</div>
        <div class="flex-1 overflow-y-auto">
            <template x-for="user in users" :key="user.id">
                <div @click="selectUser(user)" 
                     class="p-4 border-b border-gray-100 cursor-pointer hover:bg-white transition flex items-center gap-3"
                     :class="selectedUser?.id === user.id ? 'bg-white border-l-4 border-l-black' : ''">
                    
                    <div class="h-10 w-10 rounded-full bg-gray-300 overflow-hidden">
                        <img :src="user.avatar ? '/storage/'+user.avatar : 'https://ui-avatars.com/api/?name='+user.name" class="h-full w-full object-cover">
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="font-bold text-sm truncate" x-text="user.name"></div>
                        <div class="text-xs text-gray-500 truncate" x-text="user.messages && user.messages.length ? user.messages[0].message : 'No messages'"></div>
                    </div>
                </div>
            </template>
        </div>
    </div>

    <div class="w-2/3 flex flex-col">
        <template x-if="selectedUser">
            <div class="flex flex-col h-full">
                <div class="p-4 border-b border-gray-200 bg-white font-bold flex justify-between">
                    <span x-text="selectedUser.name"></span>
                    <span class="text-xs text-gray-500" x-text="selectedUser.email"></span>
                </div>

                <div id="admin-chat-box" class="flex-1 p-4 overflow-y-auto bg-gray-50 space-y-3">
                    <template x-for="msg in messages" :key="msg.id">
                        <div :class="msg.is_admin ? 'text-right' : 'text-left'">
                            <div class="inline-block px-4 py-2 rounded-lg text-sm max-w-[70%]"
                                 :class="msg.is_admin ? 'bg-black text-white' : 'bg-white border border-gray-200 text-gray-800'">
                                <span x-text="msg.message"></span>
                            </div>
                            <div class="text-[10px] text-gray-400 mt-1" x-text="new Date(msg.created_at).toLocaleTimeString()"></div>
                        </div>
                    </template>
                </div>

                <div class="p-4 border-t border-gray-200 bg-white">
                    <form @submit.prevent="replyUser" class="flex gap-2">
                        <input type="text" x-model="replyMessage" placeholder="Type a reply..." class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:ring-black focus:border-black">
                        <button type="submit" class="bg-black text-white px-6 py-2 rounded-lg font-bold hover:bg-gray-800">Send</button>
                    </form>
                </div>
            </div>
        </template>
        <template x-if="!selectedUser">
            <div class="flex items-center justify-center h-full text-gray-400">
                Select a customer to start chatting
            </div>
        </template>
    </div>
</div>

<script>
    function adminChat() {
        return {
            users: [],
            selectedUser: null,
            messages: [],
            replyMessage: '',
            activeChannel: null, 

            initAdmin() {
                this.fetchConversations();
                
                setInterval(() => {
                    this.fetchConversations();
                }, 10000);
            },

            async fetchConversations() {
                try {
                    const res = await fetch('/admin/chat/conversations');
                    const data = await res.json();
                    this.users = data;
                } catch (e) { console.error(e); }
            },

            async selectUser(user) {
                if (this.selectedUser && window.Echo) {
                    window.Echo.leave('chat.' + this.selectedUser.id);
                }

                this.selectedUser = user;
                this.messages = []; 

                try {
                    const res = await fetch('/admin/chat/messages/' + user.id);
                    this.messages = await res.json();
                    this.scrollToBottom();
                } catch (e) { console.error(e); }

                if (window.Echo) {
                    console.log('Admin listening to: chat.' + user.id);
                    
                    window.Echo.private('chat.' + user.id)
                        .listen('MessageSent', (e) => {
                            console.log('Admin received:', e.message);
                            this.messages.push(e.message);
                            this.scrollToBottom();
                        })
                        .error((error) => {
                            console.error('Admin Subscribe Error:', error);
                        });
                }
            },

            async replyUser() {
                if (!this.replyMessage.trim() || !this.selectedUser) return;

                const text = this.replyMessage;
                this.replyMessage = ''; // Xóa input

                try {
                    await fetch('/chat/send', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ 
                            message: text,
                            target_user_id: this.selectedUser.id 
                        })
                    });
                } catch (e) {
                    console.error(e);
                    alert('Failed to send message');
                }
            },

            scrollToBottom() {
                setTimeout(() => {
                    const box = document.getElementById('admin-chat-box');
                    if(box) box.scrollTop = box.scrollHeight;
                }, 100);
            }
        }
    }
</script>
@endsection