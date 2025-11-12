<x-layouts.superadmin>
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-zinc-900 dark:text-zinc-100">Tenants</h1>
                <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">
                    Manage all tenants in the system
                </p>
            </div>
            <flux:button 
                variant="primary" 
                :href="route('superadmin.tenants.create')" 
                wire:navigate
            >
                <svg class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Create Tenant
            </flux:button>
        </div>

        @if(session('success'))
            <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-400 px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <!-- Tenants Grid -->
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2 xl:grid-cols-3">
            @forelse($tenants as $tenant)
                <x-card class="hover:shadow-lg transition-shadow">
                    <div>
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center space-x-3">
                                <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-indigo-100 dark:bg-indigo-900/20">
                                    <span class="text-lg font-semibold text-indigo-600 dark:text-indigo-400">
                                        {{ strtoupper(substr($tenant->name, 0, 1)) }}
                                    </span>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">
                                        {{ $tenant->name }}
                                    </h3>
                                    @if(!$tenant->is_active)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400 mt-1">
                                            Inactive
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400 mt-1">
                                            Active
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2 mb-4">
                            <div class="flex items-center text-sm text-zinc-600 dark:text-zinc-400">
                                <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                </svg>
                                <span class="truncate">{{ $tenant->domain ?? 'No domain' }}</span>
                            </div>
                            <div class="flex items-center text-sm text-zinc-600 dark:text-zinc-400">
                                <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <span class="truncate">{{ $tenant->email ?? 'No email' }}</span>
                            </div>
                            @if($tenant->mobile)
                                <div class="flex items-center text-sm text-zinc-600 dark:text-zinc-400">
                                    <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    <span>{{ $tenant->mobile }}</span>
                                </div>
                            @endif
                        </div>

                        <div class="flex items-center justify-between pt-4 border-t border-zinc-200 dark:border-zinc-700">
                            <div class="flex space-x-2">
                                <flux:button 
                                    variant="ghost" 
                                    size="sm"
                                    :href="route('superadmin.tenants.show', $tenant)"
                                    wire:navigate
                                >
                                    View
                                </flux:button>
                                <flux:button 
                                    variant="ghost" 
                                    size="sm"
                                    :href="route('superadmin.tenants.edit', $tenant)"
                                    wire:navigate
                                >
                                    Edit
                                </flux:button>
                            </div>
                            <form method="POST" action="{{ route('superadmin.tenants.destroy', $tenant) }}" 
                                  onsubmit="return confirm('Are you sure you want to delete this tenant?');">
                                @csrf
                                @method('DELETE')
                                <flux:button 
                                    variant="ghost" 
                                    size="sm"
                                    type="submit"
                                    class="text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300"
                                >
                                    Delete
                                </flux:button>
                            </form>
                        </div>
                    </div>
                </x-card>
            @empty
                <div class="col-span-full">
                    <x-card>
                        <div class="p-12 text-center">
                            <svg class="mx-auto h-12 w-12 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-zinc-900 dark:text-zinc-100">No tenants</h3>
                            <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Get started by creating a new tenant.</p>
                            <div class="mt-6">
                                <flux:button 
                                    variant="primary" 
                                    :href="route('superadmin.tenants.create')"
                                    wire:navigate
                                >
                                    Create Tenant
                                </flux:button>
                            </div>
                        </div>
                    </x-card>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($tenants->hasPages())
            <div class="flex justify-center">
                {{ $tenants->links() }}
            </div>
        @endif
    </div>
</x-layouts.superadmin>

