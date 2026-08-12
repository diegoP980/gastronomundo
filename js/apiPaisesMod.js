const getCountries = async () => {
    try {
        const respuesta = await fetch('https://countriesnow.space/api/v0.1/countries');
        const resultado = await respuesta.json();
        // Los países vienen dentro de la propiedad .data
        console.log(resultado.data); 
    } catch (error) {
        console.error(error);
    }
}

getCountries()