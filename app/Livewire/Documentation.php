<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Services\MarkdownRenderer;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Url;
use Livewire\Component;

class Documentation extends Component
{
    #[Url]
    public string $section = 'installation';

    public string $version = 'v1';

    protected function getDocsPath(): string
    {
        return resource_path('docs/'.$this->version);
    }

    protected function getCompiledPath(): string
    {
        return resource_path('docs/'.$this->version.'/compiled');
    }

    /**
     * @return array<string, array{title: string, file: string}>
     */
    public function getSections(): array
    {
        $docsPath = $this->getDocsPath();

        return [
            'installation' => [
                'title' => 'Installation',
                'file' => $docsPath.'/INSTALLATION.md',
            ],
            'basic-usage' => [
                'title' => 'Basic Usage',
                'file' => $docsPath.'/BASIC_USAGE.md',
            ],
            'conditions' => [
                'title' => 'Conditions',
                'file' => $docsPath.'/CONDITIONS.md',
            ],
            'configuration' => [
                'title' => 'Configuration',
                'file' => $docsPath.'/CONFIGURATION.md',
            ],
            'rules-engine' => [
                'title' => 'Rules Engine',
                'file' => $docsPath.'/RULES_ENGINE.md',
            ],
            'cart-merging' => [
                'title' => 'Cart Merging',
                'file' => $docsPath.'/MERGING.md',
            ],
            'events' => [
                'title' => 'Events',
                'file' => $docsPath.'/EVENTS.md',
            ],
            'prices' => [
                'title' => 'Working with Prices',
                'file' => $docsPath.'/PRICES.md',
            ],
            'blade' => [
                'title' => 'Blade Templates',
                'file' => $docsPath.'/BLADE.md',
            ],
            'extending' => [
                'title' => 'Extending FlexiCart',
                'file' => $docsPath.'/EXTENDING.md',
            ],
            'troubleshooting' => [
                'title' => 'Troubleshooting',
                'file' => $docsPath.'/TROUBLESHOOTING.md',
            ],
        ];
    }

    /**
     * Get the rendered HTML content for the current section.
     * Uses pre-compiled HTML if available, otherwise renders markdown on-the-fly.
     */
    public function getRenderedContent(): string
    {
        $sections = $this->getSections();

        if (! isset($sections[$this->section])) {
            $this->section = 'installation';
        }

        $mdFile = $sections[$this->section]['file'];
        $filename = pathinfo($mdFile, PATHINFO_FILENAME);
        $compiledFile = $this->getCompiledPath().'/'.$filename.'.html';

        // Check for pre-compiled HTML first (production)
        if (file_exists($compiledFile)) {
            return file_get_contents($compiledFile) ?: '';
        }

        // Fall back to on-the-fly rendering (development)
        if (file_exists($mdFile)) {
            $markdown = file_get_contents($mdFile) ?: '';

            return app(MarkdownRenderer::class)->render($markdown);
        }

        return '<p>Section not found</p>';
    }

    public function setSection(string $section): void
    {
        $this->section = $section;
    }

    public function render(): View
    {
        return view('livewire.documentation', [
            'sections' => $this->getSections(),
            'renderedContent' => $this->getRenderedContent(),
            'currentSection' => $this->section,
        ]);
    }
}
