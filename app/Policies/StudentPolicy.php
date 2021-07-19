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

        $role = $user->getRole();

        if ($role->name == 'guest_user') {
            return Response::deny('you are not allowed to create student!');
        } else if ($user->student()->first() != null) {
            return Response::deny("Oops! you can't have more than one student account at any time :(");
        } else {
            return Response::allow();
        }
    }

    public function update(User $user, Student $student)
    {
        return $user->hasPermission($student) ? Response::allow() : Response::deny("sorry! You aren't owner of this student!");
    }

    public function delete(User $user, Student $student)
    {
        return $user->hasPermission($student) ? Response::allow() : Response::deny("you don't have permission to delete this!");
    }
}
