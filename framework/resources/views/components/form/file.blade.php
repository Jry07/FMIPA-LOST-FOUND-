@props(['name', 'label' => null, 'required' => false, 'accept' => 'image/*'])

<div class="form-group">
    @if ($label)
        <label for="{{ $name }}" class="form-label">
            {{ $label }}
            @if ($required) <span class="text-danger">*</span> @endif
        </label>
    @endif
    <input 
        type="file" 
        id="{{ $name }}" 
        name="{{ $name }}" 
        accept="{{ $accept }}"
        {{ $required ? 'required' : '' }} 
        {{ $attributes->merge(['class' => 'form-control-file ' . ($errors->has($name) ? 'is-invalid' : '')]) }}
    >
    @error($name)
        <div class="form-feedback invalid-feedback">{{ $message }}</div>
    @enderror
</div>
