/**
 * https://stackoverflow.com/questions/61153418/is-it-possible-to-get-full-url-including-origin-from-route-in-vuejs
 * Esto sirve para obtener la ruta completa
 */
import router from "@/router/index.js";
function getAbsoluteUrl(params) {
  const route = router.resolve({});
  const absoluteURL = new URL(route.href, window.location.origin).href;
  return absoluteURL;
}

export default getAbsoluteUrl;
