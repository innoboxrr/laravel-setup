import { createStore } from "vuex";
import { VuexHttpRequestPlugin } from "innoboxrr-http-request";
import VuexPlugin from '@js/vuex-plugin.js';

// Como importar de manera dinpamica los módulos de la app, al igual que hicimos con las rutas

const store = createStore({
    plugins: [
        VuexHttpRequestPlugin,
        VuexPlugin
    ],
});

const files = import.meta.glob("/resources/vue/**/vuex/*.js", { eager: true });

Object.keys(files).forEach((filePath) => {
    const moduleDefinition = files[filePath].default;
    const moduleName = filePath.match(/\/vuex\/(.*?)\.js$/)[1];
    store.registerModule(moduleName, moduleDefinition);
});

export default store;
