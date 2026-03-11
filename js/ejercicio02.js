//PASO #1: Declarar un Array con 5 lenguajes de programacion

const lenguajes = ["JavaScript", "Python", "Java", "C++", "PHP"];

//Paso #2: Capturar el elemento del DOM

const lista = document.getElementById("lista");

let elementos = "";

// PASO #3: Usamos el bucle for para recorrer el Array

for(let i = 0; i < lenguajes.length; i++){
    if(lenguajes[i] === "JavaScript"){
        alert("Encontramos JavaScript en el Array");
    } 
    //Paso #4: Agregar cada lenguaje al elemento del DOM
    elementos += "<li>" + lenguajes[i] + "</li>";
}
//Paso #5: Mostrar el resultado en el DOM
lista.innerHTML = elementos;