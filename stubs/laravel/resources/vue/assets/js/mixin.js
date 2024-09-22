import dayjs from 'dayjs'
import { replaceWord, strlimit, slugify, removeTags, decodeEntities } from 'innoboxrr-js-libs/libs/string.js'
import { numberFormat } from 'innoboxrr-js-libs/libs/number.js'
import { formatSeconds } from 'innoboxrr-js-libs/libs/time.js'
import { showLoader, hideLoader, mt, translateModel, formatDate } from '@js/utils.js';
import { APP_VARS } from '@js/env.js'

export default {

	data() {
		return {
			...APP_VARS,
			showJsons: true, // Enable only for dev 
		}
	},

	methods: {

		// TRANSLATION

			__(key, replace) {
				return window.t(key, replace);
			},

			// mo is model translation
			mt(key, object) {
				return mt(key, object);
			},

			translateModel(original) {
				return translateModel(original);
			},

		// CHANCE

			getUuid() {
				return chance.guid();
			},

			getHash(length = 25, casing = 'lower') {
				return chance.hash({length: length, casing: casing});
			},

			randInt(min = -9007199254740991, max = 9007199254740991) {
				return chance.integer({ min: min, max: max });
			},

		// DATES

			formatDate(date, format = 'MM/DD/YYYY', customParse = null) {
				return formatDate(date, format, customParse);
			},

			age(date) {
				return dayjs(date).fromNow(true);
			},

			fromNow(date) {
				return dayjs(date).fromNow();
			},

			formatSeconds(sec, dh = ' : ', dm = ' : ', ds = '', show_seg = true) {
				return formatSeconds(sec, dh, dm, ds, show_seg);
			},

		// STRINGS

			replaceWord(word, object, def = '') {
				return replaceWord(word, object, def);
			},

			strlimit(str, length = 45) {
				return strlimit(removeTags(decodeEntities(str)), length);
			},

			slugify(str) {
				return slugify(str);
			},

			removeTags(str) {
				return removeTags(str);
			},

			btoa(string) {
				return btoa(string);
			},

			atob(base64) {
				return atob(base64);
			},

		// NUMERIC

			numberFormat(amount, decimals) {
				return numberFormat(amount, decimals);
			},

		// BOOLEAN

			getBool(value) {
				// Handling boolean values
				if (typeof value === 'boolean') {
					return value;
				}
			
				// Handling string values
				if (typeof value === 'string') {
					value = value.toLowerCase().trim();
					return ['true', '1', 'yes', 'on', 'y', 'si', 'verdadero'].includes(value);
				}
			
				// Handling number values
				if (typeof value === 'number') {
					return value === 1;
				}
			
				// Handling null and undefined values
				if (value === null || value === undefined) {
					return false;
				}
			
				// Handling objects and arrays
				if (typeof value === 'object') {
					return Object.keys(value).length > 0;
				}
			
				// Handling functions
				if (typeof value === 'function') {
					return true;
				}
			
				// Default to false for other types
				return false;
			},

		// ARRAY

			randomValue(array) {
				return array[Math.floor(Math.random() * array.length)];
			},

		// QR

			getQr(url) {
				let qr = `https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=${encodeURIComponent(url)}&choe=UTF-8`;
				return qr;
			},

		// DOM

			alert(type = 'none', object = {}, message = null) {
				let data = this.replaceWord(type, {
					'save': {
						title: this.__('Save'),
						text: this.__('The record has been saved.'),
						icon: 'success',
					},
					'update': {
						title: this.__('Update'),
						text: this.__('The record has been updated.'),
						icon: 'success',
					},
					'delete': {
						title: this.__('Delete'),
						text: this.__('The record has been deleted.'),
						icon: 'success',
					}, 
					'cancel': {
						title: this.__('Cancel'),
						text: this.__('The operation has been cancelled.'),
						icon: 'error',
					}, 
					'error': {
						title: this.__('Error'),
						text: this.__('An error occurred, please try again later.'),
						icon: 'error',
					}, 
					'success': {
						title: this.__('Success'),
						text: this.__('The operation was successful.'),
						icon: 'success',
					}, 
					'none': object, // For cases where there is no predefined message
					'custom': object, // For fully customized cases
				});

				// Check the type of `message` and replace values in `data` correspondingly
				if (typeof message === 'string') {
					data.text = this.__(message); // Directly replaces the text
				} else if (typeof message === 'object' && message != null) {
					if (message.title) {
						data.title = this.__(message.title); // Replace the title if available
					}
					if (message.text) {
						data.text = this.__(message.text); // Replace the text if available
					}
				}
			
				// Calls SweetAlert with the adjusted data
				Swal.fire({
					...data,
					toast: object.toast ?? true,
					position: object.position ?? 'top-end',
					showConfirmButton: object.showConfirmButton ?? false,
					timer: object.timer ?? 1500,
					timerProgressBar: object.timerProgressBar ?? true,
				});
			},
			
			openWindow(url, target = '_blanck') {
				window.open(url, target);
			},

			reloadPage() {
				location.reload();
			},

			showLoader() {
				hideLoader('loader');
				showLoader('app-loader');
			},

			hideLoader() {
				hideLoader('app-loader');
			},

			sleep(time = 1000) {
				this.showLoader();
				setTimeout(() => {
					this.hideLoader();
				}, time);
			},

		// FILES

			handleFileUploadSuccess(data, callback, uri) {
				let path = '/lu/upload/' + data.uuid + '/display/' + data.filename;
				callback(path, {text: data.filename});
			},
		
		// MODELS - AUTH (USER)

			hasRole(role) {
				return this.$store.getters['authPages/hasRole'](role);
			},

			hasRoles(roles) {
				return this.$store.getters['authPages/hasRoles'](roles);
			},

			can(permission, roles = null) {
				return this.$store.getters['authPages/can'](permission, roles);
			},

		// MODELS - OPTIONS
			
			option(key, def = null) {
				return this.$store.getters['optionsStore/getOption'](key) ?? def;
			}

		// OTHERS
			
			// ...
	}
}