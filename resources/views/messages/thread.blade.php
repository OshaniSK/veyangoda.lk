<x-layouts.app :title="'Chat with ' . $user->name">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-6 h-[calc(100vh-4rem)] flex flex-col">
        
        {{-- Header --}}
        <div class="card p-4 flex items-center gap-4 shrink-0 z-10 mb-4">
            <a href="{{ route('messages.inbox') }}" class="text-slate-400 hover:text-brand-blue p-2 -ml-2 rounded-full hover:bg-slate-50 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div class="w-10 h-10 rounded-full bg-brand-violet/10 text-brand-violet flex items-center justify-center font-bold">
                {{ $user->initial }}
            </div>
            <div>
                <h2 class="font-bold text-ink-primary">{{ $user->name }}</h2>
                @if($listing)
                    <a href="{{ route('listings.show', $listing->slug) }}" class="text-[11px] text-ink-secondary hover:text-brand-blue font-semibold truncate max-w-xs block">
                        Regarding: {{ $listing->title }}
                    </a>
                @endif
            </div>
        </div>

        {{-- Messages Area --}}
        <div class="flex-1 overflow-y-auto p-4 card mb-4 flex flex-col gap-4" id="messages-container">
            @if($messages->isEmpty())
                <div class="m-auto text-center text-ink-secondary text-sm">
                    No messages yet. Send a message to start the conversation!
                </div>
            @else
                @foreach($messages as $msg)
                    @php
                        $isMe = $msg->sender_id === auth()->id();
                    @endphp
                    <div class="flex w-full {{ $isMe ? 'justify-end' : 'justify-start' }}">
                        <div class="max-w-[75%] rounded-2xl px-4 py-2.5 text-sm {{ $isMe ? 'bg-brand-blue text-white rounded-br-none shadow-brand-sm' : 'bg-slate-100 text-ink-primary rounded-bl-none' }}">
                            <p class="whitespace-pre-wrap">{{ $msg->message }}</p>
                            <div class="text-[9px] mt-1 text-right {{ $isMe ? 'text-white/70' : 'text-slate-400' }}">
                                {{ $msg->created_at->format('g:i A') }}
                                @if($isMe && $msg->read_status)
                                    <span class="ml-1 inline-block text-white">&check;&check;</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        {{-- Message Input --}}
        <form action="{{ route('messages.store') }}" method="POST" class="shrink-0 flex gap-2">
            @csrf
            <input type="hidden" name="receiver_id" value="{{ $user->id }}">
            @if($listing)
                <input type="hidden" name="listing_id" value="{{ $listing->id }}">
            @endif
            
            <input type="text" name="message" required autocomplete="off" placeholder="Type your message..." class="input-brand flex-1 shadow-sm">
            <button type="submit" class="btn-primary !px-4 !py-0 !rounded-xl">
                <svg class="w-5 h-5 rotate-90" fill="currentColor" viewBox="0 0 20 20"><path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"/></svg>
            </button>
        </form>

    </div>

    {{-- Auto-scroll to bottom of chat --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('messages-container');
            if (container) {
                container.scrollTop = container.scrollHeight;
            }
        });
    </script>
</x-layouts.app>
