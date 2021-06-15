<a {{$attributes->merge(['class' => 'menu-link'])}}>
    {{ $slot }}
    <span class="menu-title">{{ $title }}</span>
</a>
