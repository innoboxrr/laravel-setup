<template>
    <button 
        @click="toggleTheme"
        id="theme-toggle" 
        type="button" 
        class="text-gray-500 inline-flex items-center justify-center dark:text-slate-400 dark:hover:text-slate-500 rounded-lg text-sm p-2.5">
        
        <svg v-if="!isDark" id="theme-toggle-dark-icon" class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20"><path d="M17.8 13.75a1 1 0 0 0-.859-.5A7.488 7.488 0 0 1 10.52 2a1 1 0 0 0 0-.969A1.035 1.035 0 0 0 9.687.5h-.113a9.5 9.5 0 1 0 8.222 14.247 1 1 0 0 0 .004-.997Z"></path></svg>

		<svg v-else id="theme-toggle-light-icon" class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 15a5 5 0 1 0 0-10 5 5 0 0 0 0 10Zm0-11a1 1 0 0 0 1-1V1a1 1 0 0 0-2 0v2a1 1 0 0 0 1 1Zm0 12a1 1 0 0 0-1 1v2a1 1 0 1 0 2 0v-2a1 1 0 0 0-1-1ZM4.343 5.757a1 1 0 0 0 1.414-1.414L4.343 2.929a1 1 0 0 0-1.414 1.414l1.414 1.414Zm11.314 8.486a1 1 0 0 0-1.414 1.414l1.414 1.414a1 1 0 0 0 1.414-1.414l-1.414-1.414ZM4 10a1 1 0 0 0-1-1H1a1 1 0 0 0 0 2h2a1 1 0 0 0 1-1Zm15-1h-2a1 1 0 1 0 0 2h2a1 1 0 0 0 0-2ZM4.343 14.243l-1.414 1.414a1 1 0 1 0 1.414 1.414l1.414-1.414a1 1 0 0 0-1.414-1.414ZM14.95 6.05a1 1 0 0 0 .707-.293l1.414-1.414a1 1 0 1 0-1.414-1.414l-1.414 1.414a1 1 0 0 0 .707 1.707Z"></path></svg>

        <span class="sr-only">Toggle dark mode</span>
    </button>
</template>

<script>
export default {
    data() {
        return {
            isDark: false
        }
    },
    mounted() {
        this.checkTheme();
    },
    methods: {
        toggleTheme() {
            if (document.body.classList.contains('dark')) {
                document.body.classList.remove('dark');
                this.isDark = false;
                this.setCookie('theme', 'light', 365);
            } else {
                document.body.classList.add('dark');
                this.isDark = true;
                this.setCookie('theme', 'dark', 365);
            }
        },
        checkTheme() {
            const theme = this.getCookie('theme');
            if (theme === 'dark') {
                document.body.classList.add('dark');
                this.isDark = true;
            } else {
                document.body.classList.remove('dark');
                this.isDark = false;
            }
        },
        setCookie(name, value, days) {
            let expires = "";
            if (days) {
                const date = new Date();
                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                expires = "; expires=" + date.toUTCString();
            }
            document.cookie = name + "=" + (value || "") + expires + "; path=/";
        },
        getCookie(name) {
            const nameEQ = name + "=";
            const ca = document.cookie.split(';');
            for (let i = 0; i < ca.length; i++) {
                let c = ca[i];
                while (c.charAt(0) === ' ') c = c.substring(1, c.length);
                if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
            }
            return null;
        }
    }
}
</script>
