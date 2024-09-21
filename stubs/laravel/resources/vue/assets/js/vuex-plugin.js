import { mt, translateModel } from '@js/utils.js';

const VuexPlugin = store => {
    store.$mt = mt;
    store.$translateModel = translateModel;
};

export default VuexPlugin;