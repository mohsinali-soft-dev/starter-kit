@props(['title', 'subtitle' => null])

<div {{ $attributes->class(['panel-card mb-4 d-flex flex-column flex-lg-row align-items-start align-items-lg-center justify-content-between gap-3']) }}>
    <div>
        <h1 class="h3 mb-1 admin-page-title">{{ $title }}</h1>

        @if ($subtitle)
            <p class="text-secondary mb-0">{{ $subtitle }}</p>
        @endif
    </div>

    @if ($slot->isNotEmpty())
        <div class="d-flex flex-wrap gap-2">
            {{ $slot }}
        </div>
    @endif
</div>
