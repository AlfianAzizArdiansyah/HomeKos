import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";
import colors from "tailwindcss/colors";

export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // Mengaktifkan warna cerah yang umum digunakan
                sky: colors.sky,
                rose: colors.rose,
                lime: colors.lime,
                emerald: colors.emerald,
                amber: colors.amber,
                teal: colors.teal,
                cyan: colors.cyan,
                violet: colors.violet,
                fuchsia: colors.fuchsia,
                indigo: colors.indigo,
            },
        },
    },

    plugins: [forms],
};
