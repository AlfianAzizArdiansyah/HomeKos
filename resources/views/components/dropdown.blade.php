@props(['title', 'icon', 'open' => false])

<div x-data="{ open: {{ $open ? 'true' : 'false' }} }" class="relative">
    <button @click="open = !open"
        class="w-full flex items-center justify-between px-4 py-2 rounded-lg hover:bg-blue-100 transition text-[16px] font-semibold
            {{ $open ? 'bg-blue-200 text-blue-900' : 'text-gray-700' }}">
        <span class="flex items-center gap-2">
            <i data-lucide="{{ $icon }}" class="w-5 h-5"></i>
            {{ $title }}
        </span>
        <i data-lucide="chevron-right" :class="{ 'rotate-90': open }" class="w-5 h-5 transform transition-transform"></i>
    </button>

    <div x-show="open" x-cloak x-transition class="mt-1 space-y-1">
        {{ $slot }}
    </div>
</div>
