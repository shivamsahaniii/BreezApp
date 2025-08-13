<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>
    
    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6" x-data="{}">
        @csrf
        @method('patch')

        {{-- Default Name --}}
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        {{-- Default Email --}}
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}
                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        {{-- 🔥 Insert Dynamic Fields from user_profiles via config --}}
        @foreach ($formFields as $field)
            @php
                $isFile = $field['type'] === 'file';
                $fieldName = $field['name'];
                $fieldLabel = $field['label'] ?? ucfirst($fieldName);
                $required = $field['required'] ?? false;
                $oldValue = old($fieldName, $user->single_profile->{$fieldName} ?? '');
            @endphp

            @if($isFile)
                <div x-data="{
                    imagePreview: '{{ $oldValue ? asset('storage/' . $oldValue) : '' }}'
                }" class="mb-4">
                    <label for="{{ $fieldName }}" class="block text-sm font-medium text-gray-700">
                        {{ $fieldLabel }}
                        @if($required)<span class="text-red-500">*</span>@endif
                    </label>

                    <input 
                        type="file" 
                        name="{{ $fieldName }}" 
                        id="{{ $fieldName }}"
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
                               hover:file:bg-blue-100"
                        {{ $required ? 'required' : '' }}
                    >

                    <div class="mt-2">
                        <template x-if="imagePreview">
                            <img :src="imagePreview" alt="Image Preview" class="w-32 h-32 object-cover rounded-lg border shadow" />
                        </template>
                        <template x-if="!imagePreview">
                            <p class="text-gray-500 text-sm italic">No image selected</p>
                        </template>
                    </div>

                    @error($fieldName)
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            @else
                {{-- For non-file fields, include the component as usual --}}
                @include('components.formFields.' . $field['type'], [
                    'field' => $field,
                    'value' => $oldValue,
                ])
            @endif
        @endforeach

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
