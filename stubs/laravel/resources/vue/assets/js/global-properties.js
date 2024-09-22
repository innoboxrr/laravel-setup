import { setPageTitle } from "./utils.js";

export const globalPropertiesRegistration = (app, store) => {
  app.config.globalProperties.$setPageTitle = setPageTitle;
  store.$setPageTitle = setPageTitle;
};
