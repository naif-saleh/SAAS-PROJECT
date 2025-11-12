<x-layouts.superadmin>
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-zinc-900 dark:text-zinc-100">Edit Tenant</h1>
                <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">
                    Update tenant information
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
                    <form method="POST" action="{{ route('superadmin.tenants.update', $tenant) }}" class="space-y-6">
                        @csrf
                        @method('PUT')
                        
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
                                :value="old('name', $tenant->name)"
                                placeholder="Tenant Name"
                            />

                            <flux:input
                                name="domain"
                                label="Domain"
                                type="text"
                                required
                                :value="old('domain', $tenant->domain)"
                                placeholder="tenant-name"
                            />
                        </div>

                        <flux:input
                            name="mobile"
                            label="Mobile"
                            type="text"
                            :value="old('mobile', $tenant->mobile)"
                            placeholder="+1234567890"
                        />

                        <flux:input
                            name="email"
                            label="Email"
                            type="email"
                            required
                            :value="old('email', $tenant->email)"
                            placeholder="tenant@example.com"
                        />

                        <flux:input
                            name="password"
                            label="Password"
                            type="password"
                            minlength="8"
                            viewable
                            placeholder="Leave blank to keep current password"
                            help="Leave blank to keep the current password"
                        />

                        <flux:checkbox
                            name="is_active"
                            label="Active"
                            :checked="old('is_active', $tenant->is_active)"
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
                                Update Tenant
                            </flux:button>
                        </div>
                    </form>
                </x-card>
            </div>

            <div>
                <x-card>
                    <div class="space-y-4">
                        <h3 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">Tenant Details</h3>
                        <dl class="space-y-3 text-sm">
                            <div>
                                <dt class="text-zinc-600 dark:text-zinc-400">Created</dt>
                                <dd class="mt-1 text-zinc-900 dark:text-zinc-100">{{ $tenant->created_at->format('M d, Y') }}</dd>
                            </div>
                            <div>
                                <dt class="text-zinc-600 dark:text-zinc-400">Last Updated</dt>
                                <dd class="mt-1 text-zinc-900 dark:text-zinc-100">{{ $tenant->updated_at->format('M d, Y') }}</dd>
                            </div>
                            <div>
                                <dt class="text-zinc-600 dark:text-zinc-400">Status</dt>
                                <dd class="mt-1">
                                    @if($tenant->is_active)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400">
                                            Active
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400">
                                            Inactive
                                        </span>
                                    @endif
                                </dd>
                            </div>
                        </dl>
                    </div>
                </x-card>
            </div>
        </div>
    </div>
</x-layouts.superadmin>
