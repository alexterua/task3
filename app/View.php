<?php


namespace App;


class View
{
    private $data = [];

    public function assign(string $name, $value) : object
    {
        $this->data[$name] = $value;
        return $this;
    }

    public function render(string $template) : string
    {
        ob_start();
        extract($this->data);
        include realpath(__DIR__ . '/../views') . '/' . $template . '.php';
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }
}