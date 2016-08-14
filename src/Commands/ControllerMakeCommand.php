<?php

namespace Hesto\Generators\Commands;

use Hesto\Core\Commands\TemplateGeneratorCommand;

class ControllerMakeCommand extends TemplateGeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:controller:template';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create controller from given template';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Controller';

    /**
     * Get the destination path.
     *
     * @return string
     */
    public function getPath()
    {
        return '/app/Http/Controllers/'. $this->getNameInput() . '.php';
    }
}
