<?php

declare(strict_types=1);

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
     *
     * @throws AuthorizationException
     */
    public static function authorizeToViewStep(Request $request): void
    {
        throw_unless(static::authorizedToViewStep($request), AuthorizationException::class);
    }

    /**
     * Determine if the current user can view the given resource.
     */
    public static function authorizedToViewStep(Request $request): bool
    {
        return self::newHandler()->authorizedTo($request, 'view');
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
        return self::newHandler()->authorizedTo($request, 'edit');
    }

    /**
     * Determine if the current user can edit step.
     */
    public static function authorizeToHandleStep(Request $request): void
    {
        throw_unless(static::authorizedToHandleStep($request), AuthorizationException::class);
    }

    /**
     * Determine if the current user can handle step.
     */
    public static function authorizedToHandleStep(Request $request): bool
    {
        return self::newHandler()->authorizedTo($request, 'handle');
    }

    /**
     * Determine if the current user has a given ability.
     *
     * @param  string  $ability
     *
     * @throws AuthorizationException
     */
    public function authorizeTo(Request $request, $ability): void
    {
        if (static::authorizable()) {
            Gate::forUser($request->user())->authorize($ability, $this);
        }
    }

    /**
     * Determine if the current user can view the given resource.
     *
     * @param  string  $ability
     */
    public function authorizedTo(Request $request, $ability): bool
    {
        return static::authorizable() ? Gate::forUser($request->user())->check($ability, $this) : true;
    }
}
