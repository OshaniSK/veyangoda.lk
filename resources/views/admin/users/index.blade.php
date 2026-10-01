<x-admin-layout title="User Management">

    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="px-6 py-4 text-xs font-semibold text-ink-secondary uppercase tracking-wider">User</th>
                        <th class="px-6 py-4 text-xs font-semibold text-ink-secondary uppercase tracking-wider">Role & Status</th>
                        <th class="px-6 py-4 text-xs font-semibold text-ink-secondary uppercase tracking-wider text-center">Listings</th>
                        <th class="px-6 py-4 text-xs font-semibold text-ink-secondary uppercase tracking-wider">Joined</th>
                        <th class="px-6 py-4 text-xs font-semibold text-ink-secondary uppercase tracking-wider text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($users as $user)
                        <tr class="hover:bg-slate-50/50">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-slate-200 text-slate-600 flex items-center justify-center font-bold text-xs shrink-0">
                                        {{ $user->initial }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-ink-primary text-sm">{{ $user->name }}</div>
                                        <div class="text-xs text-slate-500">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col gap-1 items-start">
                                    @if($user->is_admin)
                                        <span class="badge-active bg-violet-100 text-violet-800 border-violet-200">Admin</span>
                                    @else
                                        <span class="badge-active bg-slate-100 text-slate-700 border-slate-200">User</span>
                                    @endif

                                    @if($user->is_banned)
                                        <span class="badge-closed">Banned</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="text-sm font-semibold text-slate-600">{{ $user->listings_count }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-slate-500">{{ $user->created_at->format('M d, Y') }}</span>
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                @if(!$user->is_admin)
                                    @if($user->is_banned)
                                        <form action="{{ route('admin.users.unban', $user) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded">Unban</button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.users.ban', $user) }}" method="POST" class="inline-block" onsubmit="return confirm('Ban this user?');">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-xs font-bold text-amber-600 bg-amber-50 px-2 py-1 rounded">Ban</button>
                                        </form>
                                    @endif

                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete user and ALL their listings? This cannot be undone.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs font-bold text-rose-600 bg-rose-50 px-2 py-1 rounded">Delete</button>
                                    </form>
                                @else
                                    <span class="text-xs text-slate-400">Protected</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100">
            {{ $users->links() }}
        </div>
    </div>

</x-admin-layout>
