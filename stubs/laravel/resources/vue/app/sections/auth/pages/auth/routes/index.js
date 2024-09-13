import * as middleware from '@router/middleware'

export default [
	{
		path: 'login',
		name: "Login",
		component: () => import("./../views/LoginView.vue"),
		meta: {
			title: "Login",
			middleware: [
				middleware.guest
			]
		}
	},
	{
		path: 'register',
		name: "Register",
		component: () => import("./../views/RegisterView.vue"),
		meta: {
			title: "Register",
			middleware: [
				middleware.guest
			]
		}
	},
	{
		path: 'forgot-password',
		name: "ForgotPassword",
		component: () => import("./../views/ForgotPasswordView.vue"),
		meta: {
			title: "Forgot Password",
			middleware: [
				middleware.guest
			]
		}
	},
	{
		path: 'reset-password/:token/:email',
		name: "ResetPassword",
		component: () => import("./../views/ResetPasswordView.vue"),
		meta: {
			title: "Restablecer contraseña",
			middleware: [
				middleware.guest
			]
		}
	},
	{
		path: 'direct-reset-password/:token/:email',
		name: "DirectResetPassword",
		component: () => import("./../views/DirectResetPasswordView.vue"),
		meta: {
			title: "Direct Reset Password",
			middleware: [
				middleware.guest
			]
		}
	}
];