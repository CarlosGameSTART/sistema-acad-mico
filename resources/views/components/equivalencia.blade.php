@props(['valor'])

<span {{ $attributes->class(['badge', 'badge-'.strtolower($valor)]) }}>{{ $valor }}</span>
