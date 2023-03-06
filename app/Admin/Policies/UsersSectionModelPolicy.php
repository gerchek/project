<?php

namespace App\Admin\Policies;

use App\Admin\Sections\Users;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UsersSectionModelPolicy
{

    use HandlesAuthorization;

    /**
     * @param User $user
     * @param string $ability
     * @param Users $section
     * @param User $item
     *
     * @return bool
     */
    public function before(User $user, $ability, Users $section, User $item = null)
    {
        if ($user->isSuperAdmin()) {
            if ($ability != 'display' && $ability != 'create' && !is_null($item) && $item->id <= 1) {
                return false;
            }

            return true;
        }
    }

    /**
     * @param User $user
     * @param Users $section
     * @param User $item
     *
     * @return bool
     */
    public function display(User $user, Users $section, User $item)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

    /**
     * @param User $user
     * @param Users $section
     * @param User $item
     *
     * @return bool
     */
    public function create(User $user, Users $section, User $item)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }
    }

    /**
     * @param User $user
     * @param Users $section
     * @param User $item
     *
     * @return bool
     */
    public function edit(User $user, Users $section, User $item)
    {
        if ($user->isSuperAdmin()) {
            return $item->id > 1;
        }
    }

    /**
     * @param User $user
     * @param Users $section
     * @param User $item
     *
     * @return bool
     */
    public function delete(User $user, Users $section, User $item)
    {
        if ($user->isSuperAdmin()) {
            return $item->id > 1;
        }
    }
}
