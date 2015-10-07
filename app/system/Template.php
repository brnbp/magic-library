<?php

class Template
{
    private $variablePrefix = 'template_';
    private $directory;
    private $template;
    private $templateFile;
    private $rootDirectory;

    public function __construct($directory = 'templates', $variablePrefix = null, $rootDirectory = null)
    {
        $this->directory = '../app/templates';

        if (!is_null($variablePrefix)) {
            $this->variablePrefix = $variablePrefix;
        }

        if (!is_null($rootDirectory)) {
            $this->rootDirectory = $rootDirectory;
        }
    }

    public function link($href)
    {
        return '/' . $this->rootDirectory . $href;
    }

    public function loads($template, array $variables = array())
    {
        $this->template = $template;
        $this->templateFile = $this->directory . '/' . $this->template . '.php';
        if (!file_exists($this->templateFile)) {
            die('Template "' . $templateFile . '" not found!');
        }

        if (count($variables)) {
           foreach ($variables as $key => $value) {
                $key = $this->variablePrefix . $key;
                ${$key} = $value;
            }
        }

        require_once $this->templateFile;
    }
}