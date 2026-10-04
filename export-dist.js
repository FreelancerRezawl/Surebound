import fs from 'fs';
import path from 'path';
import { fileURLToPath } from 'url';

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

const rootDir = __dirname;
const publicDir = path.join(rootDir, 'public');
const distDir = path.join(rootDir, 'dist');

function copyDirSync(src, dest) {
    if (!fs.existsSync(src)) return;
    fs.mkdirSync(dest, { recursive: true });
    const entries = fs.readdirSync(src, { withFileTypes: true });
    for (const entry of entries) {
        const srcPath = path.join(src, entry.name);
        const destPath = path.join(dest, entry.name);
        if (entry.isDirectory()) {
            copyDirSync(srcPath, destPath);
        } else {
            fs.copyFileSync(srcPath, destPath);
        }
    }
}

// Ensure dist exists
fs.mkdirSync(distDir, { recursive: true });

// Copy public assets into dist
copyDirSync(path.join(publicDir, 'css'), path.join(distDir, 'css'));
copyDirSync(path.join(publicDir, 'js'), path.join(distDir, 'js'));
copyDirSync(path.join(publicDir, 'images'), path.join(distDir, 'images'));
if (fs.existsSync(path.join(publicDir, 'build'))) {
    copyDirSync(path.join(publicDir, 'build'), path.join(distDir, 'build'));
}

['favicon.ico', 'robots.txt'].forEach(f => {
    const src = path.join(publicDir, f);
    if (fs.existsSync(src)) {
        fs.copyFileSync(src, path.join(distDir, f));
    }
});

// Compile Admin Portal for static deployment
const adminBladePath = path.join(rootDir, 'resources', 'views', 'admin', 'dashboard.blade.php');
if (fs.existsSync(adminBladePath)) {
    let adminHtml = fs.readFileSync(adminBladePath, 'utf8');
    // Replace Blade asset helpers with clean static web paths
    adminHtml = adminHtml.replace(/\{\{\s*asset\(['"]([^'"]+)['"]\)\s*\}\}/g, '/$1');
    const adminDistDir = path.join(distDir, 'admin');
    fs.mkdirSync(adminDistDir, { recursive: true });
    fs.writeFileSync(path.join(adminDistDir, 'index.html'), adminHtml);
    console.log('✓ Compiled dist/admin/index.html');
}

console.log('✓ Successfully populated dist directory for Vercel deployment.');
