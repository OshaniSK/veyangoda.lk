<x-app-layout>
    <div class="min-h-[calc(100vh-5rem)] bg-slate-50 px-4 py-8 sm:px-6 lg:px-8 font-sans">
        <div class="mx-auto max-w-7xl">
            <!-- Page Header -->
            <header class="mb-8">
                <h1 class="text-3xl font-bold text-slate-900 sm:text-4xl">Messages</h1>
                <p class="mt-2 text-sm text-slate-600 sm:text-base">Manage your conversations with buyers and sellers.</p>
            </header>

            <!-- Main Container -->
            <div class="grid min-h-[600px] overflow-hidden rounded-2xl bg-white shadow-lg lg:grid-cols-[350px_1fr]">
                
                <!-- Sidebar (Left) -->
                <aside class="border-b border-gray-200 lg:border-b-0 lg:border-r" aria-label="Conversation threads">
                    @if($conversations->isNotEmpty())
                        <nav class="h-full max-h-[500px] lg:max-h-[700px] overflow-y-auto divide-y divide-gray-100">
                            @foreach($conversations as $message)
                                @php
                                    $isIncoming = $message->receiver_id === auth()->id();
                                    $partner = $isIncoming ? $message->sender : $message->receiver;
                                    $isUnread = isset($unreadPartnerIds[$partner->id]);
                                    $isSelected = $selectedPartner?->id === $partner->id;
                                @endphp
                                <a href="{{ route('messages.inbox', ['user' => $partner->id]) }}" class="group block border-l-4 transition-colors p-4 focus:outline-none {{ $isSelected ? 'border-green-600 bg-green-50' : 'border-transparent hover:bg-green-50' }}">
                                    <div class="flex items-start gap-3 relative">
                                        <!-- Avatar -->
                                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-green-100 text-lg font-bold text-dark-green">
                                            {{ strtoupper(substr($partner->name, 0, 1)) }}
                                        </div>
                                        
                                        <div class="min-w-0 flex-1">
                                            <div class="flex justify-between items-baseline mb-1">
                                                <h3 class="truncate text-base font-bold text-slate-900">{{ $partner->name }}</h3>
                                                <span class="text-xs text-gray-500 shrink-0">{{ $message->created_at->diffForHumans(null, true, true) }}</span>
                                            </div>
                                            <p class="truncate text-xs text-gray-500 mb-1">Regarding: {{ $message->listing?->title ?? 'General inquiry' }}</p>
                                            
                                            <div class="flex items-center justify-between">
                                                <p class="truncate text-sm {{ $isUnread ? 'font-bold text-slate-800' : 'text-slate-600' }}">
                                                    @unless($isIncoming)<span class="text-gray-400">You: </span>@endunless
                                                    {{ \Illuminate\Support\Str::limit($message->message, 60) }}
                                                </p>
                                                @if($isUnread)
                                                    <span class="h-3 w-3 shrink-0 rounded-full bg-green-600 ml-2"></span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </nav>
                    @else
                        <!-- Sidebar Empty State -->
                        <div class="flex h-full flex-col items-center justify-center p-6 text-center text-gray-500">
                            <svg class="h-12 w-12 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                            <p class="text-sm">No conversations yet.</p>
                        </div>
                    @endif
                </aside>

                <!-- Main Area (Right) -->
                <section class="flex flex-col bg-white">
                    @if($selectedPartner)
                        <!-- Selected Thread Header -->
                        <div class="flex items-center justify-between border-b border-gray-100 p-4 sm:p-6">
                            <div class="flex items-center gap-3">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-green-100 text-sm font-bold text-dark-green">
                                    {{ strtoupper(substr($selectedPartner->name, 0, 1)) }}
                                </div>
                                <div>
                                    <h2 class="text-lg font-bold text-slate-900">{{ $selectedPartner->name }}</h2>
                                </div>
                            </div>
                            <a href="{{ route('messages.thread', ['user' => $selectedPartner->id]) }}" class="rounded-md bg-accent-yellow px-4 py-2 font-bold text-dark-green transition hover:bg-yellow-500 text-sm shadow-sm">
                                View Full Chat
                            </a>
                        </div>
                        
                        <!-- Messages Preview -->
                        <div class="flex-1 overflow-y-auto p-4 sm:p-6 bg-slate-50/50 flex flex-col gap-4">
                            @foreach($previewMessages as $msg)
                                @php($isSent = $msg->sender_id === auth()->id())
                                <div class="flex w-full {{ $isSent ? 'justify-end' : 'justify-start' }}">
                                    <div class="max-w-[85%] sm:max-w-[70%] rounded-2xl px-4 py-3 {{ $isSent ? 'bg-primary text-white rounded-tr-none' : 'bg-white text-slate-800 shadow-sm border border-gray-100 rounded-tl-none' }}">
                                        <p class="text-sm leading-relaxed whitespace-pre-line break-words">{{ $msg->message }}</p>
                                        <p class="text-[10px] mt-1 text-right {{ $isSent ? 'text-green-100' : 'text-gray-400' }}">{{ $msg->created_at->format('M d, h:i A') }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <!-- Empty State (No Conversation Selected) -->
                        <div class="flex h-full flex-col items-center justify-center p-6 text-center">
                            <svg class="h-24 w-24 text-gray-200 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                            <h2 class="text-xl font-bold text-slate-800 mb-2">Select a conversation to start chatting.</h2>
                            <p class="text-slate-500 max-w-sm">Choose a thread from the sidebar to view your messages and reply to buyers or sellers.</p>
                        </div>
                    @endif
                </section>

            </div>
        </div>
    </div>
</x-app-layout>
