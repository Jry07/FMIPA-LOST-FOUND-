@props(['name', 'label' => null, 'type' => 'text', 'value' => '', 'required' => false, 'placeholder' => ''])

<div class="form-group">
    @if ($label)
        <label for="{{ $name }}" class="form-label">
            {{ $label }}
            @if ($required) <span class="text-danger">*</span> @endif
        </label>
    @endif
    <input 
        type="{{ $type }}" 
        id="{{ $name }}" 
        name="{{ $name }}" 
        value="{{ old($name, $value) }}" 
        placeholder="{{ $placeholder }}"
        {{ $required ? 'required' : '' }} 
        {{ $attributes->merge(['class' => 'form-control ' . ($errors->has($name) ? 'is-invalid' : '')]) }}
    >
    @error($name)
        <div class="form-feedback invalid-feedback">{{ $message }}</div>
    @enderror
</div>
