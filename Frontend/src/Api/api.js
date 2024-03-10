//Pillar de sesion storage o store de pinia cuando se realice
const token = "1|LNSPOK5hwyhzxAYXbplfM1nlvB1yj8aOU11O3rTR0e414f0e";

//Genera la opcion para una llamada de api
export const genOptions = (metodo,body=null) => {
  return {
    method: metodo,
    headers: {
      "Content-Type": "application/json",
      "User-Agent": "insomnia/8.6.0",
      Accept: "application/json",
      Authorization: `Bearer ${token}`,
    },
    body: body,
  };
};

//Genera la opcion para una llamada de api
export const genOptionsWithoutBody = (metodo) => {
  return {
    method: metodo,
    headers: {
      "Content-Type": "application/json",
      "User-Agent": "insomnia/8.6.0",
      Accept: "application/json",
      Authorization: `Bearer ${token}`,
    }
  };
};