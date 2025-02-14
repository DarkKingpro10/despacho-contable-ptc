//function que valide los campos vacios
function validarCamposVacios(arreglo) {
    for (let i = 0; i < arreglo.length; i++) {
        if (arreglo[i].value.length == 0) {
            return false;
        }
    }
}

//Reiniciar inputs Materializar
function reiniciarInputsM(arreglo) {
    for (let i = 0; i < arreglo.length; i++) {
        arreglo[i].value = "";
    }
}
//Función de borrar todos los campos
function borrarCampos(arreglo) {
    for (let i = 0; i < arreglo.length; i++) {
        arreglo[i].value = "";
    }
}
//Solo numeros, recibe el evento y el número de caso
function soloNumeros(e, caso) {
    switch (caso) {
        case 1: //Solo numeros
            tecla = document.all ? e.keyCode : e.which;

            //Tecla de retroceso para borrar, siempre la permite
            if (tecla == 8) {
                return true;
            }

            // Patron de entrada, en este caso solo acepta numeros y letras
            patron = /[0-9]/;
            tecla_final = String.fromCharCode(tecla);
            return patron.test(tecla_final);
            break;
        case 2: //Solo numeros y guion
            tecla = document.all ? e.keyCode : e.which;

            //Tecla de retroceso para borrar, siempre la permite
            if (tecla == 8) {
                return true;
            }

            // Patron de entrada, en este caso solo acepta numeros y letras
            patron = /[0-9,-]/;
            tecla_final = String.fromCharCode(tecla);
            return patron.test(tecla_final);
            break;
    }
}
//Validación que ponga un guión en el número de telefono
function guionTelefono(e, componente) {
    tecla = document.all ? e.keyCode : e.which;
    let numero = componente.value;
    let numeroi = numero;
    let ncaracteres = 0;
    ncaracteres = numero.length;
    if (ncaracteres == 4 && tecla != 8) {
        componente.value = "";
        componente.value = numeroi + "-";
    }
}
//Validación que ponga el guión en el NIT
function guionNIT(e, componente) {
    tecla = document.all ? e.keyCode : e.which;
    let numero = componente.value;
    let numeroi = numero;
    let ncaracteres = 0;
    ncaracteres = numero.length;
    if (ncaracteres == 4 && tecla != 8) {
        componente.value = "";
        componente.value = numeroi + "-";
    } else if (ncaracteres == 11 && tecla != 8) {
        componente.value = "";
        componente.value = numeroi + "-";
    } else if (ncaracteres == 15 && tecla != 8) {
        componente.value = "";
        componente.value = numeroi + "-";
    }
}
//Solo letras
function soloLetras(e, caso) {
    switch (caso) {
        case 1: //Solo letras
            tecla = document.all ? e.keyCode : e.which;
            //Tecla de retroceso para borrar, siempre la permite
            if (tecla == 8) {
                return true;
            }
            // Patron de entrada, en este caso solo acepta numeros y letras
            const patron = new RegExp("^[a-zA-Zñ.\u00E0-\u00FC ]+$");
            tecla_final = String.fromCharCode(tecla);
            return patron.test(tecla_final);
            break;
    }
}
//Quitar espacios en blanco atras y adelante de los textos
function sinEspaciosAD(cadena) {
    console.log(cadena.trim());
    return cadena.trim();
}

//Validación que ponga el guión en el DUI
function guionDUI(e, componente) {
    tecla = document.all ? e.keyCode : e.which;
    let numero = componente.value;
    let numeroi = numero;
    let ncaracteres = 0;
    ncaracteres = numero.length;
    if (ncaracteres == 8 && tecla != 8) {
        componente.value = "";
        componente.value = numeroi + "-";
    }
}

//Función para validar una fecha
function validarFechaJS(caso, fecha) {
    let validate;
    switch (caso) {
        case 1: //Validar que no sea mayor a la actual
            let hoy = new Date();

            let mes = (hoy.getMonth() + 1).toString();
            if (mes.length <= 1) {
                mes = "0" + mes;
            }

            let dia = hoy.getDate().toString();
            if (dia.length <= 1) {
                dia = "0" + dia;
            }

            let fechaActual = hoy.getFullYear() + "-" + mes + "-" + dia;
            (fecha>=fechaActual) ? validate = true : validate = false;
            return validate;
            break;
        default:
            break;
    }
}
