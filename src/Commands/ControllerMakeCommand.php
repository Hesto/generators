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


    public function fire()
    {
        parent::fire();

        $this->installRoute();
    }

    /**
     * Install Routes.
     *
     * @return bool
     */
    public function installRoute()
    {
        $path = base_path() . '/routes/' . $this->getLayoutInput() . '.php';
        $stub = __DIR__ . '/../stubs/routes/controller-routes.stub';

        if( ! $this->contentExists($path, $stub)) {
            $file = new SplFileInfo($stub);
            $this->appendFile($path, $file);

            return true;
        }

        return false;

    }

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
            ['template', 't', InputOption::VALUE_OPTIONAL, 'The template to generate', 'default'],
            ['layout', 'l', InputOption::VALUE_OPTIONAL, 'To which layout generate the template?', 'admin.'],
            ['custom', 'c', InputOption::VALUE_OPTIONAL, 'Use custom templates instead of given ones', false],
            ['path', 'p', InputOption::VALUE_OPTIONAL, 'Local path for template stubs', '/resources/templates/'],
            ['force', 'f', InputOption::VALUE_NONE, 'Force override existing files'],
        ];
    }
}
