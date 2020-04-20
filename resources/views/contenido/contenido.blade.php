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
                @if(auth()->user()->canAction('Admin') || auth()->user()->canAction('Digitador') || auth()->user()->canAction('Digitador'))
                    <distritos></distritos>
                @else
                    <distritos permision-condition="{{auth()->user()->votantes->municipios_id}}"></distritos>
                @endif
            </template>
            <template v-if="menu=='recintos-municipios'">
                @if(auth()->user()->canAction('Admin') || auth()->user()->canAction('Digitador'))
                    <component :is="menu"></component>
                @elseif(auth()->user()->canAction('Coordinador de Distrito')) 
                    <component :is="menu" field="distritos_id" permision-condition="{{implode(',', auth()->user()->getEntitiesId('Coordinador de Distrito'))}}" ></component>
                @endif
            </template>
            <template v-if="menu =='recintos-distritos'">
                @if(auth()->user()->canAction('Admin') || auth()->user()->canAction('Digitador'))
                    <recintos-distritos></recintos-distritos>
                @elseif(auth()->user()->canAction('Coordinador de Municipio'))
                    <recintos-distritos permision-condition="{{implode(',', auth()->user()->getEntitiesId('Coordinador de Municipio'))}}"></recintos-distritos>
                @endif
            </template>
            <template v-if="menu=='colegios-electorales'">
                @if(auth()->user()->canAction('Admin') || auth()->user()->canAction('Digitador'))
                    <colegios-electorales></colegios-electorales>
                @elseif(auth()->user()->canAction('Coordinador de Recinto')) 
                    <colegios-electorales permision-condition="{{implode(',', auth()->user()->getEntitiesId('Coordinador de Recinto'))}}" ></colegios-electorales>
                @endif
            </template>
            <template v-if="menu=='personas'">
                <personas></personas>
            </template>
            <template v-if="menu=='votantes'">
                @if(auth()->user()->canAction('Admin') || auth()->user()->canAction('Digitador'))
                    <votantes></votantes>
                @elseif(auth()->user()->canAction('Coordinador de Colegio'))
                    <votantes permision-condition="{{implode(',', auth()->user()->getEntitiesId('Coordinador de Colegio'))}}"></votantes>
                @endif
            </template>
            <template v-if="menu=='users'">
                <users></users>
            </template>
            <template v-if="menu=='roles_users'">
                <roles-users></roles-users>
            </template>
            <template v-if="menu=='comites_bases'">
                <comites-bases></comites-bases>
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
