<?php

namespace Hesto\Generators\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Config;
use Symfony\Component\Console\Input\InputOption;

class ViewFixCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'fix:view';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix view with given files';

    public $files;

    /**
     * Create a new command instance.
     *
     * @param Filesystem $files
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
        $directories = $this->files->directories(base_path() . '/resources/views/' . $this->getLayoutInput() . '/');
        $views = collect();

        foreach($directories as $dir) {
            $dirArray = explode('/\\',$dir);
            $views->push($dirArray[1]);
        }

        foreach ($views as $view) {
            $this->call('make:view', [
                'name' => $view,
                '--template' => 'fix',
                '--force' => true
            ]);
        }

        $this->info('Views fixed');
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
            ['layout', 'l', InputOption::VALUE_OPTIONAL, 'To which layout generate the template?', Config::get('hesto.generators.default_layout')],
            ['force', 'f', InputOption::VALUE_NONE, 'Force override existing files'],
        ];
    }
}
