import { createStore } from 'vuex'
import user from './modules/user.js'

const store = createStore({

	modules: {

		user: user,

	},

});


export default store;