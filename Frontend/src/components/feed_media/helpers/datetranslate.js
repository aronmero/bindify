export const datetranslate = (postDate) => {
    let post_date = new Date(`${postDate}`);
    let now = new Date();
    let diferencia =  now - post_date;
    let segundos = Math.floor(diferencia / 1000);
    let minutos = Math.floor(segundos / 60);
    let horas = Math.floor(minutos / 60);
    let dias = Math.floor(horas / 24);
    let meses = Math.floor(dias / 30);
    let anios = Math.floor(meses / 12);
  
    meses = meses % 12;
    dias = dias % 30;
    horas = horas % 24;
    minutos = minutos % 60;
    segundos = segundos % 60;
  
    let resultado = "";
    switch(resultado == "") {
      case anios > 0:
          resultado += `${anios} año${anios > 1 ? 's' : ''} `;
          break;
      case meses > 0:
          resultado += `${meses} mes${meses > 1 ? 'es' : ''} `;
          break;
      case dias > 0:
          resultado += `${dias} día${dias > 1 ? 's' : ''} `;
          break;
      case horas > 0:
          resultado += `${horas} hora${horas > 1 ? 's' : ''} `;
          break;
      case minutos > 0:
          resultado += `${minutos} minuto${minutos > 1 ? 's' : ''} `;
          break;
      case segundos > 0:
          resultado += `${segundos} segundo${segundos > 1 ? 's' : ''} `;
          break;
    }
    
    return resultado;
}