<?php
declare(strict_types=1);
namespace Lib;

class View
{

    public function __construct(private string $view, private array $data = [])
    {
    }

    public static function make(string $view, array $data = []): static
    {
        return new static($view, $data);
    }

    public function render(): string
    {
        $view = VIEWPATH . $this->view . '.php';
        if (!file_exists($view)) {
            throw new \Exception('View Not Found');
        }
        extract($this->data);
        ob_start();
        include $view;
        return (string) ob_get_clean();
    }

    public function __toString(): string
    {
        return $this->render();
    }

    public function __get(string $name) {
        return $this->data[$name] ?? null;
    }
}


// public function render(string $view, array $data = []): string {
//     return $this->view($view, $data);
// $data = json_decode(file_get_contents($view),
// }
