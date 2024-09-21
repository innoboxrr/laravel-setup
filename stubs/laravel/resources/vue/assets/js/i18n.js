/*
 * PASAR ESTOA UN PAQUETE
 */

let translations;
let defaultLang = 'en';
let locales;

export function setTranslations(newTranslations) {
	translations = newTranslations;
}

export function setLocale(newLocale, once = false) {
	for (const key in translations) {
        const fileName = key.match(/\/([^\/]+)\.json$/)[1];
        if(fileName === newLocale) {
            locales = translations[key];
            break;
        }
    }
}

export default function (key, replace) {
    let locale;
    if(locales != undefined) {
    	locale = locales['default'][key]
	        ? locales['default'][key]
	        : key
	} else {
    	locale = key;
    }
    _.forEach(replace, (value, key) => {
        locale = locale.replace(':' + key, value)
    })
    return locale
};