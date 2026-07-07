@props(['name', 'label' => null, 'checked' => false])

<div {{ $attributes->class(['form-check mb-3']) }}>
    <input type="hidden" name="{{ $name }}" value="0">
    <input
        type="checkbox"
        name="{{ $name }}"
        id="{{ $name }}"
        value="1"
        @checked(old($name, $checked))
        class="form-check-input"
    >
    @if ($label)
        <label class="form-check-label" for="{{ $name }}">{{ $label }}</label>
    @endif
</div>
