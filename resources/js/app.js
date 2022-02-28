import Alpine from "alpinejs";

/**
 * Axios
 */
window.axios = require("axios");
window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

/**
 * Alpine
 */
window.Alpine = Alpine;
Alpine.start();
