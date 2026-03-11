let contador = localStorage.getItem("contador");

contador = contador ? parseInt(contador) : 0;

const conteo = document.getElementById("contador");

conteo.textContent = contador;



function actualizarConteo(valor) {
    contador += valor;

    localStorage.setItem("contador", contador);

    conteo.textContent = contador;
}

function reducir () {
    actualizarConteo(-1);
}

function aumentar () {
    actualizarConteo(+1);
}

function resetear () {
    contador = 0;
    localStorage.setItem("contador", contador);
    conteo.textContent = contador;
}

console.log("Contador actual: " + contador);