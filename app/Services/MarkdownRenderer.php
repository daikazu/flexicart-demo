<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Spatie\ShikiPhp\Shiki;

class MarkdownRenderer
{
    protected string $theme = 'github-dark';

    protected bool $useCache = true;

    public function render(string $markdown): string
    {
        if ($this->useCache) {
            $cacheKey = 'docs:'.md5($markdown.$this->theme);

            return Cache::rememberForever($cacheKey, fn () => $this->renderMarkdown($markdown));
        }

        return $this->renderMarkdown($markdown);
    }

    public function withoutCache(): self
    {
        $this->useCache = false;

        return $this;
    }

    protected function renderMarkdown(string $markdown): string
    {
        // First convert markdown to HTML
        $html = Str::markdown($markdown);

        // Then highlight code blocks with Shiki
        return $this->highlightCodeBlocks($html);
    }

    public function setTheme(string $theme): self
    {
        $this->theme = $theme;

        return $this;
    }

    protected function highlightCodeBlocks(string $html): string
    {
        // Match <pre><code class="language-xxx">...</code></pre> blocks
        $pattern = '/<pre><code class="language-(\w+)">(.*?)<\/code><\/pre>/s';

        return (string) preg_replace_callback($pattern, function (array $matches): string {
            $language = $matches[1];
            $code = html_entity_decode($matches[2], ENT_QUOTES | ENT_HTML5);

            try {
                return Shiki::highlight(
                    code: $code,
                    language: $this->mapLanguage($language),
                    theme: $this->theme,
                );
            } catch (\Exception) {
                // Fallback to original if Shiki fails
                return $matches[0];
            }
        }, $html) ?? $html;
    }

    protected function mapLanguage(string $language): string
    {
        // Map common language aliases
        return match ($language) {
            'bash', 'sh', 'shell' => 'bash',
            'env' => 'dotenv',
            default => $language,
        };
    }
}
