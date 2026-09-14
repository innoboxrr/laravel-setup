import { useCallback, useEffect, useRef } from 'react'
import JSValidator from 'innoboxrr-js-validator'
import t from 'innoboxrr-i18n'

// innoboxrr-js-validator trae sus mensajes sólo en español; aquí pasan por t()
// para seguir el idioma de la aplicación.
const messages = () => ({
    required: t('This field is required.'),
    email: t('Enter a valid email address.'),
    password_missing: t('There is no password field to compare with.'),
    password_mismatch: t('The passwords do not match.'),
})

/**
 * Validación en el navegador con los `validators` de cada campo, y los errores
 * de un 422 junto a su campo.
 */
export default function useValidator() {
    const form = useRef(null)
    const validator = useRef(null)

    useEffect(() => {
        if (! form.current) {
            return undefined
        }

        const instance = new JSValidator(form.current, { messages: messages() }).init()

        validator.current = instance

        return () => {
            instance.destroy()
            validator.current = null
        }
    }, [])

    /** @returns {boolean} si eran errores de validación y ya se muestran */
    const showServerErrors = useCallback((error) => {
        const errors = error?.response?.data?.errors

        if (error?.response?.status !== 422 || ! errors || ! validator.current) {
            return false
        }

        validator.current.reset()
        validator.current.appendExternalErrors(errors)

        return true
    }, [])

    const clear = useCallback(() => {
        validator.current?.reset()
    }, [])

    return { form, showServerErrors, clear }
}
