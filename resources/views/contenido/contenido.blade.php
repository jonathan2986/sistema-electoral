@extends('layout')
@section('contenido')


            <template v-if="menu==0">
                <h1>Escritorio</h1>
            </template>

            <template v-if="menu==1">
                <provincias></provincias>
            </template>

            <template v-if="menu==2">
                <circunscripcion></circunscripcion>
            </template>

            <template v-if="menu==3">
                <municipio></municipio>
{{--                <recintos></recintos>--}}
{{--                <colegios-electorales></colegios-electorales>--}}
            </template>
            <template v-if="menu=='distritos'">
                @if(auth()->user()->canAction('Admin'))
                    <distritos></distritos>
                @else
                    <distritos permision-condition="{{auth()->user()->votantes->municipios_id}}"></distritos>
                @endif
            </template>
            <template v-if="menu=='recintos'">
                @if(auth()->user()->canAction('Admin'))
                    <recintos></recintos>
                @elseif(auth()->user()->canAction('Coordinador de Distrito')) 
                    <recintos field="distritos_id" permision-condition="{{auth()->user()->votantes->distritos_id}}" ></recintos>
                @elseif(auth()->user()->canAction('Coordinador de Municipio'))
                    <recintos permision-condition="{{auth()->user()->votantes->municipios_id}}" ></recintos>
                @endif
            </template>
            <template v-if="menu=='colegios-electorales'">
                @if(auth()->user()->canAction('Admin'))
                    <colegios-electorales></colegios-electorales>
                @elseif(auth()->user()->canAction('Coordinador de Recinto')) 
                    <colegios-electorales permision-condition="{{auth()->user()->votantes->recintos_id}}" ></colegios-electorales>
                @endif
            </template>
            <template v-if="menu=='personas'">
                <personas></personas>
            </template>
            <template v-if="menu=='votantes'">
                @if(auth()->user()->canAction('Admin'))
                    <votantes></votantes>
                @elseif(auth()->user()->canAction('Coordinador de Colegio'))
                    <votantes permision-condition="{{auth()->user()->votantes->colegios_electorales_id}}"></votantes>
                @endif
            </template>
            <template v-if="menu=='users'">
                <users></users>
            </template>
            <template v-if="menu==4">
                <usuarios></usuarios>
            </template>

            <template v-if="menu==5">
                <users></users>
            </template>

            <template v-if="menu==6">
                <roles></roles>
            </template>

            <template v-if="menu==7">
                <partidos></partidos>
            </template>

            <template v-if="menu==8">
                <candidatos></candidatos>
            </template>

            <template v-if="menu==9">
                <votos></votos>
            </template>

            <template v-if="menu==10">
                <electores></electores>
            </template>

            <template v-if="menu==11">
                <h1>Contenido del menú 11</h1>
            </template>

            <template v-if="menu==12">
                <h1>Contenido del menú 12</h1>
            </template>




@endsection
