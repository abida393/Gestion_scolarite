/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                primary: "#ff0000",
                secondary: "#64748b",
                accent: "#fbbf24",
                neutral: "#374151",
                "base-100": "#ffffff",
                info: "#3abff8",
                success: "#36d399",
                warning: "#fbbd23",
                error: "#f87272",
            },
        },
    },
    plugins: [],
};
