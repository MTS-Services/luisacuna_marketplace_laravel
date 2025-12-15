@props(['disabled' => false, 'type' => 'text', 'prefix' => 'https://'])

@if ($type == 'password')
    <div class="relative w-full" x-data="{
        show: false,
        isRtl: document.documentElement.dir === 'rtl'
    }">
        <input type="password" :type="show ? 'text' : 'password'" {{ $disabled ? 'disabled' : '' }}
            :class="{ 'pe-10': !isRtl, 'ps-10': isRtl }" {!! $attributes->merge([
                'class' =>
                    'w-full shadow-sm px-3 py-2 bg-transparent dark:bg-transparent dark:text-zinc-100! text-zinc-900 rounded-md border border-zinc-300 focus:border-accent focus:ring-accent focus:ring-1 disabled:opacity-50 disabled:cursor-not-allowed transition duration-150 bg-white text-zinc-900 placeholder-zinc-400 focus:outline-none focus:ring-offset-0',
            ]) !!}>

        <span
            class="absolute top-1/2 transform -translate-y-1/2 cursor-pointer text-gray-400 dark:text-gray-500 right-3 rtl:left-3 rtl:right-auto"
            @click="show = !show">
            <flux:icon icon="eye-closed" class="w-5 h-5" x-show="show" />
            <flux:icon icon="eye" class="w-5 h-5" x-show="!show" />
        </span>
    </div>
@elseif ($type == 'url')
    <div class="relative w-full" x-data="{
        isRtl: document.documentElement.dir === 'rtl',
        prefix: '{{ $prefix }}'
    }">
        {{-- Prefix Text (looks like part of input) --}}
        <span
            class="absolute top-1/2 -translate-y-1/2 text-sm text-zinc-400 dark:text-zinc-500 left-3 rtl:right-3 rtl:left-auto pointer-events-none select-none"
            x-text="prefix">
        </span>

        <input type="text" {{ $disabled ? 'disabled' : '' }}
            x-bind:style="{
                'padding-left': !isRtl ? (prefix.length * 7.5 + 12) + 'px' : '12px',
                'padding-right': isRtl ? (prefix.length * 7.5 + 12) + 'px' : '12px'
            }"
            {!! $attributes->merge([
                'class' =>
                    'w-full shadow-sm px-3 py-2 bg-transparent dark:bg-transparent dark:text-zinc-100 text-zinc-900 rounded-md border border-zinc-300 focus:border-accent focus:ring-accent focus:ring-1 disabled:opacity-50 disabled:cursor-not-allowed transition duration-150 bg-white text-zinc-900 placeholder-zinc-400 focus:outline-none focus:ring-offset-0',
            ]) !!}>
    </div>
@else
    <input type="{{ $type }}" {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
        'class' =>
            'w-full shadow-sm px-3 py-2 bg-transparent dark:bg-transparent dark:text-zinc-100 text-zinc-900 rounded-md border border-zinc-300 focus:border-accent focus:ring-accent focus:ring-1 disabled:opacity-50 disabled:cursor-not-allowed transition duration-150 bg-white text-zinc-900 placeholder-zinc-400 focus:outline-none focus:ring-offset-0',
    ]) !!}>
@endif
