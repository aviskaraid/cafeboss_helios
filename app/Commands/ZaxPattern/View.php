<?php

namespace App\Commands\ZaxPattern;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use CodeIgniter\CLI\GeneratorTrait;

class View extends BaseCommand
{
    use GeneratorTrait;

    protected $group       = 'ZaxPattern';
    protected $name        = 'zax:view';
    protected $description = 'Creates a new View for HMVC';
    protected $usage       = 'zax:view [module] [name] [options]';
    protected $arguments   = [
        'module' => 'The name of the HMVC module',
        'name'   => 'The name of the View Name',
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
            CLI::error("The View '{$module}' does not exist. Please create the module first with 'php spark zax:module {$module}'.");
            return;
        }

        $name = $params[1] ?? CLI::prompt('View name', null, 'required');
        //$name = ucfirst($name);

        // Validate the View name format
        if (!$this->isValidViewName($name)) {
            CLI::error("The view name '{$name}' is not valid. It must start with a capital letter and contain only letters.");
            return;
        }       

        $path = APPPATH . 'Modules/' . $module . '/Views/' . $name . '.php';

        // Check if the controller already exists
        if (file_exists($path)) {
            CLI::error("The View '{$name}' already exists in the '{$module}' module.");
            return;
        }

        // $template = $this->getTemplate('view.tpl.php', $name);
        $template = $this->getTemplate(
            'view.tpl.php',
            [
            '{moduleName}' => $module,
            '{viewName}' => $name
            ]
        );
        $this->generateFile($path, $template);

        CLI::write('HMVC View created: ' . CLI::color($path, 'green'));
    }

    private function isHmvcConfigured()
    {
        return file_exists(APPPATH . 'Modules/.hmvc_configured');
    }

    private function moduleExists($module)
    {
        return is_dir(APPPATH . 'Modules/' . $module);
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
}