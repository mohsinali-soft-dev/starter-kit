@props(['items' => []])

<nav aria-label="breadcrumb" {{ $attributes->class(['panel-card py-3 px-4']) }}>
    <ol class="breadcrumb mb-0">
        @foreach ($items as $item)
            @if (! empty($item['url']) && ! $loop->last)
                <li class="breadcrumb-item"><a href="{{ $item['url'] }}">{{ $item['label'] }}</a></li>
            @else
                <li class="breadcrumb-item {{ $loop->last ? 'active' : '' }}" @if($loop->last) aria-current="page" @endif>
                    {{ $item['label'] }}
                </li>
            @endif
        @endforeach
    </ol>
</nav>
