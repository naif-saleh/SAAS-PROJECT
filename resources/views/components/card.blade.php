@props(['class' => '', 'padding' => true])

<div {{ $attributes->merge(['class' => 'rounded-xl border bg-white dark:bg-zinc-900 dark:border-zinc-800 shadow-sm ' . ($padding ? 'p-6' : '') . ' ' . $class]) }}>
    {{ $slot }}
</div>

