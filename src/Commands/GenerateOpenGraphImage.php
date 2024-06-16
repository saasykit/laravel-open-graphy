<?php

namespace SaaSykit\OpenGraphy\Commands;

use Illuminate\Console\Command;
use SaaSykit\OpenGraphy\ImageGenerator;

class GenerateOpenGraphImage extends Command
{
    public $signature = 'open-graphy:generate {title} {url} {image?} {template?} {templateSettings?} {logoUrl?} {--logo} {--screenshot}  {--test}';

    public $description = 'Generate the Open Graph image';

    public function __construct(
        private ImageGenerator $imageGenerator
    ) {
        parent::__construct();
    }

    public function handle(): int
    {
        $title = $this->argument('title');
        $url = $this->argument('url');
        $image = $this->argument('image');
        $template = $this->argument('template');

        $templateSettings = [];
        if ($this->argument('templateSettings')) {
            $templateSettings = json_decode($this->argument('templateSettings'), true);
        }

        $logo = $this->option('logo');
        $screenshot = $this->option('screenshot');
        $logoUrl = $this->argument('logoUrl');

        $isTest = $this->option('test');

        $this->output->writeln(
            $this->imageGenerator->processGeneration($title, $url, $logo, $screenshot, $image, $template, $templateSettings, $logoUrl, $isTest)
        );

        return self::SUCCESS;
    }
}
