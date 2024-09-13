// UIkit

    import UIkit from 'uikit';
    import Icons from 'uikit/dist/js/uikit-icons';
    import CustomIcons from 'uikit-custom-icons'
    import LocalIcons from '@js/icons.js'
    UIkit.use(Icons);
    UIkit.icon.add(CustomIcons);
    UIkit.icon.add(LocalIcons.icons);
    window.UIkit = UIkit;

// Preline

    import "preline/preline";
    import { HSStaticMethods } from "preline/preline";
    window.HSStaticMethods = HSStaticMethods;

// LODASH

    import _ from 'lodash';
    window._ = _;

// ROUTE

    import route, { setRoutes, setBaseUrl } from 'innoboxrr-route-resolver';
    import routes from '@json/routes.json';
    setRoutes(routes);
    // setBaseUrl(window.location.hostname);
    window.route = route;

// LOCALE

    import lang, {setTranslations, setLocale} from '@js/i18n.js'
    setTranslations(import.meta.globEager('/resources/locales/*.json'));
    let locale = document.querySelector('html').getAttribute('lang') ?? 'en';
    setLocale(locale); 
    window.t = lang;

// CHANCE: Library to generate any random string. Docs: https://chancejs.com/index.html

    import chance from 'chance'
    window.chance = chance.Chance();

// SWAL

    import sweetalert2 from 'sweetalert2'
    // Docs: https://sweetalert2.github.io/
    window.Swal = sweetalert2;

// SWIPER
    // import function to register Swiper custom elements
    import { register as swiperRegister } from 'swiper/element/bundle';
    swiperRegister();

// AXIOS
    
    import axios from 'axios'
    import { showLoader, hideLoader } from '@js/utils.js';

    window.axios = axios;
    window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    axios.defaults.withCredentials = true;
    axios.defaults.withXSRFToken = true;
    window.csrf_token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Agregar un interceptor para las solicitudes
    axios.interceptors.request.use(
        function (config) {
            const url = new URL(config.url, window.location.origin);
            const loaderParam = url.searchParams.get("loader");

            // Convert values to booleans for consistent comparison
            const isLoaderParamFalse = loaderParam === 'false';
            const isConfigLoaderFalse = config.params?.loader === false;

            // Show the loader only if both values are not false
            if (!isLoaderParamFalse && !isConfigLoaderFalse) {
                showLoader(); // Show the loader when a request is made
            }
                
            return config;
        },
        function (error) {
            return Promise.reject(error);
        }
    );

    // Agregar un interceptor para las respuestas
    axios.interceptors.response.use(
        function (response) {
            hideLoader(); // Ocultar el cargador cuando se recibe una respuesta
            return response;
        },
        function (error) {
            hideLoader(); // Ocultar el cargador en caso de error también
            return Promise.reject(error);
        }
    );

// INNOBOXRR HTTP REQUEST
    
    // En tu archivo principal, como index.js
    import { makeHttpRequest } from 'innoboxrr-http-request';
    window.makeHttpRequest = makeHttpRequest;

// DAYJS

    import dayjs from 'dayjs'
    import customParseFormat from 'dayjs/plugin/customParseFormat'
    import utc from 'dayjs/plugin/utc'
    import timezone from 'dayjs/plugin/timezone'
    import relativeTime from 'dayjs/plugin/relativeTime'
    import isSameOrBefore from 'dayjs/plugin/isSameOrBefore'
    import isSameOrAfter from 'dayjs/plugin/isSameOrAfter'
    import isBetween from 'dayjs/plugin/isBetween'
    import 'dayjs/locale/es'
    import 'dayjs/locale/fr'

    dayjs.extend(customParseFormat)
    dayjs.extend(utc)
    dayjs.extend(timezone)
    dayjs.extend(relativeTime)
    dayjs.extend(isSameOrBefore)
    dayjs.extend(isSameOrAfter)
    dayjs.extend(isBetween)

    dayjs.locale(document.querySelector('html').getAttribute('lang'))
    dayjs.tz.setDefault('America/Mexico_City')

// FLOWBITE
    import 'flowbite';

// ECHO
    import Pusher from 'pusher-js';
    import Echo from 'laravel-echo';

    window.Pusher = Pusher;

    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: import.meta.env.VITE_PUSHER_APP_KEY,
        cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
        forceTLS: true,
        authorizer: (channel, options) => {
            return {
                authorize: (socketId, callback) => {
                    axios.post('/broadcasting/auth', {
                        socket_id: socketId,
                        channel_name: channel.name
                    })
                    .then(response => {
                        callback(false, response.data);
                    })
                    .catch(error => {
                        callback(true, error);
                    });
                }
            };
        },
    });

// PrismJS
    import Prism from 'prismjs';
    import 'prismjs/themes/prism-okaidia.css';
    import 'prismjs/plugins/line-numbers/prism-line-numbers.js';
    import 'prismjs/plugins/line-numbers/prism-line-numbers.css';
    window.Prism = Prism;
