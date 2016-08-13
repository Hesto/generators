<?php

namespace Hesto\Generators\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Config;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class ViewMakeCommand extends Command
{
    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

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
     * Create a new controller creator command instance.
     *
     * @param  \Illuminate\Filesystem\Filesystem  $files
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

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

        $stubs = $this->getTemplate($this->option('template'));

        foreach($stubs as $stub) {
            $path = $this->getPath($stub);

            if ($this->alreadyExists($path)) {
                $this->error($path . ' already exists!');

                continue;
            }

            $this->makeDirectory($path);
            $this->files->put($path, $this->compileViewStub($stub));
            $this->info('View has been successfully created from stub: ' . $stub->getRelativePathname());
        }

        $this->info('Template created successfully!');
    }

    /**
     * Get the desired template.
     *
     * @param $template
     * @return array|string
     */
    public function getTemplate($template) {
        $templatesPath = __DIR__ . '/../stubs/views/';

        if($this->option('custom')) {
            $templatesPath = $this->option('path');
        }

        return $this->files->allFiles($templatesPath . $template . '/');
    }

    /**
     * Get the destination path.
     *
     * @param $file
     * @return string
     */
    protected function getPath($file)
    {
        $filename = $this->parseFileName($file->getFileName());

        return base_path() . '/resources/views/' . $this->option('layout') . '/'. str_slug($this->getNameInput()) . '/' . $file->getRelativePath() . '/' . $filename . '.blade.php';
    }

    /**
     * Parse and format the name.
     *
     * @param $filename
     * @return string
     */
    protected function parseFileName($filename)
    {
        $filename = str_replace('.stub','',$filename);
        $filename = str_replace('.blade','',$filename);

        return $filename;
    }

    /**
     * Determine if the class already exists.
     *
     * @param $path
     * @return bool
     */
    protected function alreadyExists($path)
    {
        return $this->files->exists($path);
    }

    /**
     * Get the desired class name from the input.
     *
     * @return string
     */
    protected function getNameInput()
    {
        return trim($this->argument('name'));
    }

    /**
     * Build the directory for the class if necessary.
     *
     * @param  string  $path
     * @return string
     */
    protected function makeDirectory($path)
    {
        if (! $this->files->isDirectory(dirname($path))) {
            $this->files->makeDirectory(dirname($path), 0777, true, true);
        }
    }

    /**
     * Compile the view stub.
     *
     * @param $stubFile
     * @return string
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function compileViewStub($stubFile)
    {
        $stub = $this->files->get($stubFile);
        $this->replaceNames($stub);

        return $stub;
    }

    /**
     * Replace names with pattern
     *
     * @param $stub
     * @return $this
     */
    public function replaceNames(&$stub)
    {
        $name = $this->getNameInput();

        $plural = [
            '{{pluralCamel}}',
            '{{pluralSlug}}',
            '{{pluralSnake}}',
        ];

        $singular = [
            '{{singularCamel}}',
            '{{singularSlug}}',
            '{{singularSnake}}',
        ];

        $replace = [
            camel_case($name),
            str_slug($name),
            snake_case($name),
        ];

        $stub = str_replace($plural, $replace, $stub);
        $stub = str_replace($singular, $replace, $stub);

        return $this;
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the class'],
        ];
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
        ];
    }


}
