<?php

declare(strict_types=1);

$config = [
    'canonicalUrl' => 'https://tony.engineer/',
    'defaultLocale' => 'en',
    'email' => 'thinks.swagger_0y@icloud.com',
    'githubUrl' => 'https://github.com/lucups',
    'footer' => '©2015~2026 TONY.ENGINEER',
    'locales' => [
        'en' => [
            'htmlLang' => 'en',
            'name' => 'Tony Lu',
            'role' => 'Software Engineer',
            'title' => 'Tony Lu — Software Engineer',
            'description' => 'Tony Lu, Software Engineer.',
            'controlsLabel' => 'Page controls',
            'languageToggleLabel' => '切换到中文',
            'themeToDarkLabel' => 'Switch to dark mode',
            'themeToLightLabel' => 'Switch to light mode',
            'socialLabel' => 'Social links',
            'githubLabel' => 'Tony Lu on GitHub',
            'emailLabel' => 'Email Tony Lu',
        ],
        'zh' => [
            'htmlLang' => 'zh-CN',
            'name' => '陆健',
            'role' => '软件工程师',
            'title' => '陆健 — 软件工程师',
            'description' => '陆健，软件工程师。',
            'controlsLabel' => '页面控制',
            'languageToggleLabel' => 'Switch to English',
            'themeToDarkLabel' => '切换到暗色模式',
            'themeToLightLabel' => '切换到亮色模式',
            'socialLabel' => '社交链接',
            'githubLabel' => '陆健的 GitHub 主页',
            'emailLabel' => '给陆健发送邮件',
        ],
    ],
];

function h(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function jsonForScript(mixed $value): string
{
    return json_encode(
        $value,
        JSON_UNESCAPED_UNICODE
        | JSON_UNESCAPED_SLASHES
        | JSON_HEX_TAG
        | JSON_HEX_AMP
        | JSON_HEX_APOS
        | JSON_HEX_QUOT
    ) ?: '{}';
}

$defaultLocale = $config['defaultLocale'];
$defaultContent = $config['locales'][$defaultLocale];
$mailUrl = 'mailto:' . $config['email'];

$html = (static function () use ($config, $defaultLocale, $defaultContent, $mailUrl): string {
    ob_start();
    ?>
<!doctype html>
<html lang="<?= h($defaultContent['htmlLang']) ?>" data-locale="<?= h($defaultLocale) ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="color-scheme" content="light dark">
    <meta name="theme-color" content="#ffffff">
    <meta name="description" content="<?= h($defaultContent['description']) ?>">
    <meta name="author" content="<?= h($defaultContent['name']) ?>">
    <meta name="robots" content="index, follow">
    <meta property="og:type" content="profile">
    <meta property="og:url" content="<?= h($config['canonicalUrl']) ?>">
    <meta property="og:title" content="<?= h($defaultContent['title']) ?>">
    <meta property="og:description" content="<?= h($defaultContent['description']) ?>">
    <meta property="og:site_name" content="TONY.ENGINEER">
    <link rel="canonical" href="<?= h($config['canonicalUrl']) ?>">
    <link rel="icon" href="/favicon.ico" sizes="any">
    <title><?= h($defaultContent['title']) ?></title>
    <script>
        (() => {
            const root = document.documentElement;
            const locales = ['en', 'zh'];
            const themes = ['light', 'dark'];
            const readPreference = (key, allowed) => {
                try {
                    const value = window.localStorage.getItem(key);
                    return allowed.includes(value) ? value : null;
                } catch (error) {
                    return null;
                }
            };
            const browserLanguages = navigator.languages?.length
                ? navigator.languages
                : [navigator.language || ''];
            const browserLocale = browserLanguages.some((language) => (
                String(language).toLowerCase().startsWith('zh')
            )) ? 'zh' : 'en';
            const locale = readPreference('lucups.homepage.locale', locales) || browserLocale;
            const theme = readPreference('lucups.homepage.theme', themes)
                || (window.matchMedia?.('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');

            root.dataset.locale = locale;
            root.dataset.theme = theme;
            root.lang = locale === 'zh' ? 'zh-CN' : 'en';
            root.style.colorScheme = theme;
        })();
    </script>
    <style>
        :root {
            color-scheme: light;
            --background: #ffffff;
            --text: #0a0a0b;
            --secondary: #24262b;
            --line: #d9dde4;
            --control-border: #d2d7df;
            --control-hover: #f4f6f8;
            --focus: #2563eb;
            --footer: #747981;
            --page-padding-x: clamp(24px, 3.6vw, 56px);
        }

        :root[data-theme="dark"] {
            color-scheme: dark;
            --background: #111214;
            --text: #f7f7f5;
            --secondary: #dedede;
            --line: #4a4d52;
            --control-border: #555960;
            --control-hover: #202226;
            --focus: #60a5fa;
            --footer: #7f838a;
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            min-height: 100%;
        }

        html {
            background: var(--background);
        }

        body {
            min-height: 100vh;
            min-height: 100svh;
            margin: 0;
            overflow-x: hidden;
            background: var(--background);
            color: var(--text);
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", "PingFang SC",
                "Hiragino Sans GB", "Microsoft YaHei", sans-serif;
            text-rendering: optimizeLegibility;
            -webkit-font-smoothing: antialiased;
            transition: background-color 180ms ease, color 180ms ease;
        }

        button,
        a {
            -webkit-tap-highlight-color: transparent;
        }

        button {
            font: inherit;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        [data-copy-locale] {
            display: none;
        }

        :root[data-locale="en"] [data-copy-locale="en"],
        :root[data-locale="zh"] [data-copy-locale="zh"] {
            display: inline;
        }

        .page {
            min-height: 100vh;
            min-height: 100svh;
            display: grid;
            grid-template-rows: minmax(0, 1fr) auto;
            padding: 0 var(--page-padding-x) max(22px, env(safe-area-inset-bottom));
        }

        .site-header {
            position: fixed;
            z-index: 10;
            top: max(28px, env(safe-area-inset-top));
            right: var(--page-padding-x);
        }

        .controls {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .control {
            width: 40px;
            height: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--control-border);
            border-radius: 50%;
            padding: 0;
            background: transparent;
            color: var(--text);
            cursor: pointer;
            transition:
                background-color 160ms ease,
                border-color 160ms ease,
                color 160ms ease,
                transform 160ms ease;
        }

        .control:hover {
            border-color: var(--secondary);
            background: var(--control-hover);
            transform: translateY(-1px);
        }

        .control:active {
            transform: translateY(0);
        }

        .control:focus-visible,
        .social-link:focus-visible {
            outline: 3px solid color-mix(in srgb, var(--focus) 45%, transparent);
            outline-offset: 4px;
        }

        .control svg {
            width: 19px;
            height: 19px;
            display: block;
            fill: none;
            stroke: currentColor;
            stroke-linecap: round;
            stroke-linejoin: round;
            stroke-width: 1.8;
        }

        .control .theme-icon-sun {
            display: none;
        }

        :root[data-theme="dark"] .control .theme-icon-sun {
            display: block;
        }

        :root[data-theme="dark"] .control .theme-icon-moon {
            display: none;
        }

        .main {
            min-height: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 100px 0 44px;
        }

        .profile {
            width: min(100%, 640px);
            transform: translateY(8px);
            text-align: center;
        }

        .name {
            margin: 0;
            color: var(--text);
            font-family: Georgia, "Times New Roman", "Songti SC", STSong, serif;
            font-size: clamp(2rem, 3.2vw, 3.125rem);
            font-weight: 400;
            line-height: 1;
            letter-spacing: -0.03em;
        }

        :root[data-locale="zh"] .name {
            font-family: "Songti SC", STSong, "Noto Serif CJK SC", serif;
            letter-spacing: 0.08em;
        }

        .role {
            margin: 16px 0 0;
            color: var(--secondary);
            font-size: clamp(0.875rem, 1.2vw, 1.125rem);
            font-weight: 400;
            line-height: 1.2;
            letter-spacing: 0.12em;
        }

        :root[data-locale="zh"] .role {
            letter-spacing: 0.24em;
        }

        .social-links {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 32px;
            margin-top: 26px;
        }

        .social-link {
            width: 42px;
            height: 42px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            color: var(--text);
            transition: color 160ms ease, transform 160ms ease;
        }

        .social-link:hover {
            color: var(--focus);
            transform: translateY(-2px);
        }

        .social-link svg {
            width: 30px;
            height: 30px;
            display: block;
        }

        .github-icon {
            fill: currentColor;
        }

        .email-icon {
            fill: none;
            stroke: currentColor;
            stroke-linecap: round;
            stroke-linejoin: round;
            stroke-width: 1.65;
        }

        .footer {
            min-height: 64px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-top: 1px solid var(--line);
            padding: 0 12px;
            color: var(--footer);
            font-size: 11px;
            font-weight: 400;
            line-height: 1.4;
            letter-spacing: 0.12em;
            text-align: center;
            white-space: nowrap;
        }

        @media (max-width: 640px) {
            :root {
                --page-padding-x: 24px;
            }

            .site-header {
                top: max(18px, env(safe-area-inset-top));
            }

            .controls {
                gap: 8px;
            }

            .control {
                width: 36px;
                height: 36px;
            }

            .control svg {
                width: 18px;
                height: 18px;
            }

            .main {
                padding: 84px 0 44px;
            }

            .profile {
                transform: none;
            }

            .name {
                font-size: 2.125rem;
            }

            .role {
                margin-top: 14px;
                font-size: 0.9375rem;
            }

            .social-links {
                gap: 26px;
                margin-top: 24px;
            }

            .social-link {
                width: 40px;
                height: 40px;
            }

            .social-link svg {
                width: 29px;
                height: 29px;
            }

            .footer {
                min-height: 44px;
                font-size: 10.5px;
                letter-spacing: 0.09em;
            }
        }

        @media (max-width: 360px) {
            .footer {
                font-size: 10px;
                letter-spacing: 0.065em;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                scroll-behavior: auto !important;
                transition-duration: 0.01ms !important;
            }
        }

        @media (forced-colors: active) {
            .control {
                border-color: ButtonText;
            }
        }
    </style>
</head>
<body>
    <div class="page">
        <header class="site-header">
            <div class="controls" data-controls aria-label="<?= h($defaultContent['controlsLabel']) ?>">
                <button class="control" type="button" data-language-toggle aria-label="<?= h($defaultContent['languageToggleLabel']) ?>" title="<?= h($defaultContent['languageToggleLabel']) ?>">
                    <svg aria-hidden="true" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="9"></circle>
                        <path d="M3.6 9h16.8M3.6 15h16.8"></path>
                        <path d="M12 3c2.05 2.44 3.08 5.44 3.08 9S14.05 18.56 12 21"></path>
                        <path d="M12 3C9.95 5.44 8.92 8.44 8.92 12S9.95 18.56 12 21"></path>
                    </svg>
                </button>
                <button class="control" type="button" data-theme-toggle aria-label="<?= h($defaultContent['themeToDarkLabel']) ?>" title="<?= h($defaultContent['themeToDarkLabel']) ?>">
                    <svg class="theme-icon-sun" aria-hidden="true" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="4"></circle>
                        <path d="M12 2.5V5M12 19v2.5M2.5 12H5M19 12h2.5"></path>
                        <path d="m5.3 5.3 1.8 1.8m9.8 9.8 1.8 1.8m0-13.4-1.8 1.8m-9.8 9.8-1.8 1.8"></path>
                    </svg>
                    <svg class="theme-icon-moon" aria-hidden="true" viewBox="0 0 24 24">
                        <path d="M20.2 15.2A8.4 8.4 0 0 1 8.8 3.8a8.5 8.5 0 1 0 11.4 11.4Z"></path>
                    </svg>
                </button>
            </div>
        </header>

        <main class="main">
            <section class="profile" aria-labelledby="profile-name">
                <h1 class="name" id="profile-name">
                    <?php foreach ($config['locales'] as $locale => $content): ?>
                        <span data-copy-locale="<?= h($locale) ?>"><?= h($content['name']) ?></span>
                    <?php endforeach; ?>
                </h1>
                <p class="role">
                    <?php foreach ($config['locales'] as $locale => $content): ?>
                        <span data-copy-locale="<?= h($locale) ?>"><?= h($content['role']) ?></span>
                    <?php endforeach; ?>
                </p>
                <nav class="social-links" data-social aria-label="<?= h($defaultContent['socialLabel']) ?>">
                    <a class="social-link" data-github href="<?= h($config['githubUrl']) ?>" target="_blank" rel="noopener noreferrer" aria-label="<?= h($defaultContent['githubLabel']) ?>" title="<?= h($defaultContent['githubLabel']) ?>">
                        <svg class="github-icon" aria-hidden="true" viewBox="0 0 24 24">
                            <path d="M12 .7A11.3 11.3 0 0 0 8.43 22.72c.57.1.78-.25.78-.55v-2.15c-3.18.7-3.85-1.35-3.85-1.35-.52-1.32-1.27-1.67-1.27-1.67-1.04-.71.08-.7.08-.7 1.15.08 1.75 1.18 1.75 1.18 1.02 1.74 2.67 1.24 3.33.95.1-.74.4-1.24.72-1.53-2.54-.29-5.21-1.27-5.21-5.66 0-1.25.45-2.27 1.18-3.07-.12-.29-.51-1.46.11-3.03 0 0 .96-.31 3.13 1.17a10.87 10.87 0 0 1 5.69 0C17.04 4.87 18 5.18 18 5.18c.62 1.57.23 2.74.11 3.03.73.8 1.18 1.82 1.18 3.07 0 4.4-2.68 5.36-5.23 5.65.41.36.78 1.06.78 2.13v3.16c0 .3.21.66.79.55A11.3 11.3 0 0 0 12 .7Z"></path>
                        </svg>
                    </a>
                    <a class="social-link" data-email href="<?= h($mailUrl) ?>" aria-label="<?= h($defaultContent['emailLabel']) ?>" title="<?= h($defaultContent['emailLabel']) ?>">
                        <svg class="email-icon" aria-hidden="true" viewBox="0 0 24 24">
                            <rect x="2.5" y="4.75" width="19" height="14.5" rx="1.8"></rect>
                            <path d="m3.4 6 8.6 6.6L20.6 6"></path>
                        </svg>
                    </a>
                </nav>
            </section>
        </main>

        <footer class="footer"><?= h($config['footer']) ?></footer>
    </div>

    <script>
        (() => {
            const translations = <?= jsonForScript($config['locales']) ?>;
            const locales = Object.keys(translations);
            const themes = ['light', 'dark'];
            const root = document.documentElement;
            const localeStorageKey = 'lucups.homepage.locale';
            const themeStorageKey = 'lucups.homepage.theme';
            const themeColor = document.querySelector('meta[name="theme-color"]');
            const description = document.querySelector('meta[name="description"]');
            const author = document.querySelector('meta[name="author"]');
            const ogTitle = document.querySelector('meta[property="og:title"]');
            const ogDescription = document.querySelector('meta[property="og:description"]');
            const languageToggle = document.querySelector('[data-language-toggle]');
            const themeToggle = document.querySelector('[data-theme-toggle]');
            const controls = document.querySelector('[data-controls]');
            const social = document.querySelector('[data-social]');
            const github = document.querySelector('[data-github]');
            const email = document.querySelector('[data-email]');
            const systemTheme = window.matchMedia?.('(prefers-color-scheme: dark)');

            const storePreference = (key, value) => {
                try {
                    window.localStorage.setItem(key, value);
                } catch (error) {
                    // localStorage can be unavailable in strict privacy modes.
                }
            };

            const readPreference = (key, allowed) => {
                try {
                    const value = window.localStorage.getItem(key);
                    return allowed.includes(value) ? value : null;
                } catch (error) {
                    return null;
                }
            };

            const applyLocale = (locale, persist = false) => {
                const activeLocale = locales.includes(locale) ? locale : 'en';
                const content = translations[activeLocale];

                root.dataset.locale = activeLocale;
                root.lang = content.htmlLang;
                document.title = content.title;
                description?.setAttribute('content', content.description);
                author?.setAttribute('content', content.name);
                ogTitle?.setAttribute('content', content.title);
                ogDescription?.setAttribute('content', content.description);
                controls?.setAttribute('aria-label', content.controlsLabel);
                social?.setAttribute('aria-label', content.socialLabel);
                github?.setAttribute('aria-label', content.githubLabel);
                github?.setAttribute('title', content.githubLabel);
                email?.setAttribute('aria-label', content.emailLabel);
                email?.setAttribute('title', content.emailLabel);
                languageToggle?.setAttribute('aria-label', content.languageToggleLabel);
                languageToggle?.setAttribute('title', content.languageToggleLabel);
                updateThemeLabel(root.dataset.theme || 'light', content);

                if (persist) {
                    storePreference(localeStorageKey, activeLocale);
                }
            };

            const updateThemeLabel = (theme, content = translations[root.dataset.locale || 'en']) => {
                const label = theme === 'dark'
                    ? content.themeToLightLabel
                    : content.themeToDarkLabel;
                themeToggle?.setAttribute('aria-label', label);
                themeToggle?.setAttribute('title', label);
            };

            const applyTheme = (theme, persist = false) => {
                const activeTheme = themes.includes(theme) ? theme : 'light';

                root.dataset.theme = activeTheme;
                root.style.colorScheme = activeTheme;
                themeColor?.setAttribute('content', activeTheme === 'dark' ? '#111214' : '#ffffff');
                updateThemeLabel(activeTheme);

                if (persist) {
                    storePreference(themeStorageKey, activeTheme);
                }
            };

            applyLocale(root.dataset.locale || 'en');
            applyTheme(root.dataset.theme || 'light');

            languageToggle?.addEventListener('click', () => {
                applyLocale(root.dataset.locale === 'zh' ? 'en' : 'zh', true);
            });

            themeToggle?.addEventListener('click', () => {
                applyTheme(root.dataset.theme === 'dark' ? 'light' : 'dark', true);
            });

            systemTheme?.addEventListener('change', (event) => {
                if (!readPreference(themeStorageKey, themes)) {
                    applyTheme(event.matches ? 'dark' : 'light');
                }
            });
        })();
    </script>
</body>
</html>
    <?php

    $html = (string) ob_get_clean();

    return rtrim($html) . PHP_EOL;
})();

$writtenBytes = file_put_contents(__DIR__ . '/index.html', $html);

if ($writtenBytes === false) {
    fwrite(STDERR, "Unable to write index.html\n");
    exit(1);
}

echo "Generated index.html ({$writtenBytes} bytes)\n";
