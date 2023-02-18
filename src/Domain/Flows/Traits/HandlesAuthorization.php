<?php

namespace Dystcz\Flow\Domain\Flows\Traits;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

trait HandlesAuthorization
{
    /**
     * Determine if the given step is authorizable.
     *
     * @return bool
     */
    public static function authorizable()
    {
        return ! is_null(Gate::getPolicyFor(self::class));
    }

    /**
     * Determine if the current user can view the given step or throw an exception.
     *
     * @return void
     *
     * @throws AuthorizationException
     */
    public function authorizeToViewStep(Request $request)
    {
        $this->authorizeTo($request, 'view');
    }

    /**
     * Determine if the current user can view the given resource.
     *
     * @return bool
     */
    public function authorizedToViewStep(Request $request)
    {
        return $this->authorizedTo($request, 'view');
    }

    /**
     * Determine if the current user can edit step or throw an exception.
     *
     *
     * @throws AuthorizationException
     */
    public static function authorizeToEditStep(request $request): void
    {
        throw_unless(static::authorizedToEditStep($request), AuthorizationException::class);
    }

    /**
     * Determine if the current user can edit step.
     */
    public static function authorizedToEditStep(Request $request): bool
    {
        // TODO: Finish

        return true;
    }

    /**
     * Determine if the current user can edit step.
     */
    public static function authorizeToHandleStep(Request $request): bool
    {
        throw_unless(static::authorizedToHandleStep($request), AuthorizationException::class);

        return true;
    }

    /**
     * Determine if the current user can handle step.
     */
    public static function authorizedToHandleStep(Request $request): bool
    {
        // TODO: Finish

        return true;
    }

    /**
     * Determine if the current user has a given ability.
     *
     * @param  string  $ability
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
     * @param  string  $ability
     * @return bool
     */
    public function authorizedTo(Request $request, $ability)
    {
        return static::authorizable() ? Gate::forUser($request->user())->check($ability, $this) : true;
    }
}
