//Pillar de sesion storage o store de pinia cuando se realice
import { genOptions, urlApi, genOptionsUpdate } from "@/Api/api.js";


/**
 * Devuelve un objeto publicacion con sus datos
 * @date 
 * @author 
 *
 * @export
 * @async
 * @param {Number} id de la publicacion
 * @returns {Object}
 */
export async function getUserData(metodo,subRuta,body=null) {
    const user = JSON.parse(sessionStorage.getItem("usuario"));
    console.log(user)
    try {
      const options = genOptions(metodo,body);
      const response = await fetch(`${urlApi}${subRuta}`, options);
      const data = await response.json();

      sessionStorage.setItem("userData",JSON.stringify({ userData: data.data }))
      console.log("hola")
      return data.data;
    } catch (error) {
      console.error(error);
    }
  }
export async function getUserPosts(metodo,subRuta,body=null) {
    // const user = JSON.parse(sessionStorage.getItem("usuario"));
    // console.log(user)
    try {
      const options = genOptions(metodo,body);
      const response = await fetch(`${urlApi}${subRuta}`, options);
      const data = await response.json();
      sessionStorage.setItem("userData",JSON.stringify({ userData: data.data }))
      console.log(data.data)
      return data.data;
    } catch (error) {
      console.error(error);
    }
  }
export async function getUserReviews(metodo,subRuta,body=null) {
    // const user = JSON.parse(sessionStorage.getItem("usuario"));
    // console.log(user)
    try {
      const options = genOptions(metodo,body);
      const response = await fetch(`${urlApi}${subRuta}`, options);
      const data = await response.json();
      // sessionStorage.setItem("userData",JSON.stringify({ userData: data.data }))
      console.log(data.reviews)
      return data.reviews;
    } catch (error) {
      console.error(error);
    }
  }
export async function updateUserData(metodo,datos,userName) {
    // const user = JSON.parse(sessionStorage.getItem("usuario"));
    // console.log(user)
    try {
    let formData = new FormData();
    for(let clave in datos){
      formData.append(clave, datos[clave]);
    }
    const options = genOptionsUpdate(metodo,formData);
    const response = await fetch(`${urlApi}/api/user/${userName}?_method=PUT`, options);
    const data = await response.json();
    // sessionStorage.setItem("userData",JSON.stringify({ userData: data.data }))
    console.log(data)
    return data;
    } catch (error) {
      console.error(error);
    }
  }
  export async function postUserReview(metodo, body = null) {
    // const user = JSON.parse(sessionStorage.getItem("usuario"));
    // console.log(user)
    try {
      let formData = new FormData();
      for(let clave in body){
        formData.append(clave, body[clave]);
      }
      console.log(formData.get("title"));
      const options = genOptions(metodo,formData);
      const response = await fetch(`${urlApi}/api/review`, options);
      const data = await response.json();
      // sessionStorage.setItem("userData",JSON.stringify({ userData: data.data }))
      console.log(data.reviews)
      return data.reviews;
    } catch (error) {
      console.error(error);
    }
  }
export async function getUserFollows(metodo,subRuta,body=null) {
    // const user = JSON.parse(sessionStorage.getItem("usuario"));
    // console.log(user)
    try {
      const options = genOptions(metodo,body);
      const response = await fetch(`${urlApi}${subRuta}`, options);
      const data = await response.json();
      console.log(data.data)
      return data.data;
    } catch (error) {
      console.error(error);
    }
  }
export async function followUser(metodo,subRuta,body=null) {
    try {
      const options = genOptions(metodo,body);
      const response = await fetch(`${urlApi}${subRuta}`, options);
      const data = await response.json();
      console.log(data)
      if(data.message =="Usuario seguido"){
        return true
      }else{
        return false
      }
      return data;
    } catch (error) {
      console.error(error);
    }
  }
export async function aniadirFavorito(metodo,subRuta,body=null) {
    try {
      const options = genOptions(metodo,body);
      const response = await fetch(`${urlApi}${subRuta}`, options);
      const data = await response.json();
      console.log(data)
      if(data.message =="Usuario añadido a favoritos"){
        return true
      }else{
        return false
      }
      return data;
    } catch (error) {
      console.error(error);
    }
  }
