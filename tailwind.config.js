const plugin = require("tailwindcss/plugin");

module.exports = {
    content: ["resources/views/**/*.blade.php"],
    darkMode: "class",
    theme: {
        extend: {},
    },
    plugins: [
        require("@tailwindcss/typography"),
        plugin(function ({ addUtilities }) {
            addUtilities({
                ".test-mode *": {
                    border: "solid 1px red",
                },
            });
        }),
    ],
};
