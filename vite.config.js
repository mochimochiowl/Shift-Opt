import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js'
            ],
            refresh: true,
        }),
    ],
    root: './', // プロジェクトのルートディレクトリを指定
    base: '/dist/', // 出力ファイルのベースパスを指定
    build: {
        outDir: 'public/dist', // 出力ディレクトリを指定
        rollupOptions: {
            input: {
                main: 'resources/js/main.js', // エントリポイントとなるJSファイルを指定
                css: 'resources/css/app.css', // エントリポイントとなるCSSファイルを指定
            },
            output: {
                entryFileNames: `[name].js`,
                chunkFileNames: `[name].js`,
                assetFileNames: `[name].[ext]`
            },
        }
    }
});
