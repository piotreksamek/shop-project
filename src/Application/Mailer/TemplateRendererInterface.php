<?php

declare(strict_types=1);

namespace App\Application\Mailer;

interface TemplateRendererInterface
{
    /** @param string[] $params */
    public function render(string $template, array $params = []): string;
}
