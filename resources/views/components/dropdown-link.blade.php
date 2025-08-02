@props(['href', 'active' => false])

<a href="{{ $href }}"
    class="block px-8 py-2 text-[15px] rounded transition
        {{ $active ? 'text-blue-700 font-medium bg-blue-50' : 'text-gray-600 hover:bg-blue-50' }}">
    {{ $slot }}
</a>
