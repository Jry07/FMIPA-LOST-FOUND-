@props(['name', 'label' => null, 'required' => false])

<div class="form-group">
    @if ($label)
        <label for="{{ $name }}" class="form-label">
            {{ $label }}
            @if ($required) <span class="text-danger">*</span> @endif
        </label>
    @endif
    <select 
        id="{{ $name }}" 
        name="{{ $name }}" 
        {{ $required ? 'required' : '' }} 
        {{ $attributes->merge(['class' => 'form-select ' . ($errors->has($name) ? 'is-invalid' : '')]) }}
    >
        {{ $slot }}
    </select>
    @error($name)
        <div class="form-feedback invalid-feedback">{{ $message }}</div>
    @enderror
</div>
