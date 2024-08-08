@extends('pdf.base-pdf')

@section('title')
    {{ 'CV - '.$user_map['nombre_completo'] }}
@endsection

@section('content')

@php
    use Carbon\Carbon;
@endphp

<p class="text-2xl" style="text-align: center;">{{ $user_map['nombre_completo'] }}</p> 
<p class="text-base" style="text-align: center;">{{ $user_map['cv']['informacion_contacto']['correo_electronico'] }} &middot; {{ $user_map['telefono'] }}</p>

<br><br>
<p class="text-2xl" style="text-align: center;">Acerca de</p> 
<div class="divider"></div>
<p class="text-base text-left">{!! nl2br(e($user_map['cv']['resumen'])) !!}</p>

<br><br>
<p class="text-2xl" style="text-align: center;">Educación</p> 
<div class="divider"></div>

@foreach($user_map['cv']['formacion_academica'] as $formacion_academica)
    <p class="text-lg text-left font-semibold" style="width: 635px;">{{ $formacion_academica['institucion'] }}</p>
    <table class="table-without-borders">
        <tbody>
            <tr>
                <td class="text-base text-left" style="width: 317.5px;">{{ $formacion_academica['titulo'] }}</td>
                <td class="text-base text-right" style="width: 317.5px;">{{ Carbon::parse($formacion_academica['desde'])->translatedFormat('d F Y') }} - {{ Carbon::parse($formacion_academica['hasta'])->translatedFormat('d F Y') }}</td>
            </tr>
        </tbody>
    </table>
    <p class="text-base text-left" style="width: 635px;">{{ $formacion_academica['descripcion'] }}</p>
    <br>
@endforeach

<br>
<p class="text-2xl" style="text-align: center;">Habilidades profesionales</p> 
<div class="divider"></div>
<table class="table-without-borders">
    <tbody>
        @foreach(array_chunk($user_map['cv']['habilidades_profesionales'], 4) as $habilidades_chunk)
            <tr>
                @foreach($habilidades_chunk as $habilidades_profesionales)
                    <td class="text-base text-left" style="width: 158.75px;">&middot; {!! nl2br(e($habilidades_profesionales['nombre'])) !!}</td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>

<br><br>
<p class="text-2xl" style="text-align: center;">Habilidades blandas</p> 
<div class="divider"></div>
<table class="table-without-borders">
    <tbody>
        @foreach(array_chunk($user_map['cv']['habilidades_blandas'], 4) as $habilidades_chunk)
            <tr>
                @foreach($habilidades_chunk as $habilidades_blandas)
                    <td class="text-base text-left" style="width: 158.75px;">&middot; {!! nl2br(e($habilidades_blandas['nombre'])) !!}</td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>

<br><br>
<p class="text-2xl" style="text-align: center;">Experiencia profesional</p> 
<div class="divider"></div>
@foreach($user_map['cv']['experiencia_laboral'] as $experiencia_laboral)
    <table class="table-without-borders">
        <tbody>
            <tr>
                <td class="text-lg text-left font-semibold" style="width: 317.5px;">{{ $experiencia_laboral['empresa'] }}</td>
                <td class="text-base text-right" style="width: 317.5px;">{{ $experiencia_laboral['ubicacion_empresa'] }}</td>
            </tr>
            <tr>
                <td class="text-base text-left text-italic" style="width: 317.5px;">{{ $experiencia_laboral['puesto'] }}</td>
                <td class="text-base text-right" style="width: 317.5px;">{{ Carbon::parse($experiencia_laboral['desde'])->translatedFormat('d F Y') }} - {{ Carbon::parse($experiencia_laboral['hasta'])->translatedFormat('d F Y') }}</td>
            </tr>
        </tbody>
    </table>
    <p class="text-base text-left pl-4" style="width: 635px;">{!! nl2br($experiencia_laboral['descripcion']) !!}</p>
    <br>
@endforeach

<br>
<p class="text-2xl" style="text-align: center;">Certificaciones</p> 
<div class="divider"></div>
<table class="table-without-borders">
    <tbody>
        @foreach($user_map['cv']['certificaciones'] as $certificaciones)
        <tr>
            <td class="text-base text-left" style="width: 495%;">&middot; {{ $certificaciones['certificado'] }}, {{ $certificaciones['certificado'] }}</td>
            <td class="text-base text-right" style="width: 140px">{{ Carbon::parse($certificaciones['fecha'])->translatedFormat('d F Y') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<br><br>
<p class="text-2xl" style="text-align: center;">Idiomas</p> 
<div class="divider"></div>
@foreach($user_map['cv']['idiomas'] as $idiomas)
    <p class="text-base text-left" style="width: 495%;">&middot; {{ $idiomas['idioma'] }} - {{ $idiomas['nivel'] }}</p>
@endforeach

<x-footer-table :fechaActual="$fecha_actual"/>

@endsection