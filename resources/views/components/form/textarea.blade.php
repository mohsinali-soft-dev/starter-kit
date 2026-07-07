@props(['name', 'label' => null, 'value' => null, 'rows' => 4, 'required' => false])

<div {{ $attributes->class(['mb-3']) }}>
    @if ($label)
        <label for="{{ $name }}" class="form-label">{{ $label }} @if($required)<span class="text-danger">*</span>@endif</label>
    @endif
    <textarea
        name="{{ $name }}"
        id="{{ $name }}"
        rows="{{ $rows }}"
        {{ $required ? 'required' : '' }}
        {{ $attributes->class(['form-control', $errors->has($name) ? 'is-invalid' : '']) }}
    >{{ old($name, $value) }}</textarea>
    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
