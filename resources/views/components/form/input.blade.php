@props(['name', 'label', 'type' => 'text', 'value' => '', 'required' => false, 'autofocus' => false])

<div class="mb-3">
    <label for="{{ $name }}" class="form-label small text-muted">{{ $label }}</label>
    <input type="{{ $type }}" class="form-control rounded-3 @error($name) is-invalid @enderror"
        name="{{ $name }}" id="{{ $name }}" value="{{ old($name, $value) }}"
        @if ($required) required @endif @if ($autofocus) autofocus @endif>
    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
