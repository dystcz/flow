<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Flows\Observers;

use Dystcz\Flow\Domain\Flows\Models\Template;

class TemplateObserver
{
    /**
     * Handle the Template "created" event.
     */
    public function created(Template $template): void
    {
        //
    }

    /**
     * Handle the Template "updated" event.
     */
    public function updated(Template $template): void
    {
        //
    }

    /**
     * Handle the Template "deleted" event.
     */
    public function deleted(Template $template): void
    {
        //
    }

    /**
     * Handle the Template "restored" event.
     */
    public function restored(Template $template): void
    {
        //
    }

    /**
     * Handle the Template "forceDeleted" event.
     */
    public function forceDeleted(Template $template): void
    {
        //
    }
}
