@props([
    'label',
    'name',
    'options' => [],
    'selected' => null,
    'placeholder' => '-- Pilih Opsi --',
    'required' => false,
    'helpText' => null,
])

<div class="form-group @error($name) has-error @enderror">
    <label for="{{ $name }}" class="form-label">
        {{ $label }}
        @if($required) <span class="text-danger">*</span> @endif
    </label>
    <select 
        id="{{ $name }}" 
        name="{{ $name }}" 
        {{ $required ? 'required' : '' }}
        {{ $attributes->merge(['class' => 'form-select' . ($errors->has($name) ? ' is-invalid' : '')]) }}
    >
        @if($placeholder)
            <option value="">{{ $placeholder }}</option>
        @endif
        @foreach($options as $val => $optLabel)
            <option value="{{ $val }}" {{ (string) old($name, $selected) === (string) $val ? 'selected' : '' }}>
                {{ $optLabel }}
            </option>
        @endforeach
    </select>
    @if($helpText)
        <small class="form-help">{{ $helpText }}</small>
    @endif
    @error($name)
        <span class="form-error">{{ $message }}</span>
    @enderror
</div>
