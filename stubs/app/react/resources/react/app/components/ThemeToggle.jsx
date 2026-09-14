import t from 'innoboxrr-i18n'
import { IconComponent } from 'innoboxrr-react-form-elements'

import { useIsDark, useUiStore } from '../stores/ui.js'

export default function ThemeToggle({ className = 'fe-icon-button' }) {
    const dark = useIsDark()
    const toggleTheme = useUiStore((state) => state.toggleTheme)

    return (
        <button
            type="button"
            className={className}
            aria-pressed={dark}
            aria-label={t('Dark mode')}
            title={dark ? t('Switch to light mode') : t('Switch to dark mode')}
            onClick={toggleTheme}>
            <IconComponent name={dark ? 'mdi:weather-sunny' : 'mdi:weather-night'} size={18} />
        </button>
    )
}
