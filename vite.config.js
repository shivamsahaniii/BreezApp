import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css',
                    'resources/js/app.js', 
                    'resources/css/homePage/style.css',
                    'resources/css/DataTableFix/style.css',
                    'resources/js/dataTables/leads/index.js',
                    'resources/js/dataTables/leads/trash.js',
                    'resources/js/dataTables/index.js',
                ],
            refresh: true,
        }),
    ],
});
