@props(['disabled' => false])
<input type="text" {{ $attributes->merge(['class'=>'form-control']) }} {{ $disabled ? 'disabled' : '' }}>
