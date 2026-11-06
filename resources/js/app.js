import 'flowbite';

const THEME_KEY = 'theme';

/**
 * Apply the given theme to the document and sync the toggle icons.
 *
 * @param {boolean} isDark
 */
const applyTheme = (isDark) => {
    const root = document.documentElement;

    root.classList.toggle('dark', isDark);
    root.style.colorScheme = isDark ? 'dark' : 'light';

    document.querySelectorAll('[data-theme-toggle-icon="moon"]').forEach((icon) => {
        icon.classList.toggle('hidden', isDark);
    });

    document.querySelectorAll('[data-theme-toggle-icon="sun"]').forEach((icon) => {
        icon.classList.toggle('hidden', !isDark);
    });
};

const storedTheme = localStorage.getItem(THEME_KEY);
const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

applyTheme(storedTheme ? storedTheme === 'dark' : prefersDark);

document.addEventListener('DOMContentLoaded', () => {
    applyTheme(document.documentElement.classList.contains('dark'));

    document.querySelectorAll('[data-theme-toggle]').forEach((button) => {
        button.addEventListener('click', () => {
            const isDark = !document.documentElement.classList.contains('dark');

            localStorage.setItem(THEME_KEY, isDark ? 'dark' : 'light');
            applyTheme(isDark);
        });
    });
});
