@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 bg-blue-100 text-gray-800 focus:border-indigo-300 focus:ring-indigo-300  rounded-md shadow-sm']) !!}>