@php
    $name = $field['name'];
    $label = $field['label'] ?? ucfirst($name);
    $required = $field['required'] ?? false;
@endphp
<div>
    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 mb-1">
        {{ $label }} @if($required)<span class="text-red-500">*</span>@endif
    </label>
    <input type="file" name="{{ $name }}" id="{{ $name }}"
           class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error($name) border-red-500 @enderror"
           @if($required) required @endif>
    @error($name)
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
@if(!empty($value))
    <div class="mt-2">
        <p class="text-sm text-gray-600">Current File:</p>
        <a href="{{ Storage::url($value) }}" target="_blank" class="text-blue-500 underline text-sm">View Uploaded File</a>
    </div>
@endif