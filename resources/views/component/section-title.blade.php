@props(['title'])

<div {{ $attributes->merge(['class' => 'text-xl font-semibold mb-4']) }}>
    {{ $title }}
</div>
