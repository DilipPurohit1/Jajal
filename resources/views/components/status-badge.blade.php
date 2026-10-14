@props(['status'])

@php
$classes = match($status) {
    'Draft' => 'bg-slate-100 text-slate-700 border-slate-200',
    'Planning' => 'bg-sky-50 text-sky-700 border-sky-200',
    'In Review' => 'bg-amber-50 text-amber-700 border-amber-200',
    'Approved' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
    'Completed' => 'bg-teal-50 text-teal-700 border-teal-200',
    'Cancelled' => 'bg-rose-50 text-rose-700 border-rose-200',
    default => 'bg-gray-100 text-gray-700 border-gray-200',
};

$dotClasses = match($status) {
    'Draft' => 'bg-slate-400',
    'Planning' => 'bg-sky-500',
    'In Review' => 'bg-amber-500',
    'Approved' => 'bg-emerald-500',
    'Completed' => 'bg-teal-500',
    'Cancelled' => 'bg-rose-500',
    default => 'bg-gray-400',
};
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium border {$classes}"]) }}>
    <span class="w-1.5 h-1.5 rounded-full {{ $dotClasses }}"></span>
    {{ $status }}
</span>
