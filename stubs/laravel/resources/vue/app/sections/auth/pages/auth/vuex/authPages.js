export default {

	namespaced: true,

	state() {

		return {

			formErrors: [],

			user: null,

			isAuth: false,

			isConfirm: false,

			userRoles: [],

			isAdmin: false,

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

			return state.userRoles.includes('admin');

		},

		isGuest(state) {

			return state.userRoles.includes('guest');

		},

	},

	mutations: {

		clearFormErrors(state) {

			state.formErrors = [];

		},

		setUser(state, user) {

			state.isAuth = user !== null;

			state.isConfirm = user !== null && user.email_verified_at !== null;

			state.user = user;

			state.userRoles = user !== null ? user.roles.map(role => role.name) : [];

		}
	},

	actions: {

		async checkAuth({ commit }) {

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

				await this.$httpRequest('POST', route('auth.register'), data);

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

		}

	}

}
