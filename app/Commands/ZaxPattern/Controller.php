<?php

namespace App\Commands\ZaxPattern;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use CodeIgniter\CLI\GeneratorTrait;

class Controller extends BaseCommand
{
    use GeneratorTrait;

    protected $group       = 'ZaxPattern';
    protected $name        = 'zax:controller';

    protected $ViewName        = 'viewName';

    protected $description = 'Creates a new controller for HMVC';
    protected $usage       = 'zax:controller [module] [name] [view_name] [options]';
    protected $arguments   = [
        'module' => 'The name of the HMVC module',
        'name'   => 'The name of the controller class',
        'view_name'   => 'The name of the controller class',
    ];

    public function run(array $params)
    {
        // Check if HMVC is configured
        if (!$this->isHmvcConfigured()) {
            CLI::error('HMVC is not configured. Please run "php spark zax:setup" first.');
            return;
        }

        $module = $params[0] ?? CLI::prompt('Module name', null, 'required');
        $module = ucfirst($module);
        // Check if the module exists
        if (!$this->moduleExists($module)) {
            CLI::error("The module '{$module}' does not exist. Please create the module first with 'php spark zax:module {$module}'.");
            return;
        }

        $name = $params[1] ?? CLI::prompt('Controller name', null, 'required');
        $name = ucfirst($name);

        // Validate the controller name format
        if (!$this->isValidControllerName($name)) {
            CLI::error("The controller name '{$name}' is not valid. It must start with a capital letter and contain only letters.");
            return;
        }       

        $path = APPPATH . 'Modules/' . $module . '/Controllers/' . $name . 'Controller.php';

        // Check if the controller already exists
        if (file_exists($path)) {
            CLI::error("The controller '{$name}Controller' already exists in the '{$module}' module.");
            return;
        }

        $view_name = $params[2] ?? CLI::prompt('View name', null, 'required');
        //$name = ucfirst($name);

        // Validate the controller name format
        if (!$this->isValidViewName($view_name)) {
            CLI::error("The View name '{$view_name}' is not valid. It must start with a letter and contain only letters.");
            return;
        }       

        $path_View = APPPATH . 'Modules/' . $module . '/Views/' . $view_name . '.php';
        $this->ViewName = $view_name;

        $template = $this->getTemplate(
            'view.tpl.php',
            [
            '{moduleName}' => $module
            ]
        );

        $template = $this->getControllerTemplate($module, $name);
        $templateView = $this->getTemplate(
            'view.tpl.php',
            [
            '{moduleName}' => $module,
            '{viewName}' => $view_name
            ]
        );
        $this->generateFile($path, $template);
        $this->generateFile($path_View, $templateView);

        CLI::write('HMVC Controller created: ' . CLI::color($path, 'green'));
    }

    private function isHmvcConfigured()
    {
        return file_exists(APPPATH . 'Modules/.hmvc_configured');
    }

    private function moduleExists($module)
    {
        return is_dir(APPPATH . 'Modules/' . $module);
    }

    private function isValidControllerName($name)
    {
        return preg_match('/^[A-Z][a-zA-Z]*$/', $name);
    }
    private function isValidViewName($name)
    {
        return preg_match('/^[a-z_]*$/', $name);
    }

    protected function getTemplate($templateFile, $placeholders)
    {
        $templatePath = APPPATH . 'Commands/Views/' . $templateFile;

        if (!file_exists($templatePath)) {
            CLI::write('Template file not found: ' . $templateFile, 'red');
            return '';
        }

        $templateContent = file_get_contents($templatePath);

        foreach ($placeholders as $placeholder => $value) {
            $templateContent = str_replace($placeholder, $value, $templateContent);
        }
        $templateContent = str_replace('<@php', '<?php', $templateContent);

        return $templateContent;
    } 

    private function getControllerTemplate($module, $name)
    {
        return <<<EOD
<?php

namespace Modules\\{$module}\\Controllers;

use App\Controllers\BaseController;

class {$name}Controller extends BaseController
{   
    private \$module = '{$module}'; // Module name

    public function index()
    {
        // Example data to send to the view
        \$data = [
            'title' => 'Welcome to {$module} module',
            'message' => 'This is an HMVC example in CodeIgniter 4'
        ];

        // Example of how to call a view with hmvcView
        // Syntax: hmvcView(string \$module, string \$view, array \$data = [], array \$options = [])
        //
        // \$module: Name of the module (folder) where the view is located
        // \$view: Name of the view file without the .php extension
        // \$data: Associative array with the data to pass to the view (optional)
        // \$options: Array of additional options for the view (optional)
        //
        // Usage example:
        //return hmvcView(\$this->module, 'index', \$data, ['cache' => 300]);
        return hmvcView(\$this->module, '$this->ViewName', \$data);
    }
}
EOD;
    }
}