@props([
    'name',
    'label',
    'options' => [],       // ['value' => 'Label Tampilan']
    'required' => false,
    'placeholder' => 'Pilih ' . ($label ?? ''),
])

<div class="form-group">
    <label class="form-label">
        {{ $label }}
        @if($required)
            <span class="required">*</span>
        @endif
    </label>
    <div class="input-wrapper">
        <select
            name="{{ $name }}"
            class="form-select"
            {{ $required ? 'required' : '' }}
        >
            <option value="">{{ $placeholder }}</option>
            @foreach($options as $value => $text)
                <option value="{{ $value }}" {{ old($name) == $value ? 'selected' : '' }}>
                    {{ $text }}
                </option>
            @endforeach
        </select>
        <div class="input-icon">
            {{ $icon ?? '' }}
        </div>
    </div>
    @error($name)
        <small class="error-text">{{ $message }}</small>
    @enderror
</div>