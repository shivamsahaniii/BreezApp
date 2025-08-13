@php
    $name = $field['name'];
    $label = $field['label'] ?? ucfirst($name);
    $placeholder = $field['placeholder'] ?? '';
    $required = $field['required'] ?? false;
@endphp
<div>
    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 mb-1">
        {{ $label }} @if($required)<span class="text-red-500">*</span>@endif
    </label>
    <textarea name="{{ $name }}" id="{{ $name }}" rows="4"
              placeholder="{{ $placeholder }}"
              class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error($name) border-red-500 @enderror"
              @if($required) required @endif>{{ $value }}</textarea>
    @error($name)
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
