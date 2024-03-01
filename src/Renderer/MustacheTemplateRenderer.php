<?php
declare(strict_types=1);

namespace Pulle\Crusader\Renderer;

use Pulle\Crusader\Renderer\TemplateRendererInterface;

final class MustacheTemplateRenderer implements TemplateRendererInterface
{
    public function __construct(private readonly \Mustache_Engine $mustache){

    }
    public function render(string $templateName, mixed $data): string
    {
        return $this->mustache->render($templateName,$data);
    }

}