<script src="https://cdn.tailwindcss.com"></script>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $data ? 'Edit' : 'Create' }} {{ ucfirst(request()->segment(1) ?? 'Item') }}
        </h2>
    </x-slot>

    <x-slot name="create">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route($routeBase . '.index') }}"
                class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                Back To List
            </a>
        </h2>
    </x-slot>

    <div class="bg-gray-50 min-h-screen py-5">
        <div class="max-w-2xl mx-auto bg-white p-8 pt-1 rounded-xl shadow-md">

            @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg">
                {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="mb-4 p-4 bg-red-100 text-red-800 rounded-lg">
                {{ session('error') }}
            </div>
            @endif

            <form action="{{ $action }}" method="POST" enctype="multipart/form-data" class="space-y-6" x-data="{}">
                @csrf
                @if(in_array($method, ['PUT', 'PATCH']))
                @method($method)
                @endif

                @foreach ($formFields as $field)
                @php
                // Set options dynamically if available
                if ($field['name'] === 'product_id' && isset($products)) {
                $field['options'] = $products;
                }
                if ($field['name'] === 'user_id' && isset($users)) {
                $field['options'] = $users;
                }
                if ($field['name'] === 'account_id' && isset($accounts)) {
                $field['options'] = $accounts;
                }

                // Safely get type and label with defaults
                $type = $field['type'] ?? 'text';
                $label = $field['label'] ?? ucfirst(str_replace('_', ' ', $field['name']));

                // Determine value with safe checks
                if (old($field['name']) !== null) {
                $value = old($field['name']);
                } elseif ($data && $field['name'] === 'user_id') {
                $value = $data->users?->pluck('id')->first() ?? null;
                } elseif ($data && $field['name'] === 'account_id') {
                $value = $data->accounts?->pluck('id')->first() ?? null;
                } elseif ($data && $field['name'] === 'product_id') {
                $value = $data->products?->pluck('id')->toArray() ?? [];
                } else {
                $value = $data?->getRawOriginal($field['name']) ?? '';
                }
                @endphp

                @if($type === 'file')
                {{-- File input with preview --}}
                <div x-data="{ imagePreview: '{{ $data && $data[$field['name']] ? asset('storage/' . $data[$field['name']]) : '' }}' }" class="mb-4">
                    <label for="{{ $field['name'] }}" class="block text-sm font-medium text-gray-700">
                        {{ $label }}
                        @if($field['required'] ?? false)<span class="text-red-500">*</span>@endif
                    </label>

                    <input
                        type="file"
                        name="{{ $field['name'] }}"
                        id="{{ $field['name'] }}"
                        @change="
                                const file = $event.target.files[0];
                                if (!file) {
                                    imagePreview = '';
                                    return;
                                }
                                const reader = new FileReader();
                                reader.onload = e => imagePreview = e.target.result;
                                reader.readAsDataURL(file);
                            "
                        class="mt-1 block w-full text-sm text-gray-600
                                file:mr-4 file:py-2 file:px-4
                                file:rounded file:border-0
                                file:text-sm file:font-semibold
                                file:bg-blue-50 file:text-blue-700
                                hover:file:bg-blue-100
                            "
                        {{ ($field['required'] ?? false) ? 'required' : '' }}>

                    <div class="mt-2">
                        <template x-if="imagePreview">
                            <img :src="imagePreview" alt="Image Preview" class="w-32 h-32 object-cover rounded-lg border shadow" />
                        </template>
                        <template x-if="!imagePreview">
                            <p class="text-gray-500 text-sm italic">No image selected</p>
                        </template>
                    </div>

                    @error($field['name'])
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                @else
                {{-- Include other input types --}}
                @includeIf('components.formFields.' . $type, [
                'name' => $field['name'],
                'label' => $label,
                'required' => $field['required'] ?? false,
                'placeholder' => $field['placeholder'] ?? '',
                'value' => $value,
                'options' => $field['options'] ?? [],
                'preview' => $data[$field['name']] ?? null,
                'data' => $data ?? null,
                ])
                @endif

                @endforeach

                <div class="text-center">
                    <button type="submit"
                        class="px-6 py-2 rounded-md text-white font-medium
                               {{ $data ? 'bg-yellow-500 hover:bg-yellow-600' : 'bg-blue-600 hover:bg-blue-700' }}">
                        {{ $data ? 'Update' : 'Submit' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>