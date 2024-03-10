import { genOptionsWithoutBody } from "@/api/api.js";

export async function login(email,pass) {
    try {
      const options = genOptionsWithoutBody("POST");
      const response = await fetch(
        `http://127.0.0.1:8000/api/login?email=${email}&password=${pass}`,
        options
      );
      const data = await response.json();
      return data;
    } catch (error) {
      console.error(error);
    }
  }
  