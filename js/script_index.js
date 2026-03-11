//1. paso #1: Capturamos elementos del DOM
//DOM : Document Object Model

const caja_nombre = document.getElementById("Caja_nombre");
const btn_saludar = document.getElementById("btn_saludar");
const mensaje = document.getElementById("mensaje");

//2. Creamos la Funcion

function saludar(){
    //Registrando el dato desde el DOM
    let nombre = caja_nombre.value;
    //Mostramos el mensaje
    console.log('Hola ' + nombre + ', Bienvenido a la Programacion');


    //3.Mostrar todo el DOM
    mensaje.textContent = "Hola " + nombre + ", Bienvenido a la Programacion";  
}