import { onBeforeUnmount, onMounted, ref } from 'vue'
import JSValidator from 'innoboxrr-js-validator'
import t from 'innoboxrr-i18n'
import { errorMessage, validationErrors } from '@app/http.js'

export function validatorMessages() {
    return {
        required: t('This field is required.'),
        email: t('Enter a valid email address.'),
        password_mismatch: t('The passwords do not match.'),
        password_missing: t('The password field is missing.'),
    }
}

/**
 * Un formulario validado con js-validator antes de enviar, y con los errores
 * de un 422 escritos debajo de cada campo.
 *
 * `statusMessages` cambia el aviso general de un estado concreto: un 403 al
 * registrarse no es "no tienes permiso", es que el registro está cerrado.
 */
export function useValidatedForm(submit, { statusMessages = {} } = {}) {
    const form = ref(null)
    const busy = ref(false)
    const error = ref('')

    let validator = null

    onMounted(() => {
        if (form.value) {
            validator = new JSValidator(form.value, { messages: validatorMessages() })
        }
    })

    onBeforeUnmount(() => {
        validator?.destroy()
        validator = null
    })

    const focusFirstInvalid = () => form.value?.querySelector('[aria-invalid="true"]')?.focus()

    const resetErrors = () => {
        validator?.reset()
        error.value = ''
    }

    const handleSubmit = async () => {
        if (busy.value) {
            return undefined
        }

        error.value = ''

        if (validator) {
            validator.refresh()

            if (! validator.validate()) {
                focusFirstInvalid()

                return undefined
            }
        }

        busy.value = true

        try {
            return await submit({ setError: (message) => { error.value = message } })
        } catch (exception) {
            const fields = validationErrors(exception)
            const status = exception?.response?.status

            if (fields && validator) {
                validator.reset()
                validator.appendExternalErrors(fields)
                focusFirstInvalid()
            } else if (fields) {
                error.value = String(Object.values(fields).flat()[0] ?? errorMessage(exception, t))
            } else {
                error.value = statusMessages[status] ?? errorMessage(exception, t)
            }

            return undefined
        } finally {
            busy.value = false
        }
    }

    return { form, busy, error, handleSubmit, resetErrors }
}
