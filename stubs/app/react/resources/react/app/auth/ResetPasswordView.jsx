import { useState } from 'react'
import { Link, useNavigate, useParams } from 'react-router-dom'
import t from 'innoboxrr-i18n'
import { notifyError, notifySuccess } from 'innoboxrr-form-core'
import { TextInputComponent } from 'innoboxrr-react-form-elements'

import { errorMessage } from '../forms/errors.js'
import useValidator from '../forms/useValidator.js'
import { useAuthStore } from '../stores/auth.js'

/**
 * La pantalla a la que lleva el correo de laravel-auth:
 * `auth/reset-password/{token}/{email}`, con el correo codificado para URL.
 */
export default function ResetPasswordView() {
    const params = useParams()
    const resetPassword = useAuthStore((state) => state.resetPassword)
    const navigate = useNavigate()
    const { form, showServerErrors } = useValidator()

    const [values, setValues] = useState({ email: params.email ?? '', password: '', password_confirmation: '' })
    const [busy, setBusy] = useState(false)

    const field = (name) => (value) => setValues((current) => ({ ...current, [name]: value }))

    const submit = async (event) => {
        event.preventDefault()
        setBusy(true)

        try {
            const data = await resetPassword({ token: params.token, ...values })

            notifySuccess(data?.message ?? t('Your password has been reset.'))
            navigate('/auth/login', { replace: true })
        } catch (error) {
            if (! showServerErrors(error)) {
                notifyError(errorMessage(error))
            }
        } finally {
            setBusy(false)
        }
    }

    const passwordLabels = { showPasswordLabel: t('Show password'), hidePasswordLabel: t('Hide password') }

    return (
        <>
            <h1 className="app-auth-title">{t('Choose a new password')}</h1>
            <p className="app-auth-lead">{t('Use at least 8 characters.')}</p>

            <form ref={form} onSubmit={submit} noValidate>
                <TextInputComponent label={t('Email')} name="email" type="email" autoComplete="email" validators="required email" value={values.email} onChange={field('email')} />

                <TextInputComponent label={t('New password')} name="password" type="password" autoComplete="new-password" validators="required" {...passwordLabels} value={values.password} onChange={field('password')} />

                <TextInputComponent label={t('Confirm password')} name="password_confirmation" type="password" autoComplete="new-password" validators="required password_confirmation" {...passwordLabels} value={values.password_confirmation} onChange={field('password_confirmation')} />

                <button type="submit" className="fe-button app-block" disabled={busy}>
                    {busy ? t('Saving…') : t('Save the new password')}
                </button>
            </form>

            <p className="app-auth-links">
                <Link to="/auth/login">{t('Back to log in')}</Link>
            </p>
        </>
    )
}
