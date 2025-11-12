<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white antialiased dark:bg-linear-to-b dark:from-neutral-950 dark:to-neutral-900">
        <div class="bg-background flex min-h-svh flex-col items-center justify-center gap-6 p-6 md:p-10">
            <div class="flex w-full max-w-sm flex-col gap-2">
                <a href="{{ route('tenant.login') }}" class="flex flex-col items-center gap-2 font-medium">
                    <span class="flex h-9 w-9 mb-1 items-center justify-center rounded-md">
                        <x-app-logo-icon class="size-9 fill-current text-black dark:text-white" />
                    </span>
                    <span class="sr-only">{{ $tenant->name ?? config('app.name', 'Laravel') }}</span>
                </a>
                <div class="flex flex-col gap-6">
                    <x-auth-header 
                        :title="$tenant->name . ' Login'" 
                        :description="__('Enter your credentials to access your tenant dashboard')" 
                    />

                    <!-- Session Status -->
                    <x-auth-session-status class="text-center" :status="session('status')" />

                    @if ($errors->any())
                        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-400 px-4 py-3 rounded-lg">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li class="text-sm">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('tenant.login.post') }}" class="flex flex-col gap-6">
                        @csrf

                        <!-- Email Address -->
                        <flux:input
                            name="email"
                            :label="__('Email address')"
                            type="email"
                            required
                            autofocus
                            autocomplete="email"
                            placeholder="tenant@example.com"
                            :value="old('email', $tenant->email ?? '')"
                        />

                        <!-- Password -->
                        <flux:input
                            name="password"
                            :label="__('Password')"
                            type="password"
                            required
                            autocomplete="current-password"
                            :placeholder="__('Password')"
                            viewable
                        />

                        <!-- Remember Me -->
                        <flux:checkbox 
                            name="remember" 
                            :label="__('Remember me')" 
                            :checked="old('remember')" 
                        />

                        <div class="flex items-center justify-end">
                            <flux:button 
                                variant="primary" 
                                type="submit" 
                                class="w-full" 
                                data-test="tenant-login-button"
                            >
                                {{ __('Log in') }}
                            </flux:button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @fluxScripts
    </body>
</html>

