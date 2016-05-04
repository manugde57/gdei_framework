<?php
namespace GDEiFramework;

class Config extends ApplicationComponent
{
    protected $vars = [];

    public function get($var)
    {
        if (!$this->vars) {
            $xml = new \DOMDocument;
            $xml->load(__DIR__ . '/../../App/' . $this->app->getName() . '/Config/app.xml');

            $elements = $xml->getElementsByTagName('define');

            foreach ($elements as $element) {
                $this->vars[$element->getAttribute('var')] = $element->getAttribute('value');
            }
        }
        return isset($this->vars[$var]) ? $this->vars[$var] : null;
    }
}
