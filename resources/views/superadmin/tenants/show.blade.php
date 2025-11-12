<x-layouts.superadmin>
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-zinc-900 dark:text-zinc-100">{{ $tenant->name }}</h1>
                <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">
                    Tenant details and information
                </p>
            </div>
            <div class="flex space-x-3">
                <flux:button 
                    variant="ghost" 
                    :href="route('superadmin.tenants.edit', $tenant)"
                    wire:navigate
                >
                    <svg class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                </flux:button>
                <flux:button 
                    variant="ghost" 
                    :href="route('superadmin.tenants.index')"
                    wire:navigate
                >
                    <svg class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back
                </flux:button>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2 space-y-6">
                <!-- Basic Information -->
                <x-card>
                    <div>
                        <h2 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100 mb-4">Basic Information</h2>
                        <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <dt class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Name</dt>
                                <dd class="mt-1 text-sm text-zinc-900 dark:text-zinc-100">{{ $tenant->name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Domain</dt>
                                <dd class="mt-1 text-sm text-zinc-900 dark:text-zinc-100">
                                    {{ $tenant->domain ?? 'N/A' }}
                                    @if($tenant->domain)
                                        <span class="text-zinc-500 dark:text-zinc-400">({{ $tenant->domain }}.localhost:8000)</span>
                                    @endif
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Email</dt>
                                <dd class="mt-1 text-sm text-zinc-900 dark:text-zinc-100">{{ $tenant->email ?? 'N/A' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Mobile</dt>
                                <dd class="mt-1 text-sm text-zinc-900 dark:text-zinc-100">{{ $tenant->mobile ?? 'N/A' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Status</dt>
                                <dd class="mt-1">
                                    @if($tenant->is_active)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400">
                                            Active
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400">
                                            Inactive
                                        </span>
                                    @endif
                                </dd>
                            </div>
                        </dl>
                    </div>
                </x-card>

                <!-- Owner Information -->
                @if($tenant->owner)
                    <x-card>
                        <div>
                            <h2 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100 mb-4">Owner Information</h2>
                            <div class="flex items-center space-x-4">
                                <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-indigo-100 dark:bg-indigo-900/20">
                                    <span class="text-lg font-semibold text-indigo-600 dark:text-indigo-400">
                                        {{ $tenant->owner->initials() }}
                                    </span>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-zinc-900 dark:text-zinc-100">{{ $tenant->owner->name }}</p>
                                    <p class="text-sm text-zinc-600 dark:text-zinc-400">{{ $tenant->owner->email }}</p>
                                </div>
                            </div>
                        </div>
                    </x-card>
                @endif
            </div>

            <div class="space-y-6">
                <!-- Quick Actions -->
                <x-card>
                    <div class="space-y-3">
                        <h3 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">Quick Actions</h3>
                        <flux:button 
                            variant="primary" 
                            :href="route('superadmin.tenants.edit', $tenant)"
                            class="w-full justify-start"
                            wire:navigate
                        >
                            <svg class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit Tenant
                        </flux:button>
                        <form method="POST" action="{{ route('superadmin.tenants.destroy', $tenant) }}" 
                              onsubmit="return confirm('Are you sure you want to delete this tenant? This action cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <flux:button 
                                variant="danger" 
                                type="submit"
                                class="w-full justify-start"
                            >
                                <svg class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Delete Tenant
                            </flux:button>
                        </form>
                    </div>
                </x-card>

                <!-- Metadata -->
                <x-card>
                    <div class="space-y-3">
                        <h3 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">Metadata</h3>
                        <dl class="space-y-2 text-sm">
                            <div>
                                <dt class="text-zinc-600 dark:text-zinc-400">Created</dt>
                                <dd class="mt-1 text-zinc-900 dark:text-zinc-100">{{ $tenant->created_at->format('M d, Y H:i') }}</dd>
                            </div>
                            <div>
                                <dt class="text-zinc-600 dark:text-zinc-400">Last Updated</dt>
                                <dd class="mt-1 text-zinc-900 dark:text-zinc-100">{{ $tenant->updated_at->format('M d, Y H:i') }}</dd>
                            </div>
                            <div>
                                <dt class="text-zinc-600 dark:text-zinc-400">Tenant ID</dt>
                                <dd class="mt-1 text-zinc-900 dark:text-zinc-100 font-mono text-xs">#{{ $tenant->id }}</dd>
                            </div>
                        </dl>
                    </div>
                </x-card>
            </div>
        </div>
    </div>
</x-layouts.superadmin>
