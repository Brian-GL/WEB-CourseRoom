let BaseURL = window.location.origin;
let Resultado = document.getElementById("resultado");

document.getElementById("solucionar").addEventListener('click',  async () => {

    try{

        ShowPreloader();

        let response = await axios({
            url: '/herramientas/operador',
            baseURL: BaseURL,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.head.querySelector("[name~=csrf-token][content]").content
            },
            data: {
                "Expresion": document.getElementById("expresion").value,
                "Operacion": document.getElementById("tipo-operaciones").value
            }
        });

        HidePreloader();

        let result = response.data;

        if (result.code === 200) {
            let pretty = JSON.stringify(result.data, undefined, 4);
            Resultado.innerText = pretty;

        } else {
            Resultado.innerText = "";
            Swal.fire({
                title: '¡Alerta!',
                text: result.data,
                imageUrl: BaseURL.concat("/assets/templates/IndiferentOwl.png"),
                imageWidth: 100,
                imageHeight: 123,
                imageAlt: 'Alert Image',
                background: '#000000',
                color: '#FFFFFF'
            });
        }
    }
    catch(ex){

        HidePreloader();

        Swal.fire({
            title: '¡Error!',
            text: ex,
            imageUrl: BaseURL.concat("/assets/templates/SadOwl.png"),
            imageWidth: 100,
            imageHeight: 123,
            background: '#000000',
            color: '#FFFFFF',
            imageAlt: 'Error Image'
        });
    }
});
