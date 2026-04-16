@props(['active', 'icon'])

@php
$classes = ($active ?? false)
            ? 'bg-slate-800 text-white group flex items-center px-4 py-3 text-sm font-medium rounded-lg'
            : 'text-slate-400 hover:bg-slate-800 hover:text-white group flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    <i class="fa-solid {{ $icon }} mr-3 flex-shrink-0 text-lg {{ ($active ?? false) ? 'text-indigo-400' : 'text-slate-500 group-hover:text-slate-300' }}"></i>
    {{ $slot }}
</a>
