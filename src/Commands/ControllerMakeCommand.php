<?php

namespace Hesto\Generators\Commands;

use Hesto\Core\Commands\TemplateGeneratorCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

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

    /**
     * @return string
     */
    public function getTemplatePath()
    {
        return __DIR__ . '/../stubs/' . $this->parseTypeName() . '/' . $this->option('template') . '.stub';
    }

    /**
     * Get the desired class name from the input.
     *
     * @return string
     */
    protected function getParsedNameInput()
    {
        $name = parent::getParsedNameInput();

        $name = str_replace("controller", "", $name);

        return $name;
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    public function getOptions()
    {
        return [
            ['template', 't', InputOption::VALUE_OPTIONAL, 'The template to generate', 'default'],
            ['layout', 'l', InputOption::VALUE_OPTIONAL, 'To which layout generate the template?', 'admin.'],
            ['custom', 'c', InputOption::VALUE_OPTIONAL, 'Use custom templates instead of given ones', false],
            ['path', 'p', InputOption::VALUE_OPTIONAL, 'Local path for template stubs', '/resources/templates/'],
            ['force', 'f', InputOption::VALUE_NONE, 'Force override existing files'],
        ];
    }
}
