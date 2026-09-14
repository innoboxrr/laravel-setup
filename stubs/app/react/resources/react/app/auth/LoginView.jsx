import { useState } from 'react'
import { Link, useNavigate, useSearchParams } from 'react-router-dom'
import t from 'innoboxrr-i18n'
import { notifyError } from 'innoboxrr-form-core'
import { TextInputComponent } from 'innoboxrr-react-form-elements'

import { errorMessage } from '../forms/errors.js'
import useValidator from '../forms/useValidator.js'
import { safeRedirect } from '../router/guards.js'
import { useAuthStore } from '../stores/auth.js'

export default function LoginView() {
    const login = useAuthStore((state) => state.login)
    const navigate = useNavigate()
    const [params] = useSearchParams()
    const { form, showServerErrors } = useValidator()

    const [values, setValues] = useState({ email: '', password: '', remember: false })
    const [busy, setBusy] = useState(false)

    const field = (name) => (value) => setValues((current) => ({ ...current, [name]: value }))

    const submit = async (event) => {
        event.preventDefault()
        setBusy(true)

        try {
            await login(values)

            navigate(safeRedirect(params.get('redirect')), { replace: true })
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
            <h1 className="app-auth-title">{t('Log in')}</h1>
            <p className="app-auth-lead">{t('Enter your email and password to continue.')}</p>

            <form ref={form} onSubmit={submit} noValidate>
                <TextInputComponent
                    label={t('Email')}
                    name="email"
                    type="email"
                    autoComplete="email"
                    validators="required email"
                    value={values.email}
                    onChange={field('email')} />

                <TextInputComponent
                    label={t('Password')}
                    name="password"
                    type="password"
                    autoComplete="current-password"
                    validators="required"
                    showPasswordLabel={t('Show password')}
                    hidePasswordLabel={t('Hide password')}
                    value={values.password}
                    onChange={field('password')} />

                <label className="app-check">
                    <input
                        type="checkbox"
                        className="fe-checkbox"
                        name="remember"
                        checked={values.remember}
                        onChange={(event) => field('remember')(event.target.checked)} />
                    {t('Remember me')}
                </label>

                <button type="submit" className="fe-button app-block" disabled={busy}>
                    {busy ? t('Logging in…') : t('Log in')}
                </button>
            </form>

            <p className="app-auth-links">
                <Link to="/auth/forgot-password">{t('Forgot your password?')}</Link>
                <Link to="/auth/register">{t('Create an account')}</Link>
            </p>
        </>
    )
}
