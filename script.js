// Base de datos de Stock
const stockZapatos = [
    {
        id: 101,
        nombre: "Nike Air Max 270",
        categoria: "Urbano",
        precio: 150.00,
        descripcion: "Amortiguación premium para el uso diario.",
        imagen: "https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=600",
        stock: 12
    },
    {
        id: 102,
        nombre: "Adidas Ultraboost",
        categoria: "Running",
        precio: 180.00,
        descripcion: "Energía infinita para tus carreras.",
        imagen: "https://images.unsplash.com/photo-1587563871167-1ee9c731aefb?w=600",
        stock: 8
    },
    {
        id: 103,
        nombre: "Botas Timberland Pro",
        categoria: "Trabajo",
        precio: 210.00,
        descripcion: "Resistencia y durabilidad en todo terreno.",
        imagen: "https://images.unsplash.com/photo-1520639889410-d65c36fcf953?w=600",
        stock: 5
    },
    {
        id: 104,
        nombre: "Converse Chuck Taylor",
        categoria: "Clásico",
        precio: 65.00,
        descripcion: "El estilo que nunca pasa de moda.",
        imagen: "https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a?w=600",
        stock: 20
    }
];

// Función para mostrar los productos
const contenedor = document.getElementById('product-list');

stockZapatos.forEach(zapato => {
    contenedor.innerHTML += `
        <div class="zapato-card">
            <div class="etiqueta">${zapato.categoria}</div>
            <img src="${zapato.imagen}" alt="${zapato.nombre}">
            <div class="info">
                <h3>${zapato.nombre}</h3>
                <p class="desc">${zapato.descripcion}</p>
                <div class="footer-card">
                    <span class="precio">$${zapato.precio.toFixed(2)}</span>
                    <span class="stock-info">${zapato.stock} disponibles</span>
                </div>
                <button class="btn-comprar">Ver Detalle</button>
            </div>
        </div>
    `;
});