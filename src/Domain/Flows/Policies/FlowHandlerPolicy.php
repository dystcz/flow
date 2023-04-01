<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Flows\Policies;

use Dystcz\Flow\Domain\Flows\Handlers\FlowHandler;
use Illuminate\Contracts\Auth\Authenticatable;

class FlowHandlerPolicy
{
    /**
     * Determine if the current user can view the given step.
     */
    public function view(Authenticatable $user, FlowHandler $handler): bool
    {
        return $handler->canView($user);
    }

    /**
     * Determine if the current user can edit the given step.
     */
    public function edit(Authenticatable $user, FlowHandler $handler): bool
    {
        return $handler->canEdit($user);
    }

    /**
     * Determine if the current user can update the given step.
     */
    public function handle(Authenticatable $user, FlowHandler $handler): bool
    {
        return $handler->canHandle($user);
    }
}
