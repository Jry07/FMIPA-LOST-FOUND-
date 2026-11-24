@props(['name', 'label' => null, 'value' => '', 'required' => false, 'rows' => 4, 'placeholder' => ''])

<div class="form-group">
    @if ($label)
        <label for="{{ $name }}" class="form-label">
            {{ $label }}
            @if ($required) <span class="text-danger">*</span> @endif
        </label>
    @endif
    <textarea 
        id="{{ $name }}" 
        name="{{ $name }}" 
        rows="{{ $rows }}" 
        placeholder="{{ $placeholder }}"
        {{ $required ? 'required' : '' }} 
        {{ $attributes->merge(['class' => 'form-control ' . ($errors->has($name) ? 'is-invalid' : '')]) }}
    >{{ old($name, $value) }}</textarea>
    @error($name)
        <div class="form-feedback invalid-feedback">{{ $message }}</div>
    @enderror
</div>
