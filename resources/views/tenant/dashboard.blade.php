<x-layouts.tenant>
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
                        <p class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Tenant Name</p>
                        <p class="mt-1 text-2xl font-semibold text-zinc-900 dark:text-zinc-100">
                            {{ $currentTeam->name ?? 'N/A' }}
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
                        <p class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Domain</p>
                        <p class="mt-1 text-lg font-semibold text-zinc-900 dark:text-zinc-100 truncate">
                            {{ $currentTeam->domain ?? 'N/A' }}
                        </p>
                    </div>
                    <div class="rounded-lg bg-green-100 dark:bg-green-900/20 p-3">
                        <svg class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                        </svg>
                    </div>
                </div>
            </x-card>

            <x-card>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Status</p>
                        <p class="mt-1">
                            @if($currentTeam && $currentTeam->is_active)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400">
                                    Active
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400">
                                    Inactive
                                </span>
                            @endif
                        </p>
                    </div>
                    <div class="rounded-lg bg-blue-100 dark:bg-blue-900/20 p-3">
                        <svg class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </x-card>

            <x-card>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Team Members</p>
                        <p class="mt-1 text-2xl font-semibold text-zinc-900 dark:text-zinc-100">
                            {{ $currentTeam ? $currentTeam->users()->count() : 0 }}
                        </p>
                    </div>
                    <div class="rounded-lg bg-purple-100 dark:bg-purple-900/20 p-3">
                        <svg class="h-6 w-6 text-purple-600 dark:text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                </div>
            </x-card>
        </div>

        <!-- Welcome Card -->
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            <x-card>
                <div>
                    <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100 mb-4">Welcome to {{ $currentTeam->name ?? 'Your Tenant' }}</h3>
                    <p class="text-zinc-600 dark:text-zinc-400 mb-4">
                        You are successfully logged in to your tenant dashboard. This is your dedicated workspace.
                    </p>
                    <div class="space-y-2 text-sm text-zinc-600 dark:text-zinc-400">
                        @if($currentTeam)
                            <div class="flex items-center">
                                <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <span>{{ $currentTeam->email ?? 'No email' }}</span>
                            </div>
                            @if($currentTeam->mobile)
                                <div class="flex items-center">
                                    <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    <span>{{ $currentTeam->mobile }}</span>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </x-card>

            <x-card>
                <div>
                    <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100 mb-4">Quick Information</h3>
                    <dl class="space-y-3 text-sm">
                        <div>
                            <dt class="text-zinc-600 dark:text-zinc-400">Account Owner</dt>
                            <dd class="mt-1 text-zinc-900 dark:text-zinc-100 font-medium">{{ auth()->user()->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-zinc-600 dark:text-zinc-400">Your Email</dt>
                            <dd class="mt-1 text-zinc-900 dark:text-zinc-100">{{ auth()->user()->email }}</dd>
                        </div>
                        @if($currentTeam)
                            <div>
                                <dt class="text-zinc-600 dark:text-zinc-400">Tenant Created</dt>
                                <dd class="mt-1 text-zinc-900 dark:text-zinc-100">{{ $currentTeam->created_at->format('M d, Y') }}</dd>
                            </div>
                        @endif
                    </dl>
                </div>
            </x-card>
        </div>
    </div>
</x-layouts.tenant>

