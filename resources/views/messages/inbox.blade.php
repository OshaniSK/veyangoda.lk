<x-layouts.app title="Inbox - Messages">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-2xl font-bold text-ink-primary font-serif">Messages</h1>
            @if($unreadCount > 0)
                <span class="bg-status-warning text-white text-xs font-bold px-2.5 py-1 rounded-full">
                    {{ $unreadCount }} Unread
                </span>
            @endif
        </div>

        <div class="card overflow-hidden">
            @if($conversations->count() > 0)
                <div class="divide-y divide-slate-100">
                    @foreach($conversations as $msg)
                        @php
                            $isIncoming = $msg->receiver_id === auth()->id();
                            $partner = $isIncoming ? $msg->sender : $msg->receiver;
                            $isUnread = $isIncoming && !$msg->read_status;
                        @endphp
                        
                        <a href="{{ route('messages.thread', $partner) }}" class="flex items-start gap-4 p-5 hover:bg-slate-50 transition-colors {{ $isUnread ? 'bg-blue-50/30' : '' }}">
                            
                            {{-- Partner Avatar --}}
                            <div class="w-12 h-12 rounded-full bg-brand-violet/10 text-brand-violet flex items-center justify-center font-bold text-lg shrink-0">
                                {{ $partner->initial }}
                            </div>

                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between mb-1">
                                    <h3 class="font-bold text-sm text-ink-primary truncate {{ $isUnread ? 'text-brand-blue' : '' }}">
                                        {{ $partner->name }}
                                    </h3>
                                    <span class="text-[11px] text-ink-secondary whitespace-nowrap ml-2">
                                        {{ $msg->created_at->shortAbsoluteDiffForHumans() }}
                                    </span>
                                </div>
                                
                                @if($msg->listing)
                                    <p class="text-[11px] font-semibold text-ink-secondary mb-1 truncate">
                                        Regarding: <span class="text-ink-primary">{{ $msg->listing->title }}</span>
                                    </p>
                                @endif
                                
                                <p class="text-sm text-ink-secondary truncate {{ $isUnread ? 'font-semibold text-ink-primary' : '' }}">
                                    @if(!$isIncoming) <span class="text-slate-400">You:</span> @endif
                                    {{ $msg->message }}
                                </p>
                            </div>
                            
                            @if($isUnread)
                                <div class="w-2.5 h-2.5 rounded-full bg-brand-blue mt-2 shrink-0"></div>
                            @endif
                        </a>
                    @endforeach
                </div>
            @else
                <div class="p-12 text-center">
                    <div class="w-16 h-16 mx-auto rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-ink-primary">No messages yet</h3>
                    <p class="text-sm text-ink-secondary mt-1">When buyers contact you, their messages will appear here.</p>
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>
