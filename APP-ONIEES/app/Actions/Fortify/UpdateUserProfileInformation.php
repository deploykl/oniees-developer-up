<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    public function update(User $user, array $input): void
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'lastname' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'cargo' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'photo' => ['nullable', 'mimes:jpg,jpeg,png,gif,webp', 'max:2048'],
        ])->validateWithBag('updateProfileInformation');

        // Guardar la foto usando el método de Jetstream
        if (isset($input['photo'])) {
            $user->updateProfilePhoto($input['photo']);
        }

        if ($input['email'] !== $user->email && $user instanceof MustVerifyEmail) {
            $user->forceFill([
                'name' => $input['name'],
                'lastname' => $input['lastname'] ?? $user->lastname,
                'phone' => $input['phone'] ?? $user->phone,
                'cargo' => $input['cargo'] ?? $user->cargo,
                'email' => $input['email'],
                'email_verified_at' => null,
            ])->save();
            $user->sendEmailVerificationNotification();
        } else {
            $user->forceFill([
                'name' => $input['name'],
                'lastname' => $input['lastname'] ?? $user->lastname,
                'phone' => $input['phone'] ?? $user->phone,
                'cargo' => $input['cargo'] ?? $user->cargo,
                'email' => $input['email'],
            ])->save();
        }
    }
}