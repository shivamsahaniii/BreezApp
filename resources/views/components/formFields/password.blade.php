<div>
    <label for="{{ $field['name'] }}" class="block text-sm font-medium text-gray-700 mb-1">
        {{ $field['label'] }}
        @if (!empty($field['required']))
        <span class="text-red-500">*</span>
        @endif
    </label>

    <input type="password"
        name="{{ $field['name'] }}"
        id="{{ $field['name'] }}"
        placeholder="{{ $field['placeholder'] ?? '' }}"
        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error($field['name']) border-red-500 @enderror"
        @if (!empty($field['required'])) required @endif>

    @error($field['name'])
    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
