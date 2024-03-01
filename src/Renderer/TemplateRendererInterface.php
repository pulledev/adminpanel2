<?php
declare(strict_types=1);

namespace Pulle\Crusader\Renderer;

interface TemplateRendererInterface
{
    public function render(string $templateName, mixed $data): string;
}