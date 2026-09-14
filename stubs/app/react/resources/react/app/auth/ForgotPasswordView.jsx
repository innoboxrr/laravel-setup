import { useState } from 'react'
import { Link } from 'react-router-dom'
import t from 'innoboxrr-i18n'
import { notifyError } from 'innoboxrr-form-core'
import { TextInputComponent } from 'innoboxrr-react-form-elements'

import { errorMessage } from '../forms/errors.js'
import useValidator from '../forms/useValidator.js'
import { useAuthStore } from '../stores/auth.js'

export default function ForgotPasswordView() {
    const forgotPassword = useAuthStore((state) => state.forgotPassword)
    const { form, showServerErrors } = useValidator()

    const [email, setEmail] = useState('')
    const [status, setStatus] = useState(null)
    const [busy, setBusy] = useState(false)

    const submit = async (event) => {
        event.preventDefault()
        setBusy(true)

        try {
            const data = await forgotPassword({ email })

            // laravel-auth responde lo mismo exista o no la cuenta.
            setStatus(data?.message ?? t('If the address is registered, we have emailed a password reset link.'))
        } catch (error) {
            if (! showServerErrors(error)) {
                notifyError(errorMessage(error))
            }
        } finally {
            setBusy(false)
        }
    }

    return (
        <>
            <h1 className="app-auth-title">{t('Forgot your password?')}</h1>
            <p className="app-auth-lead">{t('Enter your email and we will send you a link to choose a new one.')}</p>

            {status ? <p className="app-status" role="status">{status}</p> : null}

            <form ref={form} onSubmit={submit} noValidate>
                <TextInputComponent label={t('Email')} name="email" type="email" autoComplete="email" validators="required email" value={email} onChange={setEmail} />

                <button type="submit" className="fe-button app-block" disabled={busy}>
                    {busy ? t('Sending…') : t('Send the link')}
                </button>
            </form>

            <p className="app-auth-links">
                <Link to="/auth/login">{t('Back to log in')}</Link>
            </p>
        </>
    )
}
