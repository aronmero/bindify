export const municipios =  [
    {
        id: 1,
        name: 'Los Llanos'
    },
    {
        id: 2,
        name: 'Santa Cruz'
    },
    {
        id: 3,
        name: 'Mazo'
    },
    {
        id: 4,
        name: 'El Paso'
    },
    {
        id: 5,
        name: 'Garafia'
    },
    {
        id: 6,
        name: 'Tazacorte'
    },
    {
        id: 7,
        name: 'Tijarafe'
    },
];

export const obtener_municipio = (municipality_id) => {
    let found = null;

    municipios.forEach(municipio =>  {
        if (municipio.id == municipality_id) found = municipio 
    });
    return found;
}