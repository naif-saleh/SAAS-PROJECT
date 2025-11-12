@if(isset($userTeams) && $userTeams->count() > 1)
    <flux:menu.separator />
    
    <flux:menu.radio.group>
        <div class="px-1 py-1.5">
            <div class="text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-1 px-1">
                {{ __('Switch Team') }}
            </div>
            @foreach($userTeams as $team)
                <form method="POST" action="{{ route('teams.switch', $team) }}" class="w-full">
                    @csrf
                    <flux:menu.item 
                        as="button" 
                        type="submit" 
                        class="w-full text-start {{ $currentTeam && $currentTeam->id === $team->id ? 'bg-zinc-100 dark:bg-zinc-800' : '' }}"
                    >
                        <div class="flex items-center gap-2">
                            <span class="flex h-6 w-6 items-center justify-center rounded bg-zinc-200 text-xs font-semibold text-black dark:bg-zinc-700 dark:text-white">
                                {{ strtoupper(substr($team->name, 0, 1)) }}
                            </span>
                            <span class="truncate">{{ $team->name }}</span>
                            @if($currentTeam && $currentTeam->id === $team->id)
                                <svg class="ms-auto h-4 w-4 text-zinc-600 dark:text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            @endif
                        </div>
                    </flux:menu.item>
                </form>
            @endforeach
        </div>
    </flux:menu.radio.group>
@elseif(isset($currentTeam))
    <flux:menu.separator />
    
    <flux:menu.radio.group>
        <div class="px-1 py-1.5">
            <div class="text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-1 px-1">
                {{ __('Current Team') }}
            </div>
            <div class="flex items-center gap-2 px-1 py-1.5">
                <span class="flex h-6 w-6 items-center justify-center rounded bg-zinc-200 text-xs font-semibold text-black dark:bg-zinc-700 dark:text-white">
                    {{ strtoupper(substr($currentTeam->name, 0, 1)) }}
                </span>
                <span class="truncate text-sm">{{ $currentTeam->name }}</span>
            </div>
        </div>
    </flux:menu.radio.group>
@endif

