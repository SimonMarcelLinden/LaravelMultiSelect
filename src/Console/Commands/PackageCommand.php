<?php

namespace SimonMarcelLinden\LaravelMultiSelect\Console\Commands;

use Illuminate\Console\Command;

use SimonMarcelLinden\LaravelMultiSelect\Presets\Vue;

class PackageCommand extends Command {

    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'multiSelect:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Vue and published required files';

    /**
     * Execute the console command.
     *
     * @return void
     *
     * @throws \InvalidArgumentException
     */
    public function handle(): void{
        Vue::install();

        $this->info('Vue scaffolding installed successfully.');
        $this->comment('Please run "npm install && npm run dev" to compile your fresh scaffolding.');
    }
}
