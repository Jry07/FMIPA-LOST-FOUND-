@props([
    'label',
    'name',
    'rows' => 4,
    'value' => null,
    'placeholder' => '',
    'required' => false,
    'helpText' => null,
])

<div class="form-group @error($name) has-error @enderror">
    <label for="{{ $name }}" class="form-label">
        {{ $label }}
        @if($required) <span class="text-danger">*</span> @endif
    </label>
    <textarea 
        id="{{ $name }}" 
        name="{{ $name }}" 
        rows="{{ $rows }}" 
        placeholder="{{ $placeholder }}"
        {{ $required ? 'required' : '' }}
        {{ $attributes->merge(['class' => 'form-textarea' . ($errors->has($name) ? ' is-invalid' : '')]) }}
    >{{ old($name, $value) }}</textarea>
    @if($helpText)
        <small class="form-help">{{ $helpText }}</small>
    @endif
    @error($name)
        <span class="form-error">{{ $message }}</span>
    @enderror
</div>
