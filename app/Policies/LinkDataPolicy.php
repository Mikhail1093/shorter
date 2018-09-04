<?php

namespace App\Policies;

use App\Models\LinkData;
use App\Models\RedirectStatistic;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class LinkDataPolicy
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

    /**
     * Проверить, что ссылка принаддежит пользователю.
     *
     * @param \App\User            $user
     * @param \App\Models\LinkData $linkData
     *
     * @return bool
     */
    public function viewLinkStatistic(User $user, LinkData $linkData): bool
    {
        return Auth::id() ===  $linkData->user_id;
    }
}
