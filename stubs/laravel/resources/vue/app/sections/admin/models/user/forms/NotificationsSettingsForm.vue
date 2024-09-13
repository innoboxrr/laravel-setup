<template>
    <form :id="formId" @submit.prevent="onSubmit">
        <!-- Un array con todos los tipos de notificaciones que se pueden configurar -->
        <div 
            v-for="notification in filteredNotifications" 
            :key="notification.name" 
            class="mb-4">
            <SwitchGroup 
                as="div" 
                class="flex items-center justify-between">
                <span class="flex flex-grow flex-col">
                    <SwitchLabel 
                        as="span" 
                        class="text-sm font-medium leading-6 text-gray-900 dark:text-white">
                        {{ notification.label }}
                    </SwitchLabel>
                    <SwitchDescription 
                        as="span" 
                        class="text-sm text-gray-500 dark:text-gray-300">
                        {{ notification.description }}
                    </SwitchDescription>
                </span>
                <Switch 
                    v-model="user.payload.notifications_settings[notification.name]" 
                    :class="[
                        user.payload.notifications_settings[notification.name] ? 'bg-indigo-600' : 'bg-gray-200', 
                        'relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2'
                    ]">
                    <span 
                        aria-hidden="true" 
                        :class="[
                            user.payload.notifications_settings[notification.name] ? 'translate-x-5' : 'translate-x-0', 
                            'pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out'
                        ]" />
                </Switch>
            </SwitchGroup>
        </div>
        
        <button-component
            :custom-class="buttonClass"
            :disabled="disabled"
            :value="__('Update')" />
    </form>
</template>
<script>
    import { showModel, updateModel } from '@models/user'
    import JSValidator from 'innoboxrr-js-validator'
    import {
        TextInputComponent,
        ButtonComponent,
        ModelSearchInputComponent
    } from 'innoboxrr-form-elements'
    import { Switch, SwitchDescription, SwitchGroup, SwitchLabel } from '@headlessui/vue'

    export default {
        components: {
            TextInputComponent,
            ButtonComponent,
            ModelSearchInputComponent,
            Switch,
            SwitchDescription,
            SwitchGroup,
            SwitchLabel
        },
        props: {
            formId: {
                type: String,
                default: 'updateNotificationsSettingsForm'
            },
            userId: {
                type: [Number, String],
                required: true
            },
        },
        emits: ['submit'],
        data() {
            return {
                notifications: [
                    { 
                        name: 'cart_checkout_notification', 
                        label: this.__('Cart Checkout Notification'),  
                        description: this.__('Receive a notification when a cart is checked out.'),
                        roles: ['admin', 'teacher', 'student']
                    },
                    { 
                        name: 'cart_checkout_admin_notification', 
                        label: this.__('Cart Checkout Admin Notification'), 
                        description: this.__('Receive a notification when a cart is checked out.'),
                        roles: ['admin']
                    },
                    { 
                        name: 'complete_attempt_notification', 
                        label: this.__('Complete Attempt Notification'), 
                        description: this.__('Receive a notification for complete attempts.'),
                        roles: ['admin', 'teacher', 'student']
                    },
                    { 
                        name: 'complete_attempt_teacher_notification', 
                        label: this.__('Complete Attempt Teacher Notification'), 
                        description: this.__('Receive a notification for complete attempts by a teacher.'),
                        roles: ['teacher'] 
                    },
                    { 
                        name: 'benefit_assignment_notification', 
                        label: this.__('Benefit Assignment Notification'), 
                        description: this.__('Receive a notification for benefit assignments.'),
                        roles: ['admin', 'teacher', 'student']
                    },
                    { 
                        name: 'reminder_cart_notification', 
                        label: this.__('Reminder Cart Notification'), 
                        description: this.__('Receive a reminder for cart.'),
                        roles: ['admin', 'teacher', 'student']
                    },
                    { 
                        name: 'certificate_assignment_notification', 
                        label: this.__('Certificate Assignment Notification'), 
                        description: this.__('Receive a notification for certificate assignments.'),
                        roles: ['admin', 'teacher', 'student']
                    },
                    { 
                        name: 'certificate_assignment_teacher_notification', 
                        label: this.__('Certificate Assignment Teacher Notification'), 
                        description: this.__('Receive a notification for certificate assignments by a teacher.'),
                        roles: ['teacher']
                    },
                    { 
                        name: 'new_comment_notification', 
                        label: this.__('New Comment Notification'), 
                        description: this.__('Receive a notification for new comments.'),
                        roles: ['admin', 'teacher', 'student']
                    },
                    { 
                        name: 'new_comment_teacher_notification', 
                        label: this.__('New Comment Teacher Notification'), 
                        description: this.__('Receive a notification for new comments by a teacher.'),
                        roles: ['teacher']
                    },
                    { 
                        name: 'comment_reply_notification', 
                        label: this.__('Comment Reply Notification'), 
                        description: this.__('Receive a notification for comment replies.'),
                        roles: ['admin', 'teacher', 'student']
                    },
                    { 
                        name: 'comment_reply_teacher_notification', 
                        label: this.__('Comment Reply Teacher Notification'), 
                        description: this.__('Receive a notification for comment replies by a teacher.'),
                        roles: ['teacher']
                    },
                    { 
                        name: 'new_conversation_notification', 
                        label: this.__('New Conversation Notification'), 
                        description: this.__('Receive a notification for new conversations.'),
                        roles: ['admin', 'teacher', 'student']
                    },
                    { 
                        name: 'new_conversation_message_notification', 
                        label: this.__('New Conversation Message Notification'), 
                        description: this.__('Receive a notification for new conversation messages.'),
                        roles: ['admin', 'teacher', 'student']
                    },
                    { 
                        name: 'coupon_applied_admin_notification', 
                        label: this.__('Applied Coupon Admin Notification'), 
                        description: this.__('Receive a notification for applied coupons.'),
                        roles: ['admin']
                    },
                    { 
                        name: 'course_notification', 
                        label: this.__('Course Notifications'), 
                        description: this.__('Receive general course notifications.'),
                        roles: ['admin', 'teacher', 'student'] 
                    },
                    { 
                        name: 'enrollment_teacher_notification', 
                        label: this.__('Enrollment Teacher Notification'), 
                        description: this.__('Receive a notification for teacher enrollments.'),
                        roles: ['teacher']
                    },
                    { 
                        name: 'enrollment_admin_notification', 
                        label: this.__('Enrollment Admin Notification'), 
                        description: this.__('Receive a notification for admin enrollments.'),
                        roles: ['admin']
                    },
                    { 
                        name: 'enrollment_student_notification', 
                        label: this.__('Enrollment Student Notification'), 
                        description: this.__('Receive a notification for student enrollments.'),
                        roles: ['student']
                    },
                    { 
                        name: 'enrollment_expired_notification', 
                        label: this.__('Enrollment Expired Notification'), 
                        description: this.__('Receive a notification for expired enrollments.'),
                        roles: ['admin', 'teacher', 'student'] 
                    },
                    { 
                        name: 'enrollment_expired_teacher_notification', 
                        label: this.__('Enrollment Expired Teacher Notification'), 
                        description: this.__('Receive a notification for expired enrollments by a teacher.'),
                        roles: ['teacher'] 
                    },
                    { 
                        name: 'enrollment_expired_admin_notification', 
                        label: this.__('Enrollment Expired Admin Notification'), 
                        description: this.__('Receive a notification for expired enrollments by an admin.'),
                        roles: ['admin'] 
                    },
                ],
                user: {
                    payload: {
                        notifications_settings: {},
                    }
                },
                userRoles: [],
                disabled: false,
                JSValidator: undefined,
            }
        },
        mounted() {
            this.fetchUser();
            this.JSValidator = new JSValidator(this.formId).init();
            this.JSValidator.status = true;
        },
        computed: {
            filteredNotifications() {
                return this.notifications.filter(notification => {
                    return notification.roles.some(role => this.userRoles.includes(role));
                });
            }
        },
        methods: {
            async fetchUser() {
                this.user = await showModel(this.userId);
                if (this.user.payload.notifications_settings == null) {
                    this.user.payload.notifications_settings = {
                        cart_checkout_notification: true,
                        cart_checkout_admin_notification: false,
                        complete_attempt_notification: false,
                        complete_attempt_teacher_notification: false,
                        benefit_assignment_notification: false,
                        reminder_cart_notification: false,
                        certificate_assignment_notification: false,
                        certificate_assignment_teacher_notification: false,
                        new_comment_notification: false,
                        new_comment_teacher_notification: false,
                        comment_reply_notification: false,
                        comment_reply_teacher_notification: false,
                        new_conversation_notification: false,
                        new_conversation_message_notification: false,
                        coupon_applied_admin_notification: false,
                        course_notification: false,
                        enrollment_teacher_notification: false,
                        enrollment_admin_notification: false,
                        enrollment_student_notification: false,
                        enrollment_expired_notification: false,
                        enrollment_expired_teacher_notification: false,
                        enrollment_expired_admin_notification: false,
                    };
                } else {
                    this.user.payload.notifications_settings = JSON.parse(this.user.payload.notifications_settings);
                }
                // Get user roles
                this.userRoles = this.user.roles.map(role => role.slug);
            },
            onSubmit() {
                if (this.JSValidator.status) {
                    this.disabled = true;
                    updateModel(this.user.id, {
                        notifications_settings: this.user.payload.notifications_settings
                    }).then(res => {
                        this.$emit('submit', res);
                        this.alert('success');
                        setTimeout(() => { this.disabled = false; }, 2500);
                    }).catch(error => {
                        this.disabled = false;
                        if (error?.response?.status == 422)
                            this.JSValidator.appendExternalErrors(error.response.data.errors);
                    });
                } else {
                    this.disabled = false;
                }
            }
        }
    }
</script>