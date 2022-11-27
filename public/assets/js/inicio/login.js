document.addEventListener('DOMContentLoaded', function() {document.getElementById("preloader").hidden = true; }, false);

        // $("#iniciarSesion").on('click', function () {

        //     $('.preloader').show();

        //     var correoElectronico = $("#CorreoElectronico").val();
        //     var contrasena = $("#Password").val();

        //     try {

        //         $.ajax({
        //             url: '@Url.Action("IniciarSesion", "Inicio")',
        //             type: "POST",
        //             dataType: "JSON",
        //             data: {
        //                 CorreoElectronico: correoElectronico,
        //                 Contrasenia: contrasena,
        //                 __RequestVerificationToken: Token()
        //             },
        //             async: true,
        //             success: successFunc,
        //             error: errorFunc
        //         });

        //         function successFunc(response) {
        //             $('.preloader').hide();
        //             if (response.Codigo === 200) {



        //             } else {

        //                 Swal.fire({
        //                     title: '¡Alerta!',
        //                     text: response.Mensaje,
        //                     imageUrl: '@Url.Content("~/Templates/IndiferentOwl.png")',
        //                     imageWidth: 100,
        //                     imageHeight: 123,
        //                     imageAlt: 'Alert Image',
        //                     footer: response.Fecha
        //                 });
        //             }
        //         }

        //         function errorFunc(error) {
        //             $('.preloader').hide();
        //             Swal.fire({
        //                 title: '¡Error!',
        //                 html: error.responseText,
        //                 imageUrl: '@Url.Content("~/Templates/SadOwl.png")',
        //                 imageWidth: 100,
        //                 imageHeight: 123,
        //                 background: '#000000',
        //                 color: '#FFFFFF',
        //                 imageAlt: 'Error Image',
        //                 footer: error.Fecha
        //             });
        //         }

        //     }
        //     catch (ex) {
        //         $('.preloader').hide();
        //          Swal.fire({
        //             title: '¡Error!',
        //             html: ex.responseText,
        //             imageUrl: '@Url.Content("~/Templates/SadOwl.png")',
        //             imageWidth: 100,
        //             imageHeight: 123,
        //             background: '#000000',
        //             color: '#FFFFFF',
        //             imageAlt: 'Error Image',
        //             footer: '@DateTime.Now.ToString("dd/MM/yyyy hh:mm:ss tt")'
        //         });
        //     }

        // });


        // function Token() {
        //     return $('input[name="__RequestVerificationToken"]').val();
        // }