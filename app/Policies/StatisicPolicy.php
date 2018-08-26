<?php

namespace App\Policies;

use App\Models\RedirectStatistic;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class StatisicPolicy
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

    public function viewLinkStatistic(User $user, RedirectStatistic $redirectStatistic)
    {
        return true; //todo
    }
}
