<?php

namespace SimonMarcelLinden\LaravelMultiSelect\Presets;

use Illuminate\Support\Arr;
use SimonMarcelLinden\Presets\Preset;

class Vue extends Preset {
    /**
     * Install the preset.
     *
     * @return void
     */
    public static function install(): void {
        $directories = [resource_path('js/components'), resource_path('sass')];
        static::ensureComponentDirectoryExists( $directories );
        static::updatePackages();
        static::updateWebpackConfiguration();
        static::copyRequiredFiles();
    }

    /**
     * Update the given package array.
     *
     * @param  array  $packages
     * @return array
     */
    static function updatePackageArray(array $packages): array {
        return [
                'resolve-url-loader'    => '^4.0.0',
                'sass'                  => '^1.34.0',
                'sass-loader'           => '^11.1.1',
                'vue'                   => '^2.6.12',
                'vue-loader'            => "^15.9.7",
                'vue-template-compiler' => '^2.6.12',
            ] + Arr::except($packages, [
                '@babel/preset-react',
                'react',
                'react-dom',
            ]);
    }

    /**
     * Update the Webpack configuration.
     *
     * @return void
     */
    protected static function updateWebpackConfiguration(): void {
        if (file_exists( base_path('webpack.mix.js'))) {
            file_put_contents( base_path('webpack.mix.js'),
                file_get_contents(__DIR__ . '/stubs/webpack.mix.js.stub'),
                FILE_APPEND
            );
        } else {
            copy(__DIR__ . '/stubs/webpack.mix.js.stub', base_path('webpack.mix.js'));
        }
    }

    /**
     * Copy all required Files.
     *
     * @return void
     */
    protected static function copyRequiredFiles(): void {
        self::updateSass();
        self::updateBootstrapping();
        self::installVueComponent();
    }

    /**
     * Update the Sass files for the application.
     *
     * @return void
     */
    protected static function updateSass() {
        // (new Filesystem)->ensureDirectoryExists(resource_path('sass'));

        copy(__DIR__ . '/stubs/sass/multiSelect.scss', resource_path('sass/multiSelect.scss'));
    }

    /**
     * Update the bootstrapping files.
     *
     * @return void
     */
    protected static function updateBootstrapping() {
        copy(__DIR__ . '/stubs/js/multiSelect.js', resource_path('js/multiSelect.js'));
    }

    /**
     * Update the example component.
     *
     * @return void
     */
    protected static function installVueComponent() {
        copy( __DIR__.'/stubs/js/components/MultiSelect.component.vue', resource_path('js/components/MultiSelect.component.vue'));
    }
}
