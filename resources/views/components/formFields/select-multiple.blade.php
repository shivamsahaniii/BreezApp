<div>
    <label class="block text-sm font-medium text-gray-700 mb-1" for="{{ $name }}">
        {{ $label }}
        @if ($required)<span class="text-red-500">*</span>@endif
    </label>

    <select name="{{ $name }}[]" id="{{ $name }}"
        multiple
        class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
        {{ $required ? 'required' : '' }}>

        @foreach ($options as $optionValue => $optionLabel)
            <option value="{{ $optionValue }}"
                @if(is_array(old($name, $value)) && in_array($optionValue, old($name, $value))) selected @endif>
                {{ $optionLabel }}
            </option>
        @endforeach
    </select>

    @error($name)
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
