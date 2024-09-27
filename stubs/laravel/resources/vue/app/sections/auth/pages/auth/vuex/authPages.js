import isAuthHelper from '@router/middleware/utils/isAuth.js';

export default {

	namespaced: true,

	state() {

		return {
			formErrors: [],
			user: null,
			isAuth: isAuthHelper(),
			isConfirm: false,
			userRoles: [],
			roles: [],
			permissions: [],
			isAdmin: false,
			isTeacher: false,
			isEditTeacher: false,
			isHeadTeacher: false,
			isStudent: false,
			isGuest: true,
		}
	},

	getters: {

		formErrors(state) {
			return state.formErrors;
		},

		user(state) {
			return state.user;
		},

		userId(state) {
			return (state.user !== null) ? state.user.id : null;
		},

		userName(state) {
			return (state.user !== null) ? state.user.name : null;
		},

		userAvatar(state) {
			return (state.user !== null) ? state.user.avatar_url : null;
		},

		isAuth(state) {
			return state.isAuth;
		},

		isConfirm(state) {
			return state.isConfirm;
		},

		isAdmin(state) {
			return state.userRoles.includes('admin') || state.user?.id === 1;
		},

		isTeacher(state) {
			return state.userRoles.includes('teacher');
		},

		isEditTeacher(state) {
			return state.userRoles.includes('edit-teacher');
		},

		isHeadTeacher(state) {
			return state.userRoles.includes('head-teacher');
		},

		isStudent(state) {
			return state.userRoles.includes('student');
		},

		isGuest(state) {
			return state.userRoles.includes('guest');
		},

		hasRole: (state) => (role) => {
			return state.userRoles.includes(role);
		},

		hasRoles: (state) => (roles) => {
			return roles.some(role => state.userRoles.includes(role));
		},

		can: (state) => (permission, roles = null) => {
			if (state.user === null) {
				return false;
			}
			if(state.userRoles.includes('admin') || state.user?.id === 1) {
				return true;
			}
			if (roles === null) {
				return state.permissions.find(p => {
					return p.slug === permission;
				});
			}
			if (Array.isArray(roles)) {
				return state.user.permissions.find(p => p.slug === permission) && roles.some(role => state.userRoles.includes(role));
			}
			if (typeof roles === 'string') {
				return state.user.permissions.find(p => p.slug === permission) && state.userRoles.includes(roles);
			}
		}

	},

	mutations: {

		clearFormErrors(state) {
			state.formErrors = [];
		},

		setUser(state, user) {
			state.isAuth = user !== undefined;
			state.isConfirm = user !== undefined && user.email_verified_at !== undefined;
			state.user = user;
			state.userRoles = user !== undefined ? user.roles.map(role => role.name) : ['student'];
			state.roles = user !== undefined ? user.roles : [];
			state.permissions = user !== undefined ? user.permissions : [];
		}
	},

	actions: {

		async checkAuth({ commit, getters }) {
			try {
				await this.$httpRequest('GET', '/sanctum/csrf-cookie');
				let response = await this.$httpRequest('GET', route('auth.get.auth'));
				commit('setUser', response.user);
			} catch (error) {
				console.log(error);
			}
		},

		async login({ state, commit }, data) {
			commit('clearFormErrors');
			try {		
				await this.$httpRequest('POST', route('auth.login'), data);
				window.location.href = data.redirect ?? '/admin';
			} catch (error) {
				state.formErrors = error?.response?.data?.errors;
			}
		},

		async register({ state, commit }, data) {
			commit('clearFormErrors');
			try {
				let res = await this.$httpRequest('POST', route('auth.register'), data);
				await this.$sendEvent('sign_up', {});
				window.location.href = data.redirect ?? '/admin';
			} catch (error) {
				state.formErrors = error?.response?.data?.errors;
			}
		},

		async logout({ commit }) {
			try {
				await this.$httpRequest('POST', route('auth.logout'));
				window.location.href = '/';
			} catch (error) {
				console.log(error);
			}
		},

		async forgotPassword({ state, commit }, data) {
			commit('clearFormErrors');
			try {
				await this.$httpRequest('POST', route('auth.forgot.password'), data);
				return true;
			} catch (error) {
				state.formErrors = error?.response?.data?.errors;
			}
		},

		async resetPassword({ state, commit }, data) {
			commit('clearFormErrors');
			try {
				await this.$httpRequest('POST', route('auth.reset.password'), data);
				window.location.href = '/auth';
			} catch (error) {
				state.formErrors = error?.response?.data?.errors;
			}
		},

		async directResetPassword({ state, commit }, data) {
			commit('clearFormErrors');
			try {
				await this.$httpRequest('POST', route('api.user.direct.reset.password.link'), data);
				window.location.href = '/auth';
			} catch (error) {
				state.formErrors = error?.response?.data?.errors;
			}
		},

		async emailVerificationNotification({ state, commit }, data) {
			commit('clearFormErrors');
			try {
				await this.$httpRequest('POST', route('auth.email.verification.notification'), data);
				return true;
			} catch (error) {
				state.formErrors = error?.response?.data?.errors;
			}
		},
	}
}
