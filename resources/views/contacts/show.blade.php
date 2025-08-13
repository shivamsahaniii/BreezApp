<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Contact Info</h2>
    </x-slot>

    <div class="py-12 min-h-screen bg-gray-100">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6 space-y-8">
                <div class="mb-4 flex justify-between items-center">
                    <a href="{{ route('contacts.index') }}" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                        Back To List
                    </a>
                </div>
                <h1 class="text-2xl font-semibold text-gray-800">Contact Details</h1>

                <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-4 text-sm">
                    @foreach ($fields as $field)
                    @php
                    $key = $field['name'];
                    $label = $field['label'];
                    $type = $field['type'] ?? 'text';
                    $value = $contact->$key ?? null;
                    @endphp

                    @if ( $field['name'] !== 'action')
                    <div>
                        <dt class="text-gray-500 font-medium">{{ $label }}</dt>
                        <dd class="text-gray-800">
                            @switch($key)
                            @case('user_id')
                                    {{$contact->users->pluck('name')->join(', ')}}
                            @break

                            @case('account_id')
                            {{ $contact->accounts->pluck('name')->join(', ') }} 

                            @break

                            @default
                            @switch($type)
                            @case('boolean')
                            {{ $value ? 'Yes' : 'No' }}
                            @break

                            @case('file')
                            @if ($value)
                            <img src="{{ asset('storage/' . $value) }}"
                                class="w-24 h-24 rounded-xl object-cover border shadow" alt="Profile">
                            @else
                            N/A
                            @endif
                            @break

                            @case('url')
                            <a href="{{ $value }}" target="_blank" class="text-blue-600 hover:underline">
                                {{ $value }}
                            </a>
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

                <!-- Account FAQ/Accordion Section -->
                <div x-data="{ open: false }" class="mt-8">
                    <button
                        @click="open = !open"
                        class="flex items-center px-4 py-2 bg-gray-200 rounded hover:bg-gray-300 focus:outline-none"
                        aria-expanded="false"
                        :aria-expanded="open.toString()">
                        <span class="font-semibold text-lg mr-2">Account Details</span>
                        <svg
                            :class="{'transform rotate-90': open}"
                            class="w-5 h-5 transition-transform duration-200"
                            fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 18l6-6-6-6"></path>
                        </svg>
                    </button>

                    <div x-show="open" x-transition class="mt-4">
                        @if($contact->accounts && $contact->accounts->count() > 0)
                        <ul class="space-y-2 text-sm">
                            @foreach($contact->accounts as $account)
                            <li><strong>Name:</strong> {{ $account->name }}</li>
                            <li><strong>Email:</strong> {{ $account->email ?? '-' }}</li>
                            <li><strong>Phone:</strong> {{ $account->phone ?? '-' }}</li>
                            <li><strong>Website:</strong>
                                @if($account->website)
                                <a href="{{ $account->website }}" target="_blank" class="text-blue-600 hover:underline">
                                    {{ $account->website }}
                                </a>
                                @else
                                -
                                @endif
                            </li>
                            <hr class="my-2 border-gray-300">
                            @endforeach
                        </ul>
                        @else
                        <p class="text-gray-600 italic">No account linked to this contact.</p>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>