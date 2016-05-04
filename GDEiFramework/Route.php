<?php
namespace GDEiFramework;

class Route
{
    protected $action;
    protected $module;
    protected $url;
    protected $varsNames;
    protected $vars = [];

    public function __construct($url, $module, $action, array $varsNames)
    {
        $this->setUrl($url);
        $this->setModule($module);
        $this->setAction($action);
        $this->setVarsNames($varsNames);
    }

    public function hasVars()
    {
        return !empty($this->varsNames);
    }

    public function match($url)
    {
        if (preg_match('`^' . $this->url . '$`', $url, $matches)) {
            return $matches;
        }
        return false;
    }

    public function setAction($action)
    {
        $this->action = $action;
    }

    public function setModule($module)
    {
        $this->module = $module;
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function setVarsNames($varsNames)
    {
        $this->varsNames = $varsNames;
    }

    public function setVars(array $vars)
    {
        $this->vars = $vars;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function getModule()
    {
        return $this->module;
    }

    public function getVars()
    {
        return $this->vars;
    }

    public function getVarsNames()
    {
        return $this->varsNames;
    }
}
