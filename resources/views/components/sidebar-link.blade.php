@props(['href', 'icon', 'active' => false, 'target' => null])

<a href="{{ $href }}" @if($target) target="{{ $target }}" @endif
    class="flex items-center gap-2 px-4 py-2 rounded-lg transition text-[16px] font-semibold
        {{ $active ? 'bg-blue-200 text-blue-900' : 'text-gray-700 hover:bg-blue-100' }}">
    <i data-lucide="{{ $icon }}" class="w-5 h-5"></i>
    {{ $slot }}
</a>
