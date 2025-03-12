<?php

declare(strict_types=1);

namespace App\Infrastructure\TemplateRenderer\Twig;

use App\Application\Mailer\TemplateRendererInterface;
use Twig\Environment;

class TwigTemplateRenderer implements TemplateRendererInterface
{
    public function __construct(private readonly Environment $twig) {}

    /** @param string[] $params */
    public function render(string $template, array $params = []): string
    {
        return $this->twig->render($template, $params);
    }
}
