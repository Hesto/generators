<?php

namespace Hesto\Generators\Commands;

use Hesto\Core\Commands\InstallAndReplaceCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class ControllerRouteMakeCommand extends InstallAndReplaceCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:route:controller';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create controller route';


    public function fire()
    {
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
            ['layout', 'l', InputOption::VALUE_OPTIONAL, 'To which layout generate the template?', 'admin'],
            ['force', 'f', InputOption::VALUE_NONE, 'Force override existing files'],
        ];
    }
}
