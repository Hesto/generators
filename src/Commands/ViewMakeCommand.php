<?php

namespace Hesto\Generators\Commands;

use Hesto\Core\Commands\TemplateGeneratorCommand;
use Illuminate\Support\Facades\Config;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class ViewMakeCommand extends TemplateGeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:view';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create view for CRUD';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'View';

    /**
     * Execute the console command.
     *
     * @return bool|null
     */
    public function fire()
    {
        if(!Config::offsetExists('hesto.generators')) {
            $this->error('Publish config file first! Use artisan vendor:publish command.');

            return false;
        }

        parent::fire();

        $this->info('Template created successfully!');

        return true;
    }

    /**
     * Get the destination path.
     *
     * @return string
     */
    public function getPath()
    {
        return '/resources/views/' . $this->getLayoutInput() . '/'. str_slug(str_plural($this->getNameInput())) . '/';
    }

    /**
     * @return string
     */
    public function getTemplatePath()
    {
        return __DIR__ . '/../stubs/' . $this->parseTypeName() . '/';
    }

    /**
     * @return string
     */
    public function getExtension($file)
    {
        return 'php';
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

        $content = str_replace('{{layout}}', $this->getLayoutInput(), $content);

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
            ['template', 't', InputOption::VALUE_OPTIONAL, 'The template to generate', Config::get('hesto.generators.default_view_template')],
            ['layout', 'l', InputOption::VALUE_OPTIONAL, 'To which layout generate the template?', Config::get('hesto.generators.default_layout')],
            ['custom', 'c', InputOption::VALUE_OPTIONAL, 'Use custom templates instead of given ones', Config::get('hesto.generators.custom_view_templates')],
            ['path', 'p', InputOption::VALUE_OPTIONAL, 'Local path for template stubs', Config::get('hesto.generators.custom_view_templates_path')],
            ['force', 'f', InputOption::VALUE_NONE, 'Force override existing files'],
        ];
    }


}
