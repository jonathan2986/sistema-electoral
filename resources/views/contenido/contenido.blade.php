@extends('layout')
@section('contenido')

    @if (Auth::check())
        @if (Auth::user()->idrol == 1)
            <template v-if="menu==0">
                <h1>Escritorio</h1>
            </template>

            <template v-if="menu==1">
                <colegios></colegios>
            </template>

            <template v-if="menu==2">
                <recintos></recintos>
            </template>

            <template v-if="menu==3">
                <colegios-electorales></colegios-electorales>
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
                <electores></electores>
            </template>

            <template v-if="menu==10">
                <h1>Acerca de</h1>
            </template>

            <template v-if="menu==11">
                <h1>Contenido del menú 11</h1>
            </template>

            <template v-if="menu==12">
                <h1>Contenido del menú 12</h1>
            </template>
        @elseif (Auth::user()->idrol == 2)
            <template v-if="menu==0">
                <h1>Escritorio</h1>
            </template>

            <template v-if="menu==1">
                <colegios></colegios>
            </template>

            <template v-if="menu==2">
                <recintos></recintos>
            </template>

            <template v-if="menu==3">
                <colegios-electorales></colegios-electorales>
            </template>

            <template v-if="menu==4">
                <usuarios></usuarios>
            </template>
            <template v-if="menu==7">
                <h1>Reportes</h1>
            </template>

            <template v-if="menu==8">
                <h1>Otros reportes</h1>
            </template>

            <template v-if="menu==9">
                <electores></electores>
            </template>

            <template v-if="menu==10">
                <h1>Acerca de</h1>
            </template>

            <template v-if="menu==11">
                <h1>Contenido del menú 11</h1>
            </template>

            <template v-if="menu==12">
                <h1>Contenido del menú 12</h1>
            </template>
        @endif
    @endif



@endsection
