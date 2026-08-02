@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'bg-gray-700 text-white border-gray-600 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm']) }}>