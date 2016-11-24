<?php

namespace Hesto\Generators\Commands;

use Hesto\Core\Commands\TemplateGeneratorCommand;
use Illuminate\Support\Facades\Config;
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


    public function fire()
    {
        parent::fire();

        $this->call('make:route:controller', [
            'name' => $this->getParsedNameInput(),
            '--force' => true
        ]);
    }

    /**
     * Get the destination path.
     *
     * @return string
     */
    public function getPath()
    {
        return '/app/Http/Controllers/'. ucfirst(camel_case($this->getNameInput())) . '.php';
    }

    /**
     * @return string
     */
    public function getTemplatePath()
    {
        if($this->option('custom')) {
            return $this->option('path') . $this->option('template') . '.stub';
        }

        return __DIR__ . '/../stubs/controllers/' . $this->option('template') . '.stub';
    }

    /**
     * Get the desired class name from the input.
     *
     * @return string
     */
    protected function getParsedNameInput()
    {
        return str_replace("controller", "", parent::getParsedNameInput());
    }

    /**
     * Compile content.
     *
     * @param $content
     * @return mixed
     */
    protected function compile($content)
    {
        $content = parent::compile($content);

        if($this->getLayoutInput() != null) {
            $content = str_replace('{{layout}}', $this->getLayoutInput() . '.', $content);
        }

        return $content;
    }

    /**
     * @return mixed
     */
    public function getLayoutInput()
    {
        return $this->option('layout');
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    public function getOptions()
    {
        return [
            ['template', 't', InputOption::VALUE_OPTIONAL, 'The template to generate', Config::get('hesto.generators.default_controller_template')],
            ['layout', 'l', InputOption::VALUE_OPTIONAL, 'To which layout generate the template?', Config::get('hesto.generators.default_layout')],
            ['custom', 'c', InputOption::VALUE_OPTIONAL, 'Use custom templates instead of given ones', Config::get('hesto.generators.custom_controller_templates')],
            ['path', 'p', InputOption::VALUE_OPTIONAL, 'Local path for template stubs', Config::get('hesto.generators.custom_controller_templates_path')],
            ['force', 'f', InputOption::VALUE_NONE, 'Force override existing files'],
        ];
    }
}
