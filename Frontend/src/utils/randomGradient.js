/**
 * @module randomGradient
 * @author Adrian Manso
 */

/**
 * Genera un color aleatorio en formato hexadecimal.
 * @returns {string} Color aleatorio en formato hexadecimal.
 */

function generateRandomColor() { // genera un color aleatorio en formato hexadecimal
    const r = Math.floor(Math.random() * 256); // genera un número aleatorio entre 0 y 255
    const g = Math.floor(Math.random() * 256);
    const b = Math.floor(Math.random() * 256);
    return '#' + r.toString(16).padStart(2, '0') + g.toString(16).padStart(2, '0') + b.toString(16).padStart(2, '0'); // devuelve el color en formato hexadecimal
}

/**
 * Cambia el fondo del elemento con id 'gradient-box' a un gradiente aleatorio.
 * @returns {string} Valor CSS del gradiente aleatorio.
 */

export const  setRandomGradient = () => { // cambia el fondo del elemento con id 'gradient-box' a un gradiente aleatorio
    const fromColor = generateRandomColor();
    const toColor = generateRandomColor();
    const gradient = `linear-gradient(to right, ${fromColor}, ${toColor})`;
    return gradient;
}


