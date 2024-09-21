import { setPageTitle } from './utils.js';
import { pixelService } from './events.js';

export const globalPropertiesRegistration = (app, store) => {
	app.config.globalProperties.$setPageTitle = setPageTitle;
    store.$setPageTitle = setPageTitle;

    app.config.globalProperties.$sendEvent = pixelService.sendEvent;
    store.$sendEvent = pixelService.sendEvent;
}
