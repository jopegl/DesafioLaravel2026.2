import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/hero-carousel.css',
                'resources/css/root.css',

                'resources/js/app.js',
                'resources/js/balance-counter.js',
                'resources/js/bootstrap.js',
                'resources/js/hero-carousel.js',

                'resources/js/alpine/address-modals.js',
                'resources/js/alpine/cep-address-form.js',
                'resources/js/alpine/contact-modals.js',
                'resources/js/alpine/crud-modals.js',
                'resources/js/alpine/email-search.js',
            ],
            refresh: true,
        }),
    ],
});