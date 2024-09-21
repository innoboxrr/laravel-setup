// DOCUMENTACIÓN
/**
 * Para añadir un nuevo proveedor de píxeles, sigue los puntos marcados con "Add platform [#]".
 * Al añadir un nuevo evento se debe registrar en Events y en getEventName.
 * 
 * CUANDO ESTO ESTÉ COMPLETAMENTE TESTADO PASAR A UN PAQUETE INDEPENDIENTE
 */

// IMPORTS
import { createModel as createTrackingEvent} from '@models/tracking-event'

export const Events = {
    PAGE_VIEW: 'page_view',
    ADD_TO_CART: 'add_to_cart',
    REMOVE_FROM_CART: 'remove_from_cart',
    INITIATE_CHECKOUT: 'initiate_checkout',
    PURCHASE: 'purchase',
    ADD_TO_WISHLIST: 'add_to_wishlist',
    SIGN_UP: 'sign_up',
    LEAD: 'lead',
    // Agrega más eventos según sea necesario
};

export const pixelService = {

    sendEvent: (event, data = {}) => {

        data.uuid = window.chance.guid();

        const urlParams = new URLSearchParams(window.location.search);

        // Recupera los UTM y ClickID de la URL o la cookie
        const utmParams = {
            source: urlParams.get('utm_source') || pixelService.getCookie('utm_source'),
            medium: urlParams.get('utm_medium') || pixelService.getCookie('utm_medium'),
            campaign: urlParams.get('utm_campaign') || pixelService.getCookie('utm_campaign'),
            term: urlParams.get('utm_term') || pixelService.getCookie('utm_term'),
            content: urlParams.get('utm_content') || pixelService.getCookie('utm_content'),
            gclid: urlParams.get('gclid') || pixelService.getCookie('gclid'),
            fbclid: urlParams.get('fbclid') || pixelService.getCookie('fbclid'),
            ttclid: urlParams.get('ttclid') || pixelService.getCookie('ttclid'),
        };

        // Si los UTM están en la URL, almacenarlos en una cookie (con precedencia al último)
            if (utmParams.source) pixelService.setCookie('utm_source', utmParams.source, 30);
            if (utmParams.medium) pixelService.setCookie('utm_medium', utmParams.medium, 30);
            if (utmParams.campaign) pixelService.setCookie('utm_campaign', utmParams.campaign, 30);
            if (utmParams.term) pixelService.setCookie('utm_term', utmParams.term, 30);
            if (utmParams.content) pixelService.setCookie('utm_content', utmParams.content, 30);
        // ClickID
            if (utmParams.gclid) pixelService.setCookie('gclid', utmParams.gclid, 30);
            if (utmParams.fbclid) pixelService.setCookie('fbclid', utmParams.fbclid, 30);
            if (utmParams.ttclid) pixelService.setCookie('ttclid', utmParams.ttclid, 30);

        let platformsToSend = [];

        // Determina a qué plataformas enviar el evento
            if (utmParams.fbclid || utmParams.source === 'facebook') {
                platformsToSend.push('facebook');
            } 
            if (utmParams.gclid || utmParams.source === 'google') {
                platformsToSend.push('google');
            }
            if (utmParams.ttclid || utmParams.source === 'tiktok') {
                platformsToSend.push('tiktok');
            }
            // Add platform 1. Añade el proveedor a la lista de plataformas

        // Eventos a enviar a todas las plataformas relevantes
            const eventsForAllPlatforms = [
                Events.PAGE_VIEW,
                Events.SIGN_UP,
                Events.LEAD
            ];

            // Decide si enviar a todas las plataformas o solo a las relevantes
            if (eventsForAllPlatforms.includes(event)) {
                platformsToSend = [
                    'facebook', 
                    'google', 
                    'tiktok',
                    // Add platform 2. Añade el proveedor a la lista de plataformas
                ];

            }

        const formattedData = pixelService.formatEventData(event, data);

        // Enviar a las plataformas externas
        pixelService.sendToSpecificPlatforms(platformsToSend, event, formattedData, data);

        // Enviar a la plataforma interna
        pixelService.sendToInternalPlatform(event, data, formattedData, platformsToSend, utmParams);
    },

    sendToSpecificPlatforms: (platforms, eventName, formattedData, originalData) => {
        if (platforms.includes('facebook')) {
            pixelService.sendToFacebook(
                pixelService.getEventName(eventName, 'facebook'), 
                formattedData.facebook, 
                originalData
            );
        }
        if (platforms.includes('google')) {
            pixelService.sendToGoogle(
                pixelService.getEventName(eventName, 'google'), 
                formattedData.google, 
                originalData
            );
        }
        if (platforms.includes('tiktok')) {
            pixelService.sendToTikTok(
                pixelService.getEventName(eventName, 'tiktok'), 
                formattedData.tiktok, 
                originalData
            );
        }
        // Add platform 3. Añade el proveedor a la lista de plataformas
    },

    sendToInternalPlatform: (eventName, data, formattedData, platforms, utmParams) => {

        let rateLimitEvents = ['page_view'];

        if(rateLimitEvents.includes(eventName)) {
            const cookieName = `event_${eventName}`;
            const eventTimestamp = new Date().getTime();
        
            // Recuperar el timestamp de la última vez que se envió el evento
            const lastEventTimestamp = pixelService.getCookie(cookieName);
        
            if (lastEventTimestamp) {
                const timeSinceLastEvent = eventTimestamp - parseInt(lastEventTimestamp, 10);
                
                // Si ha pasado menos de 60 segundos, no enviar el evento
                if (timeSinceLastEvent < 60000) {
                    console.log(`Event "${eventName}" was sent too recently (${timeSinceLastEvent / 1000} seconds ago).`);
                    return;
                }
            }
        
            // Guardar el timestamp actual en la cookie
            pixelService.setCookie(cookieName, eventTimestamp, 1/1440); // 1/1440 días = 1 minuto
        }
    
        // Enviar el evento a la plataforma interna
        createTrackingEvent({
            uuid: data.uuid,
            event_name: eventName,
            utm_source: utmParams.source,
            utm_medium: utmParams.medium,
            utm_campaign: utmParams.campaign,
            utm_term: utmParams.term,
            utm_content: utmParams.content,
            gclid: utmParams.gclid,
            fbclid: utmParams.fbclid,
            ttclid: utmParams.ttclid,
            ip_address: data?.geo?.ip,
            user_agent: navigator.userAgent,
            geo: data?.geo,
            platforms: platforms,
            event_data: formattedData.internal,
            cart_id: formattedData.internal.cart_id, // Nullable
        });
    },

    formatEventData: (event, data) => {
        switch (event) {
            case Events.PAGE_VIEW:
                return pixelService.formatPageViewData(data);
            case Events.ADD_TO_CART:
                return pixelService.formatAddToCartData(data);
            case Events.REMOVE_FROM_CART:
                return pixelService.formatRemoveFromCartData(data);
            case Events.INITIATE_CHECKOUT:
                return pixelService.formatInitiateCheckoutData(data);
            case Events.PURCHASE:
                return pixelService.formatPurchaseData(data);
            case Events.ADD_TO_WISHLIST:
                return pixelService.formatAddToWishlistData(data);
            case Events.SIGN_UP:
                return pixelService.formatSignUpData(data);
            case Events.LEAD:
                return pixelService.formatLeadData(data);
            default:
                return data; // Para eventos personalizados
        }
    },

    getEventName: (eventName, platform) => {

        let facebookEvents = {
            [Events.PAGE_VIEW]: 'PageView',
            [Events.ADD_TO_CART]: 'AddToCart',
            [Events.REMOVE_FROM_CART]: 'RemoveFromCart',
            [Events.INITIATE_CHECKOUT]: 'InitiateCheckout',
            [Events.PURCHASE]: 'Purchase',
            [Events.ADD_TO_WISHLIST]: 'AddToWishlist',
            [Events.SIGN_UP]: 'CompleteRegistration',
            [Events.LEAD]: 'Lead',
        };

        let googleEvents = {
            [Events.PAGE_VIEW]: 'page_view',
            [Events.ADD_TO_CART]: 'add_to_cart',
            [Events.REMOVE_FROM_CART]: 'remove_from_cart',
            [Events.INITIATE_CHECKOUT]: 'begin_checkout',
            [Events.PURCHASE]: 'purchase',
            [Events.ADD_TO_WISHLIST]: 'add_to_wishlist',
            [Events.SIGN_UP]: 'sign_up',
            [Events.LEAD]: 'lead',
        };
        
        let tiktokEvents = {
            [Events.PAGE_VIEW]: 'PAGE_VIEW',
            [Events.ADD_TO_CART]: 'ADD_TO_CART',
            [Events.REMOVE_FROM_CART]: 'REMOVE_FROM_CART',
            [Events.INITIATE_CHECKOUT]: 'INITIATE_CHECKOUT',
            [Events.PURCHASE]: 'PURCHASE',
            [Events.ADD_TO_WISHLIST]: 'ADD_TO_WISHLIST',
            [Events.SIGN_UP]: 'SIGN_UP',
            [Events.LEAD]: 'LEAD',
        };
        // Add platform 4. Añade el proveedor a la lista de plataformas

        switch (platform) {
            case 'facebook':
                return facebookEvents[eventName];
            case 'google':
                return googleEvents[eventName];
            case 'tiktok':
                return tiktokEvents[eventName];
            // Add platform 5. Añade el proveedor a la lista de plataformas
        }
    },

    // FORMATEADORES DE DATOS

        formatPageViewData: (data) => {
            return {
                internal: {},
                facebook: { /* Datos específicos para Facebook */ },
                google: { /* Datos específicos para Google */ },
                tiktok: { /* Datos específicos para TikTok */ },
            };
        },

        formatSignUpData: (data) => {
            return {
                internal: {},
                facebook: { /* Datos específicos para Facebook */ },
                google: { /* Datos específicos para Google */ },
                tiktok: { /* Datos específicos para TikTok */ },
            };
        },

        formatLeadData: (data) => {
            return {
                internal: {},
                facebook: { /* Datos específicos para Facebook */ },
                google: { /* Datos específicos para Google */ },
                tiktok: { /* Datos específicos para TikTok */ },
            };
        },

        formatAddToCartData: (data) => {

            const productIds = data.cart.cart_items.map(item => item.product_id);
            productIds.push(data.cartItem.product.id);

            // Recalculare amount
            data.cart.amount = data.cart.amount + data.cartItem.total;

            return {
                internal: {
                    products: productIds,
                    value: data.cart.amount,
                    currency: 'USD',
                    cart_id: data.cart.id
                },
                facebook: {
                    content_ids: productIds,
                    value: data.cart.amount,
                    currency: 'USD',
                },
                google: {
                    items: data.cart.cart_items.map(item => ({
                        id: item.product_id,
                        name: item.product.productable.name,
                        quantity: item.quantity,
                        price: item.total,
                    })),
                    value: data.cart.amount,
                    currency: 'USD',
                },
                tiktok: {
                    content_id: productIds.join(','),  // TikTok generalmente maneja una cadena separada por comas
                    quantity: data.cart.cart_items.reduce((acc, item) => acc + item.quantity, 0),
                    value: data.cart.amount,
                    currency: 'USD',
                },
            };
        },

        formatRemoveFromCartData: (data) => {
            const productIds = data.cart.cart_items.map(item => item.product_id);

            // Recalculare amount
            data.cart.amount = data.cart.amount - data.cartItem.total;

            return {
                internal: {
                    products: productIds,
                    value: data.cart.amount,
                    currency: 'USD',
                    cart_id: data.cart.id
                },
                facebook: {
                    content_ids: productIds,
                    value: data.cart.amount,
                    currency: 'USD',
                },
                google: {
                    items: data.cart.cart_items.map(item => ({
                        id: item.product_id,
                        name: item.product.productable.name,
                        quantity: item.quantity,
                        price: item.total,
                    })),
                    value: data.cart.amount,
                    currency: 'USD',
                },
                tiktok: {
                    content_id: productIds.join(','),
                    quantity: data.cart.cart_items.reduce((acc, item) => acc + item.quantity, 0),
                    value: data.cart.amount,
                    currency: 'USD',
                },
            };
        },

        formatInitiateCheckoutData: (data) => {
            const productIds = data.cart.cart_items.map(item => item.product_id);

            return {
                internal: {
                    products: productIds,
                    value: data.cart.amount,
                    currency: 'USD',
                    cart_id: data.cart.id
                },
                facebook: {
                    content_ids: productIds,
                    value: data.cart.amount,
                    currency: 'USD',
                    num_items: data.cart.cart_items.length,
                },
                google: {
                    transaction_id: data.cart.id,
                    affiliation: 'Online Store',
                    value: data.cart.amount,
                    currency: 'USD',
                    items: data.cart.cart_items.map(item => ({
                        id: item.product_id,
                        name: item.product.productable.name,
                        quantity: item.quantity,
                        price: item.total,
                    })),
                },
                tiktok: {
                    content_id: productIds.join(','),
                    quantity: data.cart.cart_items.reduce((acc, item) => acc + item.quantity, 0),
                    value: data.cart.amount,
                    currency: 'USD',
                },
            };
        },

        formatPurchaseData: (data) => {
            const productIds = data.cart.cart_items.map(item => item.product_id);

            return {
                internal: {
                    products: productIds,
                    value: data.cart.amount,
                    currency: 'USD',
                    cart_id: data.cart.id,
                },
                facebook: {
                    content_ids: productIds,
                    value: data.cart.amount,
                    currency: 'USD',
                    num_items: data.cart.cart_items.length,
                    order_id: data.cart.id,
                },
                google: {
                    transaction_id: data.cart.id,
                    affiliation: 'Online Store',
                    value: data.cart.amount,
                    currency: 'USD',
                    tax: 0,
                    shipping: data.cart.shipping_total,
                    items: data.cart.cart_items.map(item => ({
                        id: item.product_id,
                        name: item.product.productable.name,
                        quantity: item.quantity,
                        price: item.total,
                    })),
                },
                tiktok: {
                    content_id: productIds.join(','),
                    quantity: data.cart.cart_items.reduce((acc, item) => acc + item.quantity, 0),
                    value: data.cart.amount,
                    currency: 'USD',
                    order_id: data.cart.id,
                },
            };
        },

        formatAddToWishlistData: (data) => {
            return {
                internal: {},
                facebook: {},
                google: {},
                tiktok: {},
            };
        },

    // SOCIAL PIXELS

        sendToFacebook: (eventName, formattedData, originalEvent) => {
            if (window.fbq) {
                window.fbq('track', eventName, formattedData, {
                    eventID: originalEvent.uuid,
                });
            }
        },

        sendToGoogle: (eventName, formattedData, originalEvent) => {
            if (window.gtag) {
                window.gtag('event', eventName, formattedData);
            }
        },

        sendToTikTok: (eventName, formattedData) => {
            if (window.ttq) {
                window.ttq.track(eventName, formattedData, originalEvent);
            }
        },

        // Add platform 6. Añade el proveedor a la lista de plataformas

    // UTILS

        getCookie: (name) => {
            const value = `; ${document.cookie}`;
            const parts = value.split(`; ${name}=`);
            if (parts.length === 2) return parts.pop().split(';').shift();
        },

        setCookie: (name, value, days) => {
            const date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            const expires = `expires=${date.toUTCString()}`;
            document.cookie = `${name}=${value}; ${expires}; path=/`;
        },
};
