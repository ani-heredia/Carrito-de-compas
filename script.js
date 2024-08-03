const formulario = document.getElementById('formulario');
const tituloInput = document.getElementById('titulo');
const generoInput = document.getElementById('genero');
const anioInput = document.getElementById('anio');
const agregarButton = document.getElementById('agregar');
const comprarButton = document.getElementById('comprar');
const listaPeliculas = document.getElementById('listaPeliculas');
const mensajeElement = document.getElementById('mensaje');

// Simulación de base de datos local
let peliculas = [];

// Función para mostrar las películas en la lista
function mostrarPeliculas() {
    listaPeliculas.innerHTML = '';
    peliculas.forEach((pelicula, index) => {
        const li = document.createElement('li');
        li.textContent = `${pelicula.titulo} - ${pelicula.genero} - ${pelicula.anio}`;

        const botonEliminar = document.createElement('button');
        botonEliminar.textContent = 'Eliminar';
        botonEliminar.addEventListener('click', () => eliminarPelicula(index));

        const botonActualizar = document.createElement('button');
        botonActualizar.textContent = 'Actualizar';
        botonActualizar.addEventListener('click', () => actualizarPelicula(index));

        li.appendChild(botonEliminar);
        listaPeliculas.appendChild(li);

        li.appendChild(botonActualizar);
        listaPeliculas.appendChild(li);
    });
}

// Función para agregar una nueva película
function agregarPelicula(titulo, genero, anio) {
    const nuevaPelicula = { titulo, genero, anio };
    peliculas.push(nuevaPelicula);
    mostrarPeliculas();
}

// Función para eliminar una película
function eliminarPelicula(index) {
    peliculas.splice(index, 1);
    mostrarPeliculas();
}

// Evento al hacer clic en el botón Agregar Película
agregarButton.addEventListener('click', () => {
    const titulo = tituloInput.value;
    const genero = generoInput.value;
    const anio = parseInt(anioInput.value);
    if (titulo.trim() !== '' && genero.trim() !== '' && !isNaN(anio)) {
        agregarPelicula(titulo, genero, anio);
        tituloInput.value = '';
        generoInput.value = '';
        anioInput.value = '';
    }
});

// Evento al hacer clic en el botón Comprar
comprarButton.addEventListener('click', () => {
    mensajeElement.textContent = '¡Compra exitosa! ¡Disfruta de tus películas!';
});

// Inicialización: mostrar películas al cargar la página
mostrarPeliculas();