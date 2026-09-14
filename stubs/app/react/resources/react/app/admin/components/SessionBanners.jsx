import { useState } from 'react'
import { useNavigate } from 'react-router-dom'
import t from 'innoboxrr-i18n'
import { notifyError, notifySuccess } from 'innoboxrr-form-core'

import { errorMessage } from '../../forms/errors.js'
import { useAuthStore } from '../../stores/auth.js'

export function ImpersonationBanner() {
    const impersonating = useAuthStore((state) => state.impersonating)
    const user = useAuthStore((state) => state.user)
    const revertImpersonation = useAuthStore((state) => state.revertImpersonation)
    const navigate = useNavigate()
    const [busy, setBusy] = useState(false)

    if (! impersonating) {
        return null
    }

    const revert = async () => {
        setBusy(true)

        try {
            await revertImpersonation()
            navigate('/admin', { replace: true })
        } catch (error) {
            notifyError(errorMessage(error))
        } finally {
            setBusy(false)
        }
    }

    return (
        <div className="app-banner app-banner-warning" role="status">
            <p>{t('You are viewing the account of :name.', { name: user?.name ?? user?.email ?? '' })}</p>

            <button type="button" className="fe-button-secondary" disabled={busy} onClick={revert}>
                {t('Back to my account')}
            </button>
        </div>
    )
}

export function VerificationBanner() {
    const authenticated = useAuthStore((state) => state.authenticated)
    const verified = useAuthStore((state) => state.verified)
    const resendVerification = useAuthStore((state) => state.resendVerification)
    const load = useAuthStore((state) => state.load)
    const [busy, setBusy] = useState(false)

    if (! authenticated || verified !== false) {
        return null
    }

    const resend = async () => {
        setBusy(true)

        try {
            const data = await resendVerification()

            if (data?.status === 'already-verified') {
                await load()
            } else {
                notifySuccess(t('We have sent you a new verification link.'))
            }
        } catch (error) {
            notifyError(errorMessage(error))
        } finally {
            setBusy(false)
        }
    }

    return (
        <div className="app-banner" role="status">
            <p>{t('Your email address is not verified yet. Check your inbox.')}</p>

            <button type="button" className="fe-button-secondary" disabled={busy} onClick={resend}>
                {t('Resend the verification email')}
            </button>
        </div>
    )
}
