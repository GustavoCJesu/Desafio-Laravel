@props(['name' => ''])

@php
    $initials = collect(explode(' ', (string) $name))->filter()->take(2)->map(fn ($part) => mb_substr($part, 0, 1))->implode('');
@endphp

<div {{ $attributes->merge(['class' => 'avatar uppercase']) }}>{{ $initials }}</div>
