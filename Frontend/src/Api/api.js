//Pillar de sesion storage o store de pinia cuando se realice
const token = "1|I5Kw8TZEdql19hGx5ETymRhFLDI689J7AHgwjiMQ9d66027b";

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