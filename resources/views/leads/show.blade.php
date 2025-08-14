<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Lead Info</h2>
    </x-slot>

    <div class="py-12 min-h-screen bg-gray-100">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6 space-y-8">

                <div class="mb-4 flex justify-between items-center">
                    <a href="{{ route('leads.index') }}" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                        Back To List
                    </a>
                </div>

                <h1 class="text-2xl font-semibold text-gray-800">Lead Details</h1>

                <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-4 text-sm mt-4">
                    @foreach ($fields as $field)
                        @php
                            $key = $field['name'];
                            if ($key === 'product_id') continue;
                            $label = $field['label'];
                            $type = $field['type'] ?? 'text';
                            $value = $lead->$key ?? null;
                        @endphp

                        @if ($key !== 'action')
                            <div>
                                <dt class="text-gray-500 font-medium">{{ $label }}</dt>
                                <dd class="text-gray-800">
                                    @switch($key)
                                        @case('user_id')
                                            {{ optional($lead->users->first())->name ?? 'N/A' }}
                                        @break

                                        @case('account_id')
                                            {{ optional($lead->accounts->first())->name ?? 'N/A' }}
                                        @break

                                        @default
                                            @switch($type)
                                                @case('boolean')
                                                    {{ $value ? 'Yes' : 'No' }}
                                                @break
                                                @case('file')
                                                    @if ($value)
                                                        <img src="{{ asset('storage/' . $value) }}" class="w-24 h-24 rounded-xl object-cover border shadow" alt="Profile">
                                                    @else
                                                        N/A
                                                    @endif
                                                @break
                                                @case('url')
                                                    <a href="{{ $value }}" target="_blank" class="text-blue-600 hover:underline">{{ $value }}</a>
                                                @break
                                                @default
                                                    {{ $value ?? '-' }}
                                            @endswitch
                                    @endswitch
                                </dd>
                            </div>
                        @endif
                    @endforeach
                </dl>

                <!-- Products Accordion -->
                <div x-data="{ open: false }" class="mt-6">
                    <button @click="open = !open" class="flex items-center px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">
                        <span class="font-semibold text-lg mr-2">Products</span>
                        <svg :class="{'transform rotate-90': open}" class="w-5 h-5 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M9 18l6-6-6-6"></path>
                        </svg>
                    </button>
                    <div x-show="open" x-transition class="mt-4">
                        @if($lead->products->count())
                            <table class="min-w-full bg-white border border-gray-200 rounded-lg overflow-hidden">
                                <thead class="bg-gray-50 border-b border-gray-200">
                                    <tr>
                                        <th class="text-left px-4 py-2">Product Name</th>
                                        <th class="text-left px-4 py-2">Price</th>
                                        <th class="text-left px-4 py-2">Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($lead->products as $product)
                                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                                            <td class="px-4 py-2">{{ $product->name }}</td>
                                            <td class="px-4 py-2">{{ $product->price ?? '-' }}</td>
                                            <td class="px-4 py-2">{{ $product->description ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p class="text-gray-600 italic">No products associated with this lead.</p>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
