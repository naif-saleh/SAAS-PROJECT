<x-layouts.superadmin>
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-zinc-900 dark:text-zinc-100">Create Tenant</h1>
                <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">
                    Add a new tenant to the system
                </p>
            </div>
            <flux:button 
                variant="ghost" 
                :href="route('superadmin.tenants.index')"
                wire:navigate
            >
                <svg class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Tenants
            </flux:button>
        </div>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2">
                <x-card>
                    <form method="POST" action="{{ route('superadmin.tenants.store') }}" class="space-y-6">
                        @csrf
                        
                        @if ($errors->any())
                            <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-400 px-4 py-3 rounded-lg">
                                <ul class="list-disc list-inside space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <flux:input
                                name="name"
                                label="Name"
                                type="text"
                                required
                                autofocus
                                :value="old('name')"
                                placeholder="Tenant Name"
                            />

                            <flux:input
                                name="domain"
                                label="Domain"
                                type="text"
                                required
                                :value="old('domain')"
                                placeholder="tenant-name"
                                help="This will be used as subdomain: domain.localhost:8000"
                            />
                        </div>

                        <flux:input
                            name="mobile"
                            label="Mobile"
                            type="text"
                            :value="old('mobile')"
                            placeholder="+1234567890"
                        />

                        <flux:input
                            name="email"
                            label="Email"
                            type="email"
                            required
                            :value="old('email')"
                            placeholder="tenant@example.com"
                            help="This email will be used for tenant login"
                        />

                        <flux:input
                            name="password"
                            label="Password"
                            type="password"
                            required
                            minlength="8"
                            viewable
                            placeholder="Minimum 8 characters"
                        />

                        <div class="flex items-center justify-end space-x-3 pt-4">
                            <flux:button 
                                variant="ghost" 
                                :href="route('superadmin.tenants.index')"
                                wire:navigate
                            >
                                Cancel
                            </flux:button>
                            <flux:button variant="primary" type="submit">
                                Create Tenant
                            </flux:button>
                        </div>
                    </form>
                </x-card>
            </div>

            <div>
                <x-card>
                    <div class="space-y-4">
                        <h3 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">Information</h3>
                        <div class="space-y-3 text-sm text-zinc-600 dark:text-zinc-400">
                            <p>When you create a tenant, the system will:</p>
                            <ul class="list-disc list-inside space-y-1 ml-2">
                                <li>Create a tenant owner account</li>
                                <li>Assign the tenant role</li>
                                <li>Set up the tenant domain</li>
                                <li>Enable tenant login access</li>
                            </ul>
                        </div>
                    </div>
                </x-card>
            </div>
        </div>
    </div>
</x-layouts.superadmin>
