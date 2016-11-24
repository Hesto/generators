<?php

namespace Hesto\Generators\Commands;

use Hesto\Core\Commands\InstallAndReplaceCommand;
use Illuminate\Support\Facades\Config;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use SplFileInfo;

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
        $path = base_path() . '/routes/' . $this->getGuardInput() . '.php';
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
    public function getGuardInput()
    {
        return $this->option('guard');
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    public function getOptions()
    {
        return [
            ['guard', 'l', InputOption::VALUE_OPTIONAL, 'To which guard generate the template?', Config::get('hesto.generators.default_controller_guard')],
            ['force', 'f', InputOption::VALUE_NONE, 'Force override existing files'],
        ];
    }
}
