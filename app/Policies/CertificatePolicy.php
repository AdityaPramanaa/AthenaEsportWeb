<?php

namespace App\Policies;

use App\Models\Certificate;
use App\Models\User;

class CertificatePolicy
{
    public function view(User $user, Certificate $certificate)
    {
        return $user->id === $certificate->user_id || $user->isAdmin() || $user->isPengurus();
    }

    public function create(User $user)
    {
        return $user->isAdmin() || $user->isPengurus();
    }

    public function update(User $user, Certificate $certificate)
    {
        return $user->isAdmin() || $user->isPengurus();
    }

    public function delete(User $user, Certificate $certificate)
    {
        return $user->isAdmin() || $user->isPengurus();
    }
} 