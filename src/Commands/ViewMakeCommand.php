<?php

namespace Hesto\Generators\Commands;

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
        if(!Config::offsetExists('hesto-generators')) {
            $this->error('Publish config file first! Use artisan vendor:publish command.');

            return false;
        }

        parent::fire();

        $this->info('Template created successfully!');

        return true;
    }

    /**
     * Get the desired template.
     *
     * @param $template
     * @return array|string
     */
    public function getTemplate() {
        $templatesPath = __DIR__ . '/../stubs/views/';

        if($this->option('custom')) {
            $templatesPath = $this->option('path');
        }

        return $templatesPath . $this->option('template') . '/';
    }

    /**
     * Get the destination path.
     *
     * @param $file
     * @return string
     */
    public function getPath()
    {
        return '/resources/views/' . $this->option('layout') . '/'. str_slug($this->getNameInput()) . '/';
    }

    public function replaceExtensions()
    {
        return 'php';
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['template', 't', InputOption::VALUE_OPTIONAL, 'The template to generate', Config::get('hesto-generators.default_view_template')],
            ['layout', 'l', InputOption::VALUE_OPTIONAL, 'To which layout generate the template?', Config::get('hesto-generators.default_view_layout')],
            ['custom', 'c', InputOption::VALUE_OPTIONAL, 'Use custom templates instead of given ones', Config::get('hesto-generators.custom_view_templates')],
            ['path', 'p', InputOption::VALUE_OPTIONAL, 'Local path for template stubs', Config::get('hesto-generators.custom_view_templates_path')],
            ['force', 'f', InputOption::VALUE_NONE, 'Force override existing files'],
        ];
    }


}
