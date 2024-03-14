export const fetchTo = async ({data}) => {
    const data = await fetch(data)
        .then((data) => data.json())
        .then((res) => res);
    
}