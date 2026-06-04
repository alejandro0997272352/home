<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutorías Académicas - Encuentra al tutor perfecto</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        .hero-gradient { background: linear-gradient(135deg, #1e1b4b 0%, #312e81 30%, #4338ca 60%, #6366f1 100%); }
        .glass { background: rgba(255,255,255,0.1); backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.2); }
        .float { animation: float 6s ease-in-out infinite; }
        @keyframes float { 0%, 100% { transform: translateY(0px); } 50% { transform: translateY(-20px); } }
    </style>
</head>
<body class="font-sans antialiased">

    <nav class="fixed top-0 left-0 right-0 z-50 glass">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-9 w-9 rounded-full object-cover">
                    <span class="font-bold text-xl text-white">Tutorías Académicas</span>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('login') }}" class="text-white/80 hover:text-white transition-colors px-4 py-2 text-sm font-medium">Iniciar Sesión</a>
<a href="{{ route('register') }}" class="bg-white text-indigo-700 px-5 py-2 rounded-full text-sm font-semibold hover:bg-indigo-50 transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5">
    Registrarse
</a>
                </div>
            </div>
        </div>
    </nav>

    <section class="hero-gradient min-h-screen flex items-center relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-20 left-10 w-72 h-72 bg-purple-400 rounded-full mix-blend-multiply filter blur-3xl animate-pulse"></div>
            <div class="absolute top-40 right-20 w-96 h-96 bg-indigo-400 rounded-full mix-blend-multiply filter blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
            <div class="absolute bottom-20 left-1/3 w-80 h-80 bg-pink-400 rounded-full mix-blend-multiply filter blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 relative z-10">
            <div class="grid lg:grid-cols-2 gap-12 items-center py-32">
                <div class="hidden lg:flex justify-center items-center order-2">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-96 h-96 rounded-3xl object-cover shadow-2xl float">
                </div>
                <div class="text-center lg:text-left order-1">
                    <div class="inline-flex items-center bg-white/10 rounded-full px-4 py-1.5 text-white/80 text-sm mb-6">
                        <i class="fas fa-star text-yellow-400 mr-2"></i>
                        Plataforma educativa #1
                    </div>
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-white leading-tight">
                        Encuentra al
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-300 to-pink-300">tutor perfecto</span>
                        para ti
                    </h1>
                    <p class="text-lg text-indigo-200 mt-6 max-w-xl">
                        Conectamos estudiantes con tutores calificados. Aprende a tu ritmo, elige horarios flexibles y alcanza tus metas académicas.
                    </p>
                    <div class="flex flex-wrap gap-4 mt-8 justify-center lg:justify-start">
                        <a href="{{ route('register') }}" class="bg-white text-indigo-700 px-8 py-3.5 rounded-full font-semibold text-lg hover:bg-indigo-50 transition-all shadow-2xl hover:shadow-3xl hover:-translate-y-1 flex items-center gap-2">
                            <i class="fas fa-user-plus"></i> Comienza Gratis
                        </a>
                        <a href="#como-funciona" class="glass text-white px-8 py-3.5 rounded-full font-semibold text-lg hover:bg-white/20 transition-all flex items-center gap-2">
                            <i class="fas fa-play-circle"></i> Ver Cómo Funciona
                        </a>
                    </div>
                    <div class="flex items-center gap-8 mt-10 justify-center lg:justify-start">
                        <div class="text-center">
                            <p class="text-3xl font-bold text-white">50+</p>
                            <p class="text-indigo-200 text-sm">Tutores</p>
                        </div>
                        <div class="text-center">
                            <p class="text-3xl font-bold text-white">200+</p>
                            <p class="text-indigo-200 text-sm">Estudiantes</p>
                        </div>
                        <div class="text-center">
                            <p class="text-3xl font-bold text-white">500+</p>
                            <p class="text-indigo-200 text-sm">Tutorías</p>
                        </div>
                    </div>
                </div>
                <div class="hidden lg:flex justify-center">
                    <div class="relative float">
                        <div class="w-96 h-96 bg-gradient-to-br from-indigo-400 to-purple-600 rounded-3xl rotate-6 shadow-2xl"></div>
                        <div class="absolute -bottom-6 -left-6 glass rounded-2xl p-6 max-w-xs">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-10 h-10 bg-green-400 rounded-full flex items-center justify-center"><i class="fas fa-check text-white"></i></div>
                                <div>
                                    <p class="text-white font-semibold">Tutoría Confirmada</p>
                                    <p class="text-indigo-200 text-sm">Cálculo Diferencial</p>
                                </div>
                            </div>
                            <div class="w-full bg-white/20 rounded-full h-2"><div class="w-3/4 bg-green-400 h-2 rounded-full"></div></div>
                            <p class="text-indigo-200 text-xs mt-2">Progreso de la sesión</p>
                        </div>
                        <div class="absolute -top-4 -right-4 glass rounded-full p-3">
                            <i class="fas fa-star text-yellow-400 text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="como-funciona" class="py-24 bg-gradient-to-b from-gray-50 to-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900">¿Cómo funciona?</h2>
                <p class="text-lg text-gray-600 mt-4 max-w-2xl mx-auto">Encuentra el tutor ideal en tres simples pasos</p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white rounded-2xl shadow-lg p-8 text-center">
                    <div class="w-16 h-16 bg-gradient-to-br from-indigo-100 to-indigo-200 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-search text-2xl text-indigo-600"></i>
                    </div>
                    <div class="text-4xl font-bold text-indigo-200 mb-4">01</div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Busca tutores</h3>
                    <p class="text-gray-600">Explora nuestra lista de tutores calificados, filtra por materia y encuentra al que mejor se adapte a ti.</p>
                </div>
                <div class="bg-white rounded-2xl shadow-lg p-8 text-center">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-100 to-purple-200 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-calendar-alt text-2xl text-purple-600"></i>
                    </div>
                    <div class="text-4xl font-bold text-purple-200 mb-4">02</div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Agenda una cita</h3>
                    <p class="text-gray-600">Selecciona el horario que mejor te acomode. Los tutores publican su disponibilidad para que elijas.</p>
                </div>
                <div class="bg-white rounded-2xl shadow-lg p-8 text-center">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-100 to-green-200 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-graduation-cap text-2xl text-green-600"></i>
                    </div>
                    <div class="text-4xl font-bold text-green-200 mb-4">03</div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Aprende y mejora</h3>
                    <p class="text-gray-600">Recibe tutoría personalizada, ya sea presencial o en línea, y alcanza tus metas académicas.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900">¿Por qué elegirnos?</h2>
                <p class="text-lg text-gray-600 mt-4 max-w-2xl mx-auto">Todo lo que necesitas para potenciar tu aprendizaje</p>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="p-6 rounded-xl bg-gradient-to-br from-indigo-50 to-indigo-100">
                    <div class="w-12 h-12 bg-indigo-600 rounded-xl flex items-center justify-center mb-4"><i class="fas fa-user-check text-white text-xl"></i></div>
                    <h3 class="font-semibold text-gray-900 mb-2">Tutores Verificados</h3>
                    <p class="text-gray-600 text-sm">Todos nuestros tutores pasan por un proceso de verificación.</p>
                </div>
                <div class="p-6 rounded-xl bg-gradient-to-br from-purple-50 to-purple-100">
                    <div class="w-12 h-12 bg-purple-600 rounded-xl flex items-center justify-center mb-4"><i class="fas fa-clock text-white text-xl"></i></div>
                    <h3 class="font-semibold text-gray-900 mb-2">Horarios Flexibles</h3>
                    <p class="text-gray-600 text-sm">Elige el horario que mejor se adapte a tu rutina diaria.</p>
                </div>
                <div class="p-6 rounded-xl bg-gradient-to-br from-green-50 to-green-100">
                    <div class="w-12 h-12 bg-green-600 rounded-xl flex items-center justify-center mb-4"><i class="fas fa-star text-white text-xl"></i></div>
                    <h3 class="font-semibold text-gray-900 mb-2">Calificaciones</h3>
                    <p class="text-gray-600 text-sm">Lee reseñas de otros estudiantes antes de elegir tutor.</p>
                </div>
                <div class="p-6 rounded-xl bg-gradient-to-br from-amber-50 to-amber-100">
                    <div class="w-12 h-12 bg-amber-600 rounded-xl flex items-center justify-center mb-4"><i class="fas fa-laptop text-white text-xl"></i></div>
                    <h3 class="font-semibold text-gray-900 mb-2">Online o Presencial</h3>
                    <p class="text-gray-600 text-sm">Tutorías en línea o presenciales según tu preferencia.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-24 bg-gradient-to-br from-indigo-600 to-purple-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 text-center">
            <h2 class="text-3xl sm:text-4xl font-bold text-white mb-6">Listo para empezar?</h2>
            <p class="text-xl text-indigo-200 mb-8 max-w-2xl mx-auto">Únete a nuestra comunidad y lleva tu aprendizaje al siguiente nivel.</p>
            <a href="{{ route('register') }}" class="inline-flex items-center gap-2 bg-white text-indigo-700 px-8 py-4 rounded-full font-semibold text-lg hover:bg-indigo-50 transition-all shadow-xl hover:shadow-2xl hover:-translate-y-1">
                <i class="fas fa-rocket"></i> Crear Cuenta Gratis
            </a>
        </div>
    </section>

    <footer class="bg-gray-900 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-graduation-cap text-2xl text-indigo-400"></i>
                    <span class="font-bold text-xl text-white">Tutorías Académicas</span>
                </div>
                <p class="text-gray-400 text-sm">&copy; {{ date('Y') }} Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

</body>
</html>
