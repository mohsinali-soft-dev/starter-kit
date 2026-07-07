@props(['name', 'label' => null, 'type' => 'text', 'value' => null, 'placeholder' => null, 'required' => false])

<div {{ $attributes->class(['mb-3']) }}>
    @if ($label)
        <label for="{{ $name }}" class="form-label">{{ $label }} @if($required)<span class="text-danger">*</span>@endif</label>
    @endif
    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $name }}"
        value="{{ old($name, $value) }}"
        placeholder="{{ $placeholder }}"
        {{ $required ? 'required' : '' }}
        {{ $attributes->class(['form-control', $errors->has($name) ? 'is-invalid' : '']) }}
    >
    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
