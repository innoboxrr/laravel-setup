import dayjs from 'dayjs'
import { Dropdown, Drawer } from 'flowbite';
import lang from 'innoboxrr-i18n'
import { replaceWord } from 'innoboxrr-js-libs/libs/string.js'
import APP_NAME from './env.js'

export function setPageTitle(title) {
    if (title) {
        document.title = `${title} - ${APP_NAME.APP_NAME}`;
    } else {
        document.title = APP_NAME.APP_NAME;
    }
}

export const showLoader = (id = 'loader') => {
    const loader = document.getElementById(id);
    loader.style.display = 'flex';
}

export const  hideLoader = (id = 'loader') => {
    const loader = document.getElementById(id);
    loader.style.display = 'none';
}

export const formatDate = (date, format = 'MM/DD/YYYY', customParse = null) => {
    let formatObject = {
        LT: 'h:mm A', // 8:02 PM
        LTS: 'h:mm:ss A', // 8:02:18 PM
        L: 'MM/DD/YYYY', // 08/16/2018
        LL: 'MMMM D, YYYY', // August 16, 2018
        LLL: 'MMMM D, YYYY h:mm A', // August 16, 2018 8:02 PM
        LLLL: 'dddd, MMMM D, YYYY h:mm A', // Thursday, August 16, 2018 8:02 PM
        l: 'M/D/YYYY', // 8/16/2018
        ll: 'MMM D, YYYY', // Aug 16, 2018
        lll: 'MMM D, YYYY h:mm A', // Aug 16, 2018 8:02 PM
        llll: 'ddd, MMM D, YYYY h:mm A', // Thu, Aug 16, 2018 8:02 PM
    }
    format = replaceWord(format, formatObject, format);
    return (customParse != null) ? dayjs(date, customParse).format(format) :  dayjs(date).format(format);
}


export const getGeoInfo = async () => {
    const geoInfo = localStorage.getItem('geoInfo');

    if (geoInfo) {
        return JSON.parse(geoInfo); 
    }

    const response = await fetch('https://freeipapi.com/api/json');
    const data = await response.json();
    const newGeoInfo = {
        ip: data.idAddress,
        ip_version: data.ipVersion,
        lat: data.latitude,
        lng: data.longitude,
        continent_name: data.continent,
        continent_code: data.continentCode,
        country_name: data.countryName,
        country_code: data.countryCode,
        city_name: data.cityName,
        region_name: data.regionName,
        zip_code: data.zipCode,
        timezone: data.timezone,
    };

    navigator.geolocation.getCurrentPosition((position) => {
        newGeoInfo.lat = position.coords.latitude;
        newGeoInfo.lng = position.coords.longitude;
    });

    localStorage.setItem('geoInfo', JSON.stringify(newGeoInfo)); 
    return newGeoInfo;
}

export const pluralizeTimeUnits = (unit, count) => {
    if (count === 1) {
        return lang(unit); 
    } else {
        switch (unit) {
            case lang('month'):
                return lang('months');
            case 'week':
                return lang('weeks');
            case 'year':
                return lang('years');
            case 'day':
                return lang('days');
            default:
                return lang(unit) + 's'; 
        }
    }
}

// mo is model translation
export const mt = (key, object) => {
    return object.translation && object.translation.map[key] ? object.translation.map[key] : object[key];
}

export const translateModel = (original) => {
    if (!original.translation || !original.translation.map) {
        return original;
    }

    const translated = { ...original }; // Crear una copia del objeto original
    const translationMap = original.translation.map;

    // Sobrescribir las propiedades existentes con las de translation.map
    for (const key in translationMap) {
        if (translated.hasOwnProperty(key)) {
            translated[key] = translationMap[key];
        }
    }

    delete translated.translation; // Eliminar la propiedad translation

    return translated;
}

export const closeDropdown = (dropdown, trigger) => {
    const triggerElement = document.getElementById(trigger);
    const dropdownElement = document.getElementById(dropdown);
    const dropdownInstance = new Dropdown(dropdownElement, triggerElement);
    dropdownInstance.hide();
};

export const closeDrawer = (drawer) => {
    const drawerElement = document.getElementById(drawer);
    if (!drawerElement) {
        return;
    }
    const drawerInstance = new Dropdown(drawerElement);
    if (window.innerWidth <= 768) {
        drawerInstance.toggle();
    }
};

export const updateQueryParams = (params, replace = false) => {
    // Obtiene la URL actual
    const url = new URL(window.location);

    if (replace) {
        // Elimina todos los parámetros actuales
        url.search = ''; 
    }

    // Itera sobre los parámetros proporcionados
    Object.keys(params).forEach(key => {
        url.searchParams.set(key, params[key]); // Añade o actualiza cada parámetro
    });

    // Actualiza la URL sin recargar la página
    window.history.pushState({}, '', url);
}
