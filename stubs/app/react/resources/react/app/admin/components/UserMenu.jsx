import { useNavigate } from 'react-router-dom'
import t from 'innoboxrr-i18n'
import { IconComponent, MenuComponent } from 'innoboxrr-react-form-elements'

import UserAvatar from '../../components/UserAvatar.jsx'
import { useAuthStore } from '../../stores/auth.js'
import { useNotificationsStore } from '../../stores/notifications.js'

export default function UserMenu() {
    const user = useAuthStore((state) => state.user)
    const logout = useAuthStore((state) => state.logout)
    const navigate = useNavigate()

    const signOut = async () => {
        try {
            await logout()
        } catch {
            // Sin sesión en el servidor el resultado es el mismo: fuera.
        }

        useNotificationsStore.getState().reset()
        navigate('/', { replace: true })
    }

    const items = [
        { id: 'profile', label: t('Profile'), icon: 'mdi:account-circle-outline', action: () => navigate('/admin/profile') },
        { separator: true },
        { id: 'logout', label: t('Log out'), icon: 'logout', action: signOut },
    ]

    return (
        <MenuComponent
            items={items}
            label={t('User menu')}
            renderTrigger={({ toggle, loading, triggerProps }) => (
                <button type="button" className="app-user-trigger" {...triggerProps} disabled={loading} onClick={toggle}>
                    <UserAvatar user={user} />
                    <span className="app-user-name">{user?.name}</span>
                    <IconComponent name="down" size={10} className="app-user-caret" />
                </button>
            )} />
    )
}
