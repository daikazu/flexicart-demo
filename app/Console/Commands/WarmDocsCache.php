<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Services\MarkdownRenderer;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class WarmDocsCache extends Command
{
    protected $signature = 'docs:compile {--clear : Clear compiled docs first}';

    protected $description = 'Pre-compile documentation pages with Shiki syntax highlighting to static HTML files';

    public function handle(MarkdownRenderer $renderer): int
    {
        $docsPath = resource_path('docs/v1');
        $compiledPath = resource_path('docs/v1/compiled');

        if (! File::isDirectory($docsPath)) {
            $this->error("Docs directory not found: {$docsPath}");

            return self::FAILURE;
        }

        // Create compiled directory if it doesn't exist
        if (! File::isDirectory($compiledPath)) {
            File::makeDirectory($compiledPath, 0755, true);
        }

        if ($this->option('clear')) {
            File::cleanDirectory($compiledPath);
            $this->info('Compiled docs cleared.');
        }

        $files = File::files($docsPath);
        $count = 0;

        $this->info('Compiling documentation to static HTML...');

        foreach ($files as $file) {
            if ($file->getExtension() !== 'md') {
                continue;
            }

            $this->line("  Compiling: {$file->getFilename()}");

            $content = File::get($file->getPathname());
            $html = $renderer->withoutCache()->render($content);

            // Write compiled HTML file
            $htmlFilename = pathinfo($file->getFilename(), PATHINFO_FILENAME).'.html';
            File::put($compiledPath.'/'.$htmlFilename, $html);

            $count++;
        }

        $this->newLine();
        $this->info("Successfully compiled {$count} documentation files to: {$compiledPath}");
        $this->newLine();
        $this->comment('These files should be committed to git and deployed with your app.');

        return self::SUCCESS;
    }
}
