<x-layouts.superadmin>
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-zinc-900 dark:text-zinc-100">Dashboard</h1>
                <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">
                    Welcome back, {{ auth()->user()->name }}
                </p>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
            <x-card>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Total Tenants</p>
                        <p class="mt-1 text-2xl font-semibold text-zinc-900 dark:text-zinc-100">
                            {{ \App\Models\Team::where('personal_team', false)->count() }}
                        </p>
                    </div>
                    <div class="rounded-lg bg-indigo-100 dark:bg-indigo-900/20 p-3">
                        <svg class="h-6 w-6 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                </div>
            </x-card>

            <x-card>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Active Tenants</p>
                        <p class="mt-1 text-2xl font-semibold text-zinc-900 dark:text-zinc-100">
                            {{ \App\Models\Team::where('personal_team', false)->where('is_active', true)->count() }}
                        </p>
                    </div>
                    <div class="rounded-lg bg-green-100 dark:bg-green-900/20 p-3">
                        <svg class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </x-card>

            <x-card>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Inactive Tenants</p>
                        <p class="mt-1 text-2xl font-semibold text-zinc-900 dark:text-zinc-100">
                            {{ \App\Models\Team::where('personal_team', false)->where('is_active', false)->count() }}
                        </p>
                    </div>
                    <div class="rounded-lg bg-red-100 dark:bg-red-900/20 p-3">
                        <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </x-card>

            <x-card>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Total Users</p>
                        <p class="mt-1 text-2xl font-semibold text-zinc-900 dark:text-zinc-100">
                            {{ \App\Models\User::count() }}
                        </p>
                    </div>
                    <div class="rounded-lg bg-blue-100 dark:bg-blue-900/20 p-3">
                        <svg class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                </div>
            </x-card>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            <x-card>
                <div>
                    <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100 mb-4">Quick Actions</h3>
                    <div class="space-y-3">
                        <flux:button 
                            variant="primary" 
                            :href="route('superadmin.tenants.create')" 
                            class="w-full justify-start"
                            wire:navigate
                        >
                            <svg class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Create New Tenant
                        </flux:button>
                        <flux:button 
                            variant="outline" 
                            :href="route('superadmin.tenants.index')" 
                            class="w-full justify-start"
                            wire:navigate
                        >
                            <svg class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                            View All Tenants
                        </flux:button>
                    </div>
                </div>
            </x-card>

            <x-card>
                <div>
                    <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100 mb-4">Recent Tenants</h3>
                    <div class="space-y-3">
                        @php
                            $recentTenants = \App\Models\Team::where('personal_team', false)
                                ->with('owner')
                                ->latest()
                                ->take(5)
                                ->get();
                        @endphp
                        @forelse($recentTenants as $tenant)
                            <div class="flex items-center justify-between p-3 rounded-lg bg-zinc-50 dark:bg-zinc-800/50">
                                <div class="flex items-center space-x-3">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-100 dark:bg-indigo-900/20">
                                        <span class="text-sm font-semibold text-indigo-600 dark:text-indigo-400">
                                            {{ strtoupper(substr($tenant->name, 0, 1)) }}
                                        </span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-zinc-900 dark:text-zinc-100">{{ $tenant->name }}</p>
                                        <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ $tenant->domain ?? 'No domain' }}</p>
                                    </div>
                                </div>
                                <a href="{{ route('superadmin.tenants.show', $tenant) }}" 
                                   class="text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300">
                                    View
                                </a>
                            </div>
                        @empty
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">No tenants yet</p>
                        @endforelse
                    </div>
                </div>
            </x-card>
        </div>
    </div>
</x-layouts.superadmin>

