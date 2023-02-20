<?php

namespace Dystcz\Flow\Domain\Flows\Blueprints;

use Dystcz\Flow\Domain\Flows\Contracts\FlowBlueprintContract;
use Dystcz\Flow\Domain\Flows\Models\Node;
use Dystcz\Flow\Domain\Flows\Models\Template;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

abstract class FlowBlueprint implements FlowBlueprintContract
{
    protected string $model = Model::class;

    protected string $templateName = 'Default template';

    /**
     * Flow steps.
     */
    public function steps(): array
    {
        return [];
    }

    /**
     * Get collection of users who can be attached to template nodes.
     */
    public function getUsers(): Collection
    {
        return new Collection;
    }

    /**
     * Create flow template with nodes and their relations.
     *
     * @throws Exception
     * @throws InvalidArgumentException
     */
    public function handle(): void
    {
        $this->checkHealth();

        $template = $this->createTemplate();

        DB::transaction(fn () => $this->createNodes($template));
    }

    /**
     * Create template nodes.
     *
     * @return void
     *
     * @throws InvalidArgumentException
     */
    protected function createNodes(Template $template)
    {
        $users = $this->getUsers();

        foreach ($this->steps() as $handler => $config) {
            $node = Node::create([
                'template_id' => $template->id,
                'handler' => $handler,
                'name' => $handler::name(),
                'key' => $handler::key(),
                'group' => $handler::group(),
            ]);

            // Add Users to flow step nodes
            if ($users->isNotEmpty() && array_key_exists('users', $config) && ! empty($config['users'])) {
                // Find User ids
                $userIds = $users->whereIn('id', $config['users'])->pluck('id');
                $node->users()->sync($userIds->toArray());
            }
        }

        $this->linkNodes($template);
    }

    /**
     * Link node relations.
     *
     *
     * @throws InvalidArgumentException
     */
    protected function linkNodes(Template $template): void
    {
        $nodes = Node::query()
            ->where('template_id', $template->id)
            ->get();

        $nodes->each(function (Node $node) use ($nodes) {
            $handler = $node->handler;

            $config = $this->steps()[$handler];

            if (array_key_exists('next', $config)) {
                $children = $nodes->whereIn('handler', $config['next']);

                $node->children()->sync($children);
            }
        });
    }

    /**
     * Create a template.
     */
    public function createTemplate(): Template
    {
        $template = Template::create([
            'name' => $this->getTemplateName(),
            'model_type' => $this->getModelClass(),
        ]);

        return $template;
    }

    /**
     * Get template name.
     */
    public function getTemplateName(): string
    {
        return $this->templateName;
    }

    /**
     * Get template name.
     */
    public function getModelClass(): string
    {
        return $this->model;
    }

    /**
     * Check flow blueprint health.
     *
     * @throws Exception
     */
    protected function checkHealth(): void
    {
        if (false) {
            throw new Exception('Health check failed');
        }
    }
}
