<?php

namespace App\Twig;

use App\Routing\Router;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class PathExtension extends AbstractExtension
{
    private Router $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('path', [$this, 'generatePath']),
        ];
    }

    public function generatePath(string $routeName): string
    {
        try {
            return $this->router->generateUrl($routeName);
        } catch (\Exception $e) {
            return "Erreur, cette route n'existe pas !";
        }
    }
}
