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

// Helper to clean Blade tags for static deployment
function cleanBladeToStatic(bladeContent) {
    return bladeContent
        .replace(/\{\{\s*asset\(['"]([^'"]+)['"]\)\s*\}\}/g, '/$1')
        .replace(/\{\{\s*route\(['"]([^'"]+)['"]\)\s*\}\}/g, (match, routeName) => {
            if (routeName === 'login' || routeName === 'login.post') return '/login';
            if (routeName === 'register' || routeName === 'register.post') return '/register';
            if (routeName === 'admin.dashboard') return '/admin';
            if (routeName === 'home') return '/';
            return '/' + routeName;
        })
        .replace(/@csrf/g, '')
        .replace(/@auth[\s\S]*?@else/g, '')
        .replace(/@endauth/g, '')
        .replace(/@if\s*\([^)]*\)[\s\S]*?@endif/g, '')
        .replace(/\{\{\s*[^}]+\s*\}\}/g, '');
}

// 1. Compile Admin Portal for static deployment
const adminBladePath = path.join(rootDir, 'resources', 'views', 'admin', 'dashboard.blade.php');
if (fs.existsSync(adminBladePath)) {
    let adminHtml = fs.readFileSync(adminBladePath, 'utf8');
    adminHtml = cleanBladeToStatic(adminHtml);
    const adminDistDir = path.join(distDir, 'admin');
    fs.mkdirSync(adminDistDir, { recursive: true });
    fs.writeFileSync(path.join(adminDistDir, 'index.html'), adminHtml);
    console.log('✓ Compiled dist/admin/index.html');
}

// 2. Compile Login Page
const loginBladePath = path.join(rootDir, 'resources', 'views', 'auth', 'login.blade.php');
if (fs.existsSync(loginBladePath)) {
    let loginHtml = fs.readFileSync(loginBladePath, 'utf8');
    loginHtml = cleanBladeToStatic(loginHtml);
    const loginDistDir = path.join(distDir, 'login');
    fs.mkdirSync(loginDistDir, { recursive: true });
    fs.writeFileSync(path.join(loginDistDir, 'index.html'), loginHtml);
    console.log('✓ Compiled dist/login/index.html');
}

// 3. Compile Register Page
const registerBladePath = path.join(rootDir, 'resources', 'views', 'auth', 'register.blade.php');
if (fs.existsSync(registerBladePath)) {
    let registerHtml = fs.readFileSync(registerBladePath, 'utf8');
    registerHtml = cleanBladeToStatic(registerHtml);
    const registerDistDir = path.join(distDir, 'register');
    fs.mkdirSync(registerDistDir, { recursive: true });
    fs.writeFileSync(path.join(registerDistDir, 'index.html'), registerHtml);
    console.log('✓ Compiled dist/register/index.html');
}

console.log('✓ Successfully populated dist directory for Vercel deployment.');
