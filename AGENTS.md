# AGENTS.md

Guidance for AI coding agents working in this repository.

## Project overview

`dystcz/flow` is a Laravel package for modelling workflows / business processes / multistep forms as a **Directed Acyclic Graph (DAG)** of steps.

- Package name: `dystcz/flow`
- Root namespace: `Dystcz\Flow\` (PSR-4, `src/`)
- Tests namespace: `Dystcz\Flow\Tests\` (PSR-4, `tests/`)
- Service provider: `Dystcz\Flow\FlowServiceProvider`
- Facade: `Flow` → `Dystcz\Flow\FlowFacade`
- Status: pre-1.0, under heavy refactor — APIs are unstable.

## Tech stack & requirements

- PHP `^8.1` (uses `declare(strict_types=1);` everywhere — keep it)
- Laravel / `illuminate/support` `^9.0|^10.0`
- Key dependencies:
  - `marcovo/laravel-dag-model` — DAG structure for nodes/steps
  - `spatie/laravel-medialibrary` `^10` — media fields
  - `spatie/laravel-schemaless-attributes` `^2.4` — flexible step attributes
- Dev: `pestphp/pest-plugin-laravel`, `orchestra/testbench`, `laravel/pint`, `nunomaduro/collision`

## Repository layout

```
src/
  FlowServiceProvider.php         # registers config, observers, policies, commands, routes
  FlowFacade.php                  # `Flow` facade
  Domain/
    Base/                         # shared base models / controllers / traits
    Fields/                       # Field abstraction (form fields used by handlers)
      Fields/                     # Concrete fields: Text, Boolean, Date, Select, Media, ...
      Contracts/ Traits/ Enums/ Handlers/ Http/Resources/ Data/ Exceptions/
    Flows/
      Blueprints/FlowBlueprint.php       # Defines a Template (steps + edges) for a model
      Handlers/FlowHandler.php           # Per-step logic: fields, validation, events, perms
      Models/                            # Template, Node, NodeEdge, Step, StepEdge, DatabaseNotification
      Actions/                           # InitializeStep, InitializeNextSteps, GetNextNodesForNode, ...
      Builders/ Casts/ Collections/ Contracts/ Data/ Enums/ Exceptions/
      Facades/ Factories/ Http/{Controllers,Requests,Resources}/
      Notifications/ Observers/ Policies/ Scopes/ Traits/
      Commands/                          # `make:flow-handler` + stub
config/flow.php                   # Models, table names, validation strategy, etc.
database/migrations/              # Package migrations (auto-loaded)
routes/routes.php                 # Package routes (auto-loaded)
tests/
  TestCase.php  Pest.php
  Feature/Domain/Flows/{Actions,Blueprints}/
  Support/{Blueprints,Handlers,Models}/  # Test fixtures
```

### Core domain concepts

- **Template** — a saved blueprint instance attached to a model.
- **Node / NodeEdge** — the DAG of step definitions inside a Template.
- **Step / StepEdge** — runtime instances of nodes for a particular model.
- **FlowBlueprint** — abstract class defining `steps()` and the target `$model`; instantiates Templates + Nodes inside a DB transaction.
- **FlowHandler** — abstract class wired to a node; declares `fields()`, validation, authorization, lifecycle hooks (`onCreated`, `onUpdated`, `onFinished`), permissions and work groups via traits.
- **Field** — declarative form field (Text, Boolean, Date, Select, Multiselect, Media, Number, Currency, Textarea, Headline, Info, EmailPreview, MultiText). Supports rules, groups, callbacks, readonly/disabled, components.
- **Actions** are single-purpose invokable classes (`InitializeStep`, `InitializeNextSteps`, etc.).

Models, table names and the validation strategy are all swappable via `config/flow.php`. The service provider rebinds `Step`, `Template`, `Node` to the configured implementations — always resolve via the container or `Config::get('flow.<x>.model')` rather than `new` on the concrete class.

## Commands

```bash
composer install
composer test                 # ./vendor/bin/pest
composer test-coverage        # HTML coverage in coverage/
./vendor/bin/pint             # Format (preset: laravel + declare_strict_types + explicit_string_variable)
```

### Test database

`phpunit.xml.dist` configures **MySQL** at `127.0.0.1:3306`, db `flow_testing`, user `root` (no password). The DB must exist before running tests. Feature tests use `DatabaseMigrations` + `LazilyRefreshDatabase` (see `tests/Pest.php`).

### Artisan (when consumed by a host app)

```bash
php artisan vendor:publish --provider="Dystcz\Flow\FlowServiceProvider" --tag="config"
php artisan vendor:publish --provider="Dystcz\Flow\FlowServiceProvider" --tag="migrations"
php artisan migrate
php artisan make:flow-handler MyHandler   # uses src/Domain/Flows/Commands/stubs/flow-handler.stub
```

## Conventions

- **Always** start PHP files with `<?php` then `declare(strict_types=1);`.
- Pint preset `laravel` with `declare_strict_types` and `explicit_string_variable` — interpolated vars must be `{$var}` form, not `$var` inside strings.
- DDD-ish layout: code lives under `src/Domain/<Context>/<Layer>/`. Mirror this when adding new files.
- Follow existing patterns:
  - One class per Action, named as a verb phrase, often `__invoke`able.
  - Behaviour split into small `Traits/` (`HandlesValidation`, `InteractsWithModel`, ...).
  - Public contracts live in `Contracts/`; concrete enums in `Enums/`; DTOs in `Data/`.
- Don't reference `Step`, `Node`, `Template` concretely in new code paths that users may want to override — go through config/container.
- New fields go in `src/Domain/Fields/Fields/` and should extend `Field` and implement the appropriate `FieldContract`s.
- New blueprints/handlers used by tests belong under `tests/Support/{Blueprints,Handlers}/` (see existing `TestBlueprint`, `TestHandler*`).

## When adding tests

- Use **Pest** (not raw PHPUnit classes). Place feature tests under `tests/Feature/Domain/<Context>/<Subject>/...Test.php`.
- `tests/TestCase.php` only registers `FlowServiceProvider`; add extra providers there if needed.
- Reuse `tests/Support/Models/TestModel.php` as the host model unless the scenario needs another.

## Things to verify before finishing a change

1. `./vendor/bin/pint` is clean.
2. `composer test` passes (requires the MySQL `flow_testing` database).
3. Any new public class has a contract/interface if it's intended to be user-overridable, and the config exposes a swap point if it's a model/handler/blueprint.
4. No direct `new Step/Node/Template` — resolve via config.

## Documentation pointers

- `README.md` — high-level intro (mostly a placeholder until v1).
- `CONTRIBUTING.md` — contribution flow.
- `CHANGELOG.md` — release notes.
- Open issues in the milestone linked from `README.md` track the ongoing slim-down work; check them before large refactors.
