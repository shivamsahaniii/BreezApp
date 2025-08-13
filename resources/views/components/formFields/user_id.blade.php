<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">
        {{ $label }}
    </label>
    <input type="text" value="{{ auth()->user()->name }}" disabled
           class="w-full border-gray-300 rounded-md bg-gray-100 cursor-not-allowed">
    <input type="hidden" name="{{ $name }}" value="{{ auth()->id() }}">
    
</div>
