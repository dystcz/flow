<?php

namespace Dystcz\Process\Domain\Processes\Traits;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

trait HandlesAuthorization
{
    /**
     * Determine if the given resource is authorizable.
     *
     * @return bool
     */
    public static function authorizable()
    {
        return !is_null(Gate::getPolicyFor(self::class));
    }

    /**
     * Determine if the current user can view the given process or throw an exception.
     *
     * @param Request $request
     * @return void
     *
     * @throws AuthorizationException
     */
    public function authorizeToViewProcess(Request $request)
    {
        $this->authorizeTo($request, 'view');
    }

    /**
     * Determine if the current user can view the given resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    public function authorizedToViewProcess(Request $request)
    {
        return $this->authorizedTo($request, 'view');
    }

    /**
     * Determine if the current user can edit process.
     *
     * @param Request $request
     * @return bool
     */
    public static function authorizeToHandleProcess(Request $request): bool
    {
        throw_unless(static::authorizedToHandleProcess($request), AuthorizationException::class);

        return true;
    }

    /**
     * Determine if the current user can handle process.
     *
     * @param Request $request
     * @return bool
     */
    public static function authorizedToHandleProcess(Request $request): bool
    {
        // TODO: Finish

        return true;
    }

    /**
     * Determine if the current user can edit process or throw an exception.
     *
     * @param request $request
     * @return void
     *
     * @throws AuthorizationException
     */
    public static function authorizeToEditProcess(request $request): void
    {
        throw_unless(static::authorizedToEditProcess($request), AuthorizationException::class);
    }

    /**
     * Determine if the current user can edit process.
     *
     * @param Request $request
     * @return bool
     */
    public static function authorizedToEditProcess(Request $request): bool
    {
        // TODO: Finish

        return true;
    }

    /**
     * Determine if the current user has a given ability.
     *
     * @param Request $request
     * @param string $ability
     * @return void
     *
     * @throws AuthorizationException
     */
    public function authorizeTo(Request $request, $ability)
    {
        if (static::authorizable()) {
            Gate::forUser($request->user())->authorize($ability, $this);
        }
    }

    /**
     * Determine if the current user can view the given resource.
     *
     * @param Request $request
     * @param string $ability
     * @return bool
     */
    public function authorizedTo(Request $request, $ability)
    {
        return static::authorizable() ? Gate::forUser($request->user())->check($ability, $this) : true;
    }
}
