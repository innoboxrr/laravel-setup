import { useState } from 'react'
import { Link, useNavigate, useSearchParams } from 'react-router-dom'
import t from 'innoboxrr-i18n'
import { notifyError } from 'innoboxrr-form-core'
import { TextInputComponent } from 'innoboxrr-react-form-elements'

import { errorMessage } from '../forms/errors.js'
import useValidator from '../forms/useValidator.js'
import { safeRedirect } from '../router/guards.js'
import { useAuthStore } from '../stores/auth.js'

export default function RegisterView() {
    const register = useAuthStore((state) => state.register)
    const navigate = useNavigate()
    const [params] = useSearchParams()
    const { form, showServerErrors } = useValidator()

    const [values, setValues] = useState({ name: '', email: '', password: '', password_confirmation: '' })
    const [busy, setBusy] = useState(false)
    const [closed, setClosed] = useState(false)

    const field = (name) => (value) => setValues((current) => ({ ...current, [name]: value }))

    const submit = async (event) => {
        event.preventDefault()
        setBusy(true)

        try {
            await register(values)

            navigate(safeRedirect(params.get('redirect')), { replace: true })
        } catch (error) {
            // laravel-auth responde 403 cuando `allow-registration` está apagado.
            if (error?.response?.status === 403) {
                setClosed(true)
            } else if (! showServerErrors(error)) {
                notifyError(errorMessage(error))
            }
        } finally {
            setBusy(false)
        }
    }

    const passwordLabels = { showPasswordLabel: t('Show password'), hidePasswordLabel: t('Hide password') }

    return (
        <>
            <h1 className="app-auth-title">{t('Create an account')}</h1>
            <p className="app-auth-lead">{t('It only takes a minute.')}</p>

            {closed ? <p className="app-banner app-banner-danger" role="alert">{t('New accounts are not being accepted right now.')}</p> : null}

            <form ref={form} onSubmit={submit} noValidate>
                <TextInputComponent label={t('Name')} name="name" type="text" autoComplete="name" validators="required" value={values.name} onChange={field('name')} />

                <TextInputComponent label={t('Email')} name="email" type="email" autoComplete="email" validators="required email" value={values.email} onChange={field('email')} />

                <TextInputComponent label={t('Password')} name="password" type="password" autoComplete="new-password" validators="required" {...passwordLabels} value={values.password} onChange={field('password')} />

                <TextInputComponent label={t('Confirm password')} name="password_confirmation" type="password" autoComplete="new-password" validators="required password_confirmation" {...passwordLabels} value={values.password_confirmation} onChange={field('password_confirmation')} />

                <button type="submit" className="fe-button app-block" disabled={busy}>
                    {busy ? t('Creating your account…') : t('Create account')}
                </button>
            </form>

            <p className="app-auth-links">
                <span>{t('Already have an account?')} <Link to={{ pathname: '/auth/login', search: params.toString() ? `?${params}` : '' }}>{t('Log in')}</Link></span>
            </p>
        </>
    )
}
