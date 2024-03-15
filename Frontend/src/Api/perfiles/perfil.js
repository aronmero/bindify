
import { genOptions, urlApi, genOptionsUpdate } from "@/Api/api.js";



export async function getUserData(metodo,subRuta,body=null) {
    const user = JSON.parse(sessionStorage.getItem("usuario"));
    
    try {
      const options = genOptions(metodo,body);
      const response = await fetch(`${urlApi}${subRuta}`, options);
      const data = await response.json();

      sessionStorage.setItem("userData",JSON.stringify({ userData: data.data }))
      
      return data.data;
    } catch (error) {
      console.error(error);
    }
  }
export async function getUserPosts(metodo,subRuta,body=null) {
    
    try {
      const options = genOptions(metodo,body);
      const response = await fetch(`${urlApi}${subRuta}`, options);
      const data = await response.json();
      
      
      return data.data;
    } catch (error) {
      console.error(error);
    }
  }
export async function getUserReviews(metodo,subRuta,body=null) {
    
    try {
      const options = genOptions(metodo,body);
      const response = await fetch(`${urlApi}${subRuta}`, options);
      const data = await response.json();
      
      
      return data.reviews;
    } catch (error) {
      console.error(error);
    }
  }
export async function updateUserData(metodo,datos,userName) {
    
    try {
    let formData = new FormData();
    for(let clave in datos){
      formData.append(clave, datos[clave]);
    }
    const options = genOptionsUpdate(metodo,formData);
    const response = await fetch(`${urlApi}/api/user/${userName}?_method=PUT`, options);
    const data = await response.json();
    
    return data;
    } catch (error) {
      console.error(error);
    }
  }
  export async function postUserReview(metodo, body) {
    
    try {
      const datos = JSON.stringify(body);
      const options = genOptions(metodo, datos);
      const response = await fetch(`${urlApi}/api/review`, options);
      const data = await response.json();
      
      return data.reviews;
    } catch (error) {
      console.error(error);
    }
  }
export async function getUserFollows(metodo,subRuta,body=null) {
    
    try {
      const options = genOptions(metodo,body);
      const response = await fetch(`${urlApi}${subRuta}`, options);
      const data = await response.json();
      
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
  export async function borrarPost(metodo,subRuta,body=null) {
    
    try {
      const options = genOptions(metodo,body);
      const response = await fetch(`${urlApi}${subRuta}`, options);
      const data = await response.json();
    
      
      return data.data;
    } catch (error) {
      console.error(error);
    }
  }
