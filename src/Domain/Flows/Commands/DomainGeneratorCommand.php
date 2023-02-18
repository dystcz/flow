<?php

namespace Dystcz\Flow\Domain\Flows\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

abstract class DomainGeneratorCommand extends GeneratorCommand
{
    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        $type = Str::plural($this->type);

        if ($domain = $this->option('domain')) {
            return "{$rootNamespace}\\{$domain}\\{$type}";
        }

        return "{$rootNamespace}\\Shared\\{$type}";
    }

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name)
    {
        return $this->laravel->basePath() . '/src/' . str_replace('\\', '/', $name) . '.php';
    }

    /**
     * Get the root namespace for the class.
     *
     * @return string
     */
    protected function rootNamespace()
    {
        return 'Domain\\';
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['domain', 'd', InputOption::VALUE_REQUIRED, 'Set the domain name'],
        ];
    }
}
