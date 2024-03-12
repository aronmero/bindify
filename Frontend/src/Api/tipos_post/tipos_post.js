import { genOptions, urlApiHome } from "@/Api/api.js";

export async function getCommerces(metodo, body = null) {
  try {
    const options = genOptions(metodo, body);
    const url = new URL(`${urlApi}/api/post_type`);
    
    url.searchParams.append('type');
    const response = await fetch(url, options);
    const data = await response.json();
    return data.data;
  } catch (error) {
    console.error(error);
  }
}
