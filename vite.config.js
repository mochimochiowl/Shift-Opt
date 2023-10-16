import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    root: './', // プロジェクトのルートディレクトリを指定
    base: '/dist/', // 出力ファイルのベースパスを指定
    build: {
        outDir: 'public/dist', // 出力ディレクトリを指定
        rollupOptions: {
            input: 'resources/js/main.js', // エントリポイントとなるJSファイルを指定
            output: {
                entryFileNames: `assets/bundle.js`,
            }
        }
    }
});
