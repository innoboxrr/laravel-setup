/** @type {import('tailwindcss').Config} */
const {addDynamicIconSelectors} = require('@iconify/tailwind');

module.exports = {
    content: [
        "./src/**/*.{php,html,js,jsx,ts,tsx,vue}",
        "./resources/**/*.{php,html,js,jsx,ts,tsx,vue}",
        "./storage/framework/views/*.php",
        "./node_modules/preline/preline.js",
    ],
    darkMode: "class",
    theme: {
        extend: {
            colors: {
                // Primary color palette
                primary: {
                    light: "#93c5fd", // Light blue
                    DEFAULT: "#3b82f6", // Base blue
                    dark: "#1e3a8a", // Dark blue
                },
                // Secondary color palette
                secondary: {
                    light: "#f9a8d4", // Light pink
                    DEFAULT: "#ec4899", // Base pink
                    dark: "#9d174d", // Dark pink
                },
                // Accent color palette
                accent: {
                    light: "#d9f99d", // Light green
                    DEFAULT: "#84cc16", // Base green
                    dark: "#4d7c0f", // Dark green
                },
                // Neutral colors
                neutral: {
                    light: "#f3f4f6", // Light grey
                    DEFAULT: "#6b7280", // Base grey
                    dark: "#1f2937", // Dark grey
                },
                // Additional custom colors
                error: "#dc2626", // Error red
                success: "#16a34a", // Success green
                warning: "#f59e0b", // Warning yellow
            },
        },
    },
    plugins: [
        require('flowbite/plugin')({
            charts: true,
        }),
        require('@tailwindcss/forms'),
        addDynamicIconSelectors({
            overrideOnly: true,
        }),
        require('preline/plugin'),
    ],
}