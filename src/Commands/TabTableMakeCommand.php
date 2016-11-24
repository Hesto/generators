<?php

namespace Hesto\Generators\Commands;

use Hesto\Core\Commands\InstallAndReplaceCommand;
use Illuminate\Support\Facades\Config;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use SplFileInfo;

class TabTableMakeCommand extends InstallAndReplaceCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:tab:table';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create tab of given name into given resource with attach detach table';


    public function fire()
    {
        $this->installTab();
        $this->installTabNav();
        $this->installTabContent();
    }

    private function installTab()
    {
        $attachPath = base_path() . '/resources/views/' . $this->getLayoutInput() . '/' . $this->getResourceInput() . '/edit/tabs/horizontal/' . $this->getNameInput() . '-attach.blade.php';
        $detachPath = base_path() . '/resources/views/' . $this->getLayoutInput() . '/' . $this->getResourceInput() . '/edit/tabs/horizontal/' . $this->getNameInput() . '-detach.blade.php';

        $attachStub = __DIR__ . '/../stubs/tabs/table/tab-attach.blade.stub';
        $detachStub = __DIR__ . '/../stubs/tabs/table/tab-detach.blade.stub';

        if ($this->option('custom')) {
            $attachStub = $this->option('path') . '/table/tab-attach.blade.stub';
            $detachStub = $this->option('path') . '/table/tab-detach.blade.stub';
        }

        $attachFile = new SplFileInfo($attachStub);
        $detachFile = new SplFileInfo($detachStub);

        $this->putFile($attachPath, $attachFile);
        $this->putFile($detachPath, $detachFile);
    }

    /**
     * Install Routes.
     *
     * @return bool
     */
    private function installTabNav()
    {
        $path = base_path() . '/resources/views/' . $this->getLayoutInput() . '/' . str_plural($this->getResourceInput()) . '/edit/tabs/horizontal/tab-nav.blade.php';
        $stub = __DIR__ . '/../stubs/tabs/table/tab-nav.stub';

        if ($this->option('custom')) {
            $stub = __DIR__ . $this->option('path') . '/tabs/table/tab-nav.stub';
        }

        if (!$this->contentExists($path, $stub)) {
            $file = new SplFileInfo($stub);
            $this->appendFile($path, $file);

            return true;
        }

        return false;
    }

    private function installTabContent()
    {
        $path = base_path() . '/resources/views/' . $this->getLayoutInput() . '/' . str_plural($this->getResourceInput()) . '/edit/tabs/horizontal/tab-content.blade.php';
        $stub = __DIR__ . '/../stubs/tabs/table/tab-content.stub';

        if ($this->option('custom')) {
            $stub = __DIR__ . $this->option('path') . '/tabs/table/tab-content.stub';
        }

        if (!$this->contentExists($path, $stub)) {
            $file = new SplFileInfo($stub);
            $this->appendFile($path, $file);

            return true;
        }

        return false;
    }

    /**
     * Compile content.
     *
     * @param $content
     * @return mixed
     */
    public function compile($content)
    {
        $content = parent::compile($content);

        if ($this->getResourceInput() != null) {
            $content = str_replace('{{resourcePluralSlug}}', str_plural(str_slug($this->getResourceInput())), $content);
            $content = str_replace('{{resourceSingularCamel}}', str_singular(camel_case($this->getResourceInput())),
                $content);
        }

        if ($this->getLayoutInput() != null) {
            $content = str_replace('{{layout}}', str_singular($this->getLayoutInput()), $content);

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
     * @return mixed
     */
    public function getResourceInput()
    {
        return $this->argument('resource');
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    public function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the class'],
            ['resource', InputArgument::REQUIRED, 'The name of the resource'],
        ];
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
            ['custom', 'c', InputOption::VALUE_OPTIONAL, 'Use custom templates instead of given ones', Config::get('hesto.generators.custom_tab_table_templates')],
            ['path', 'p', InputOption::VALUE_OPTIONAL, 'Local path for template stubs', Config::get('hesto.generators.custom_tab_table_templates_path')],
            ['force', 'f', InputOption::VALUE_NONE, 'Force override existing files'],
        ];
    }
}
