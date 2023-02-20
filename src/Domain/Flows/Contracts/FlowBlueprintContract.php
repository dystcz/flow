<?php

namespace Dystcz\Flow\Domain\Flows\Contracts;

interface FlowBlueprintContract
{
    /**
     * Flow steps.
     */
    public function steps(): array;

    /**
     * Get template name.
     */
    public function getTemplateName(): string;

    /**
     * Get template name.
     */
    public function getModelClass(): string;
}
