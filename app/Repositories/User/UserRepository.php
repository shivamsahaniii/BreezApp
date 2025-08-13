<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Models\UserProfile;

class UserRepository implements UserRepositoryInterface
{
    public function updateProfile(array $data, $userId): void
    {
        $user = User::findOrFail($userId);

        if (request()->hasFile('profile_image')) {
            $data['profile_image'] = request()->file('profile_image')->store('profiles', 'public');
        }

        $existingProfile = $user->profile->first();

        if ($existingProfile) {
            $existingProfile->update($data);
        } else {
            $profile = UserProfile::create($data);
            $user->profile()->sync([$profile->id]);
        }   
    }
}