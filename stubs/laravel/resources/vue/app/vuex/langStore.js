const getLangKey = (langCode) => `vuex-langs-${langCode}`;
const getLangExpiryKey = (langCode) => `vuex-langs-expiry-${langCode}`;
const LOCAL_STORAGE_LANG_KEY = 'vuex-lang';
const LOCAL_STORAGE_LANG_EXPIRY_KEY = 'vuex-lang-expiry';
const EXPIRY_TIME_MS = 24 * 60 * 60 * 1000; // 24 horas en milisegundos

const saveToLocalStorage = (key, data, expiryKey, expiryTime) => {
    const now = Date.now();
    localStorage.setItem(key, JSON.stringify(data));
    localStorage.setItem(expiryKey, now + expiryTime);
};

const loadFromLocalStorage = (key, expiryKey) => {
    const now = Date.now();
    const expiryTime = localStorage.getItem(expiryKey);

    if (expiryTime && now < expiryTime) {
        const data = localStorage.getItem(key);
        return data ? JSON.parse(data) : null;
    }
    return null;
};

export default {
    namespaced: true,

    state() {
        return {
            langs: [],
            lang: null, // Idioma actual del usuario
        };
    },

    getters: {
        getLangs(state) {
            return state.langs;
        },
        getLang(state) {
            return state.lang;
        },
    },

    mutations: {
        setLangs(state, langs) {
            state.langs = langs;
            const langCode = state.lang ? state.lang.code : 'default';
            const langKey = getLangKey(langCode);
            const langExpiryKey = getLangExpiryKey(langCode);
            saveToLocalStorage(langKey, langs, langExpiryKey, EXPIRY_TIME_MS);
        },
        setLang(state, lang) {
            state.lang = lang;
            saveToLocalStorage(LOCAL_STORAGE_LANG_KEY, lang, LOCAL_STORAGE_LANG_EXPIRY_KEY, EXPIRY_TIME_MS);
        },
    },

    actions: {
        async langSetup({ dispatch, state }) {
            await dispatch('fetchLangs');
            await dispatch('fetchUserLang');
        },

        async fetchLangs({ commit, state }) {
            const langCode = state.lang ? state.lang.code : 'default';
            const langKey = getLangKey(langCode);
            const langExpiryKey = getLangExpiryKey(langCode);

            const storedLangs = loadFromLocalStorage(langKey, langExpiryKey);
            if (storedLangs) {
                commit('setLangs', storedLangs);
            } else {
                let langs = await this.$httpRequest("get", route("api.language.index"), {
                    paginate: 0,
                    status: 1
                });
                commit("setLangs", langs);
            }
        },

        async fetchUserLang({ commit, state }) {
            const storedLang = loadFromLocalStorage(LOCAL_STORAGE_LANG_KEY, LOCAL_STORAGE_LANG_EXPIRY_KEY);
            if (storedLang) {
                commit('setLang', storedLang);
            } else {
                let lang = await this.$httpRequest("get", route("api.language.user"));
                if (lang) {
                    commit("setLang", lang);
                } else {
                    commit("setLang", state.langs[0]);
                }
            }
        },

        async setLang({ commit, dispatch }, { lang, refresh = false }) {
            let res = await this.$httpRequest("post", route("api.language.set"), {
                code: lang.code
            });
            if (res.status == 'success') {
                commit("setLang", res.language);
                await dispatch('fetchLangs'); // Actualiza los idiomas después de cambiar el idioma
            }
            if (refresh) {
                // Obtiene los parámetros de la URL actual
                const searchParams = new URLSearchParams(window.location.search);
                // Añade o actualiza el parámetro 'resetOptions' con el valor 'true'
                searchParams.set('resetOptions', 'true');
                // Redirige a la nueva URL con los parámetros incluidos
                location.href = location.origin + location.pathname + '?' + searchParams.toString();
            }            
        }
    },
};
