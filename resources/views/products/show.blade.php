<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Product Info</h2>
    </x-slot>

    <div class="py-12 min-h-screen bg-gray-100">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6 space-y-8">
                <!-- Back Button -->
                <div class="mb-4 flex justify-between items-center">
                    <a href="{{ route('products.index') }}"
                       class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                        Back To List
                    </a>
                </div>

                <!-- Product Details -->
                <h1 class="text-2xl font-semibold text-gray-800">Product Details</h1>
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-4 text-sm">
                    <div>
                        <dt class="text-gray-500 font-medium">Name</dt>
                        <dd class="text-gray-800">{{ $product->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500 font-medium">Price</dt>
                        <dd class="text-gray-800">₹{{ $product->price }}</dd>
                    </div>
                    <div class="md:col-span-2">
                        <dt class="text-gray-500 font-medium">Description</dt>
                        <dd class="text-gray-800">{{ $product->description ?? '-' }}</dd>
                    </div>
                </dl>

                <!-- Associated Leads Accordion -->
                <div x-data="{ open: false }" class="mt-8">
                    <button
                        @click="open = !open"
                        class="flex items-center px-4 py-2 bg-gray-200 rounded hover:bg-gray-300 focus:outline-none"
                        aria-expanded="false"
                        :aria-expanded="open.toString()">
                        <span class="font-semibold text-lg mr-2">Associated Leads</span>
                        <svg
                            :class="{ 'transform rotate-90': open }"
                            class="w-5 h-5 transition-transform duration-200"
                            fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 18l6-6-6-6" />
                        </svg>
                    </button>

                    <div x-show="open" x-transition class="mt-4">
                        @if($product->leads->count())
                            <div class="overflow-x-auto">
                                <table class="min-w-full border text-sm">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="text-left px-4 py-2">Name</th>
                                            <th class="text-left px-4 py-2">Email</th>
                                            <th class="text-left px-4 py-2">Phone</th>
                                            <th class="text-left px-4 py-2">Source</th>
                                            <th class="text-left px-4 py-2">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($product->leads as $lead)
                                            <tr class="border-t">
                                                <td class="px-4 py-2">{{ $lead->name }}</td>
                                                <td class="px-4 py-2">{{ $lead->email }}</td>
                                                <td class="px-4 py-2">{{ $lead->phone }}</td>
                                                <td class="px-4 py-2">{{ ucfirst($lead->source ?? '-') }}</td>
                                                <td class="px-4 py-2">
                                                    <span class="inline-block px-2 py-1 rounded text-white text-xs
                                                        @switch($lead->status)
                                                            @case('new') bg-blue-500 @break
                                                            @case('contacted') bg-yellow-500 @break
                                                            @case('qualified') bg-green-500 @break
                                                            @case('lost') bg-red-500 @break
                                                            @default bg-gray-500
                                                        @endswitch">
                                                        {{ ucfirst($lead->status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-gray-600 italic">No leads associated with this product.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
