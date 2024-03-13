export  const comparar_fechas = (fecha_1, fecha_2, fecha_3) => {
    //`${day.year}-${day.day}-${day.month}`
    let f1_split = fecha_1.split("-"); // fecha de inicio post
    let f2_split = fecha_2.split("-"); // fecha actual
    let f3_split = fecha_3.split("-"); //fecha de fin post
    let f_1 = new Date(f1_split[0], f1_split[1] - 1, f1_split[2]);
    let f_2 = new Date(f2_split[0], f2_split[1] - 1, f1_split[2]);
    let f_3 = new Date(f3_split[0], f3_split[1] - 1, f1_split[2]);
    console.log(f_3, '-', f_1, '-' , f_2)
    if( f_1 < f_2 && f_3 > f_1 ) {
        return true;
    }  else {
        return false;
    }
};