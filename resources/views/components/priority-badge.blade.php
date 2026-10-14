@props(['priority'])

@php
$classes = match($priority) {
    'High' => 'bg-rose-50 text-rose-700 border-rose-200 ring-rose-600/20',
    'Medium' => 'bg-amber-50 text-amber-700 border-amber-200 ring-amber-600/20',
    'Low' => 'bg-slate-50 text-slate-600 border-slate-200 ring-slate-600/10',
    default => 'bg-gray-50 text-gray-700 border-gray-200',
};

$icon = match($priority) {
    'High' => 'M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z',
    'Medium' => 'M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z',
    'Low' => 'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
    default => 'M12 6v6m0 0v6m0-6h6m-6 0H6',
};
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center gap-1 px-2 py-0.5 rounded text-xs font-semibold border ring-1 ring-inset {$classes}"]) }}>
    <svg class="w-3 h-3 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icon }}" />
    </svg>
    {{ $priority }}
</span>
