document.addEventListener('DOMContentLoaded', function() {

    document.getElementById("preloader").hidden = true;

    $('.alphabetic').on("keyup blur keypress", function(e){

        let value = $(this).val();

        $(this).val(value.replace(/^\s+/, ''));

        if((e.which < 65 && e.which != 32) && (e.which < 65 && e.which != 16) ||
        (e.which > 90 && e.which < 97) || (e.which > 122 && !Acentuacion(e.which))){
            e.preventDefault();
        }

    });

    $('.numeric').on("keyup blur keypress", function(e){

        let value = $(this).val();

        $(this).val(value.replace(/^\s+/, ''));

        if(e.which < 48 && e.which > 57){
            e.preventDefault();
        }

    });

}, false);


function Acentuacion(value){
    return [241, 209, 192, 239, 180, 186, 211, 201, 193, 205, 218, 225, 233, 237, 243, 250].includes(value);
}

/**
 *
 * @param {string} value - value to kinda validate
 * @returns trim value or null value
 */
function AvailableStringValue(value){
    return value === '' || value === null || value === undefined ? null : value.trim();
}
