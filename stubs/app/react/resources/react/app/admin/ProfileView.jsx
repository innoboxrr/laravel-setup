import { useRef, useState } from 'react'
import t from 'innoboxrr-i18n'
import { notifyError, notifySuccess } from 'innoboxrr-form-core'
import { IconComponent, TextInputComponent } from 'innoboxrr-react-form-elements'

import UserAvatar from '../components/UserAvatar.jsx'
import { errorMessage } from '../forms/errors.js'
import useValidator from '../forms/useValidator.js'
import { avatarOf, useAuthStore } from '../stores/auth.js'

function AvatarCard() {
    const user = useAuthStore((state) => state.user)
    const updateAvatar = useAuthStore((state) => state.updateAvatar)
    const removeAvatar = useAuthStore((state) => state.removeAvatar)
    const input = useRef(null)
    const [busy, setBusy] = useState(false)

    const remove = async () => {
        setBusy(true)

        try {
            await removeAvatar()
            notifySuccess(t('Your picture has been removed.'))
        } catch (error) {
            notifyError(errorMessage(error))
        } finally {
            setBusy(false)
        }
    }

    const pick = async (event) => {
        const file = event.target.files?.[0]

        event.target.value = ''

        if (! file) {
            return
        }

        if (! file.type.startsWith('image/')) {
            notifyError(t('Choose an image file.'))

            return
        }

        setBusy(true)

        try {
            await updateAvatar(file)
            notifySuccess(t('Your picture has been updated.'))
        } catch (error) {
            notifyError(errorMessage(error))
        } finally {
            setBusy(false)
        }
    }

    return (
        <section className="fe-card" aria-labelledby="profile-avatar-title">
            <div className="fe-card-body app-avatar-card">
                <h2 id="profile-avatar-title" className="app-section-title">{t('Picture')}</h2>

                <UserAvatar user={user} size="lg" alt={t('Your picture')} />

                <input ref={input} type="file" accept="image/*" className="app-sr-only" tabIndex={-1} aria-hidden="true" onChange={pick} />

                <button type="button" className="fe-button-secondary" disabled={busy} aria-busy={busy} onClick={() => input.current?.click()}>
                    <IconComponent name="upload" size={12} />
                    {busy ? t('Uploading…') : t('Change picture')}
                </button>

                {avatarOf(user) ? (
                    <button type="button" className="fe-button-link" disabled={busy} onClick={remove}>
                        {t('Remove picture')}
                    </button>
                ) : null}
            </div>
        </section>
    )
}

function AccountForm() {
    const user = useAuthStore((state) => state.user)
    const updateProfile = useAuthStore((state) => state.updateProfile)
    const { form, showServerErrors, clear } = useValidator()
    const [values, setValues] = useState({ name: user?.name ?? '', email: user?.email ?? '' })
    const [busy, setBusy] = useState(false)

    const field = (name) => (value) => setValues((current) => ({ ...current, [name]: value }))

    const submit = async (event) => {
        event.preventDefault()
        setBusy(true)

        try {
            await updateProfile(values)
            clear()
            notifySuccess(t('Your profile has been updated.'))
        } catch (error) {
            if (! showServerErrors(error)) {
                notifyError(errorMessage(error))
            }
        } finally {
            setBusy(false)
        }
    }

    return (
        <section className="fe-card" aria-labelledby="profile-account-title">
            <form ref={form} className="fe-card-body" onSubmit={submit} noValidate>
                <h2 id="profile-account-title" className="app-section-title">{t('Account')}</h2>

                <TextInputComponent label={t('Name')} name="name" type="text" autoComplete="name" validators="required" value={values.name} onChange={field('name')} />

                <TextInputComponent label={t('Email')} name="email" type="email" autoComplete="email" validators="required email" value={values.email} onChange={field('email')} />

                <div className="app-form-actions">
                    <button type="submit" className="fe-button" disabled={busy}>{busy ? t('Saving…') : t('Save')}</button>
                </div>
            </form>
        </section>
    )
}

function PasswordForm() {
    const updatePassword = useAuthStore((state) => state.updatePassword)
    const { form, showServerErrors, clear } = useValidator()
    const empty = { old_password: '', password: '', password_confirmation: '' }
    const [values, setValues] = useState(empty)
    const [busy, setBusy] = useState(false)

    const field = (name) => (value) => setValues((current) => ({ ...current, [name]: value }))

    const submit = async (event) => {
        event.preventDefault()
        setBusy(true)

        try {
            const data = await updatePassword(values)

            setValues(empty)
            clear()
            notifySuccess(data?.message ?? t('Your password has been updated.'))
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
        <section className="fe-card" aria-labelledby="profile-password-title">
            <form ref={form} className="fe-card-body" onSubmit={submit} noValidate>
                <h2 id="profile-password-title" className="app-section-title">{t('Password')}</h2>

                <TextInputComponent label={t('Current password')} name="old_password" type="password" autoComplete="current-password" validators="required" {...passwordLabels} value={values.old_password} onChange={field('old_password')} />

                <TextInputComponent label={t('New password')} name="password" type="password" autoComplete="new-password" validators="required" {...passwordLabels} value={values.password} onChange={field('password')} />

                <TextInputComponent label={t('Confirm password')} name="password_confirmation" type="password" autoComplete="new-password" validators="required password_confirmation" {...passwordLabels} value={values.password_confirmation} onChange={field('password_confirmation')} />

                <div className="app-form-actions">
                    <button type="submit" className="fe-button" disabled={busy}>{busy ? t('Saving…') : t('Change password')}</button>
                </div>
            </form>
        </section>
    )
}

export default function ProfileView() {
    const userId = useAuthStore((state) => state.user?.id)

    return (
        <div className="app-page">
            <header className="app-page-header">
                <div>
                    <h1 className="app-page-title">{t('Profile')}</h1>
                    <p className="app-page-subtitle">{t('Your name, email, picture and password.')}</p>
                </div>
            </header>

            <div className="app-profile-grid">
                <AvatarCard />

                <div className="app-profile-forms">
                    {/* Tras suplantar o volver, el formulario empieza con los datos de la otra cuenta. */}
                    <AccountForm key={userId ?? 'none'} />
                    <PasswordForm />
                </div>
            </div>
        </div>
    )
}
