const getPaises = async () => {
    try {
        // const respuesta = await fetch('https://restcountries.com/v5/all?fields=name,flags')
        const respuesta = await fetch('https://countriesnow.space/api/v0.1/countries')
        const datos = await respuesta.json();
        // console.log(datos.data);
        listaPaises(datos.data);
    } catch (error) {
        console.error(`Ha ocurrido un error: ${error}`);
    }
}

getPaises();

function listaPaises(paises) {
    let ubicacion = document.getElementById("ubicacion");
    ubicacion.innerHTML += "";

    const opciones = paises.map(pais => `
        <option value="${pais.country}">${pais.country}</option>
    `).join('');

    ubicacion.innerHTML += opciones;
}