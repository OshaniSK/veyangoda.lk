<x-admin-layout title="Contact Submissions">
    
    <div x-data="{ 
        modalOpen: false, 
        contact: { name: '', email: '', subject: '', message: '', date: '', ip: '' },
        openModal(data) {
            this.contact = data;
            this.modalOpen = true;
        }
    }">
        <div class="card overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200">
                            <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Sender</th>
                            <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Subject</th>
                            <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($contacts as $msg)
                            <tr class="hover:bg-slate-50/50">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-slate-800 text-sm">{{ $msg->name }}</div>
                                    <div class="text-xs text-slate-500">{{ $msg->email }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-slate-800 font-medium">{{ Str::limit($msg->subject, 40) }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm text-slate-500">{{ $msg->created_at->format('M d, Y h:i A') }}</span>
                                </td>
                                <td class="px-6 py-4 text-right space-x-2">
                                    
                                    <button type="button" 
                                            @click="openModal({
                                                name: {{ Js::from($msg->name) }},
                                                email: {{ Js::from($msg->email) }},
                                                subject: {{ Js::from($msg->subject) }},
                                                message: {{ Js::from(nl2br(e($msg->message))) }},
                                                date: '{{ $msg->created_at->format('M d, Y h:i A') }}',
                                                ip: '{{ $msg->ip_address }}'
                                            })"
                                            class="text-xs font-bold text-blue-600 bg-blue-50 px-3 py-1.5 rounded hover:bg-blue-100 transition-colors">
                                        View
                                    </button>

                                    <form action="{{ route('admin.contacts.destroy', $msg->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this message?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs font-bold text-rose-600 bg-rose-50 px-3 py-1.5 rounded hover:bg-rose-100 transition-colors">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-slate-500 text-sm">
                                    No contact submissions found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-t border-slate-100">
                {{ $contacts->links() }}
            </div>
        </div>

        <!-- View Modal -->
        <div x-show="modalOpen" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6" x-cloak>
            <div x-show="modalOpen" x-transition.opacity class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="modalOpen = false"></div>
            
            <div x-show="modalOpen" x-transition.scale.origin.bottom class="relative w-full max-w-2xl bg-white rounded-2xl shadow-2xl overflow-hidden z-[101]">
                <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                    <h3 class="text-lg font-bold text-slate-800">Message Details</h3>
                    <button @click="modalOpen = false" class="text-slate-400 hover:text-slate-600 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                
                <div class="p-6 space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wide">From</p>
                            <p class="text-sm font-semibold text-slate-800 mt-1" x-text="contact.name"></p>
                            <a :href="'mailto:' + contact.email" class="text-sm text-blue-600 hover:underline" x-text="contact.email"></a>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wide">Date & IP</p>
                            <p class="text-sm text-slate-800 mt-1" x-text="contact.date"></p>
                            <p class="text-xs text-slate-500 mt-0.5" x-text="'IP: ' + contact.ip"></p>
                        </div>
                    </div>
                    
                    <div class="pt-4 border-t border-slate-100">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wide">Subject</p>
                        <p class="text-base font-bold text-slate-800 mt-1" x-text="contact.subject"></p>
                    </div>
                    
                    <div class="pt-4 border-t border-slate-100">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wide mb-2">Message</p>
                        <div class="p-4 bg-slate-50 rounded-lg text-sm text-slate-700 whitespace-pre-line leading-relaxed" x-html="contact.message"></div>
                    </div>
                </div>
                
                <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end">
                    <button @click="modalOpen = false" class="px-4 py-2 bg-white border border-slate-200 text-slate-700 rounded-lg font-medium hover:bg-slate-50 transition-colors shadow-sm text-sm">
                        Close
                    </button>
                </div>
            </div>
        </div>

    </div>

</x-admin-layout>
