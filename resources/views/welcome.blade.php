@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <!-- Sección de banner -->
        <section id="banner" style="background-size: cover; background-position: center;">
            <center><img src="{{ asset('imagenes/Fondo.jpg') }}" alt="Banner Image" style="width: 200px; height: 200px;"></center>
        </section>

        <style>
            .DESC, .INT, .DESCB, .ESC {
                font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
            }

            .btn-primary {
                background-color: #2dc830;
                padding: 20px;
                color: #ffffff;
                font-size: 18px;
                border: none;
                border-radius: 5px;
                transition: background-color 0.3s ease, transform 0.3s ease;
                margin: 10px; /* Aumenta el espacio entre los botones */
            }

            .btn-primary:hover {
                background-color: #249a25; /* Cambia el color de fondo en hover */
                transform: scale(1.05); /* Aumenta el tamaño ligeramente */
            }

            .btn-primary:active {
                transform: scale(0.95); /* Reduce el tamaño ligeramente al hacer clic */
            }
        </style>

        <!-- Sección de bienvenida -->
        <section id="bienvenida" style="background-color: #ececec; padding: 10px; color: #000000;">
            <center><h1 class="INT">Bienvenidos a Acceso UT</h1></center>
            <center><h2 class="DESC">
                Este sistema ha sido diseñado para optimizar el acceso a las instalaciones mediante la verificación de la identidad del alumno a través del escaneo del código QR en su credencial estudiantil, 
                o buscando sus datos en la base de datos de estudiantes. Además, permite verificar la identidad de los visitantes y registrar el motivo de su visita, 
                proporcionando un control eficiente para cualquier persona ajena a la universidad.
            </h2></center>
        </section>

        <!-- Sección de botones -->
        <section id="botones" style="background-color: #ececec; padding: 10px;">
            <center><h1 class="DESCB">Escoje a cual tabla de las pagina de usuarios deseas ir: </h1></center>
            <div class="text-center mt-5">
                <a href="{{ route('InicioGuardia') }}" class="btn btn-primary btn-lg">Pagina de Guardia de Seguridad</a>
                <a href="{{ route('InicioRecursos') }}" class="btn btn-primary btn-lg">Pagina de Recursos Humanos</a>
                <a href="{{ route('InicioDireccion') }}" class="btn btn-primary btn-lg">Pagina de Direccion Academica</a>
            </div>
        </section>
    </div>
@endsection
