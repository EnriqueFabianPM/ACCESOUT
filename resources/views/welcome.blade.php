@extends('layouts.app')

@section('content')
    <div class="container mt-4" >
        <!-- Example content sections -->
        <section id="banner" style=" background-size: cover; background-position: center;">
            <center><img src="{{ asset('imagenes/Fondo.jpg') }}" alt="Banner Image" style="width: 200; height: 200px;"> </center>
        </section>
        <style>
            .DESC{
                font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;

            }
            .INT{
                font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
            }
            .DESCB{
                font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
            }
            .ESC{
                font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
            }

        </style>
        <section id="bienvenida" style="background-color: #ececec; padding: 10px; color: #000000;">
            <center><h1 class="INT">Bienvenidos a Acceso UTSC</h1> </center>
            <center><h2 class="DESC">Este sistema ha sido diseñado para optimizar el acceso a las instalaciones mediante la verificación de la identidad del alumno a través del escaneo del código QR en su credencial estudiantil, 
                o buscando sus datos en la base de datos de estudiantes. Además, permite verificar la identidad de los visitantes y registrar el motivo de su visita, 
                proporcionando un control eficiente para cualquier persona ajena a la universidad.
            </h2><center>
        </section>
        <section id="botones" style="background-color: #ececec; padding: 10px;">
            <center><h1 class="ESC">Escoje a cual tabla de registros deseas ir: </h1></center>
            <div class="text-center mt-5">
                <a href="{{ route('estudiantes.index') }}" style="background-color: #2dc830; padding: 20px; color: #ffffff;" class="btn btn-primary btn-lg mr-3">Tabla de Estudiantes</a>
                <a href="{{ route('empleados.index') }}" style="background-color: #2dc830; padding: 20px; color: #ffffff;" class="btn btn-primary btn-lg mr-3">Tabla de Empleados</a>
                <a href="{{ route('visitantes.index') }}" style="background-color: #2dc830; padding: 20px; color: #ffffff;" class="btn btn-primary btn-lg">Tabla de Visitantes</a>
            </div>
            <center><h1 class="DESCB">Ir a la pagina del Guardia de seguridad: </h1></center>
            <div class="text-center mt-5">
                <a href="{{ route('InicioGuardia') }}" style="background-color: #2dc830; padding: 20px; color: #ffffff;" class="btn btn-primary btn-lg mr-3">Pagina de Guardia de Seguridad</a>
            </div>
        </section>
        <!--
        <section id="MISION">
            
        </section>

        <section id="VISION">
            
        </section>

        <section id="VALORES">
            
        </section>

        <section id="AVANCES">
            <!-- Avances content 
        </section>

        <section id="SOBRENOSOTROS">
            <!-- Sobre nosotros content 
        </section>
        -->
    </div>
@endsection
