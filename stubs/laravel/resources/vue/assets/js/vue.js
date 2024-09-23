// VUE
import { createApp } from 'vue'
import App from '@app/App.vue'
import router from '@router'
import store from '@store'
import mixin from '@js/mixin.js'
import { VueHttpRequestPlugin } from 'innoboxrr-http-request'
import { globalComponentRegistration } from '@js/global-components.js'
import { globalDirectivesRegistration } from '@js/global-directives.js'
import { globalPropertiesRegistration } from '@js/global-properties.js'

// Vue App
window.app = createApp(App);
app.use(router);
app.use(store);
app.mixin(mixin);
app.use(VueHttpRequestPlugin);

// Registro Global de componentes
globalComponentRegistration(app);
globalDirectivesRegistration(app);
globalPropertiesRegistration(app, store);

// Vue Model

window.vm = app.mount('#app');
