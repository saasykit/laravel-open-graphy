<?php

namespace SaaSykit\OpenGraphy\Commands;

use Illuminate\Console\Command;
use SaaSykit\OpenGraphy\ImageGenerator;

class GenerateOpenGraphImage extends Command
{
    public $signature = 'open-graphy:generate {title} {url} {image?} {template?} {--logo} {--screenshot}  {--test}';

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
        $logo = $this->option('logo');
        $screenshot = $this->option('screenshot');
        $isTest = $this->option('test');

        $this->output->writeln(
            $this->imageGenerator->generate($title, $url, $logo, $screenshot, $image, $template, $isTest)
        );

        return self::SUCCESS;
    }
}
