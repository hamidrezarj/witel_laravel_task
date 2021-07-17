<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use app\Models\Student;

class StudentPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function create(User $user)
    {
        # allowed to create iff user hasn't student associated with it.
        return ($user->student == null)? Response::allow(): Response::deny();
    
    }

    public function delete(User $user, Student $student)
    {
        return $user->id === $student->user_id;
    }
}
