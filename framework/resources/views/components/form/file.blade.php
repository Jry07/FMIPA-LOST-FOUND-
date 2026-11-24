@props([
    'label',
    'name',
    'accept' => 'image/*',
    'required' => false,
    'helpText' => 'Format file: JPG, PNG, atau WebP (Maksimal 2 MB)',
])

<div class="form-group @error($name) has-error @enderror">
    <label for="{{ $name }}" class="form-label">
        {{ $label }}
        @if($required) <span class="text-danger">*</span> @endif
    </label>
    <div class="file-upload-box">
        <input 
            type="file" 
            id="{{ $name }}" 
            name="{{ $name }}" 
            accept="{{ $accept }}"
            {{ $required ? 'required' : '' }}
            {{ $attributes->merge(['class' => 'form-file-input' . ($errors->has($name) ? ' is-invalid' : '')]) }}
        >
        @if($helpText)
            <small class="form-help file-help-text">{{ $helpText }}</small>
        @endif
    </div>
    @error($name)
        <span class="form-error">{{ $message }}</span>
    @enderror
</div>
