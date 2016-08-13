<?php

namespace Hesto\Generators\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

abstract class TemplateGeneratorCommand extends Command
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
    protected $name;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description;

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type;

    /**
     * Get the destination path.
     *
     * @return string
     */
    abstract function getPath();

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
        $path = $this->getPath();

        if ($this->alreadyExists($path)) {
            $this->error($path . $this->getNameInput() .' already exists!');

            return false;
        }

        $this->makeDirectory($path);

        $template = $this->getTemplate($this->getTemplateInput());

        $this->files->put($path, $this->compileStub($template));

        $this->info($this->type . ' template created successfully!');
    }

    /**
     * Get the desired template.
     * 
     * @param $template
     * @return string
     */
    public function getTemplate($template) {
        $templatesPath = __DIR__ . '/../stubs/'. $this->parseTypeName() .'/';

        if($this->option('custom')) {
            $templatesPath = $this->option('path');
        }

        return $templatesPath . $template . '.stub';
    }

    /**
     * Parse and format the type's name.
     *
     * @return mixed
     */
    public function parseTypeName()
    {
        return str_plural(strtolower($this->type));
    }

    /**
     * Get the desired template name from the input.
     *
     * @return array|string
     */
    public function getTemplateInput()
    {
        return $this->option('template');
    }

    /**
     * Parse the name and format according to the root namespace.
     *
     * @param $filename
     * @return string
     */
    protected function parseFileName($filename)
    {
        $filename = str_replace('.stub','',$filename);

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
     * Compile the stub.
     *
     * @param $template
     * @return string
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function compileStub($template)
    {
        $stub = $this->files->get($template);
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
            ['template', 't', InputOption::VALUE_OPTIONAL, 'The template to generate', 'default'],
            ['custom', 'c', InputOption::VALUE_OPTIONAL, 'Use custom templates instead of given ones', false],
            ['path', 'p', InputOption::VALUE_OPTIONAL, 'Local path for template stubs', '/resources/templates/' . $this->parseTypeName()],
        ];
    }


}
