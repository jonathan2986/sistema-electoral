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
                <distritos></distritos>
            </template>
            <template v-if="menu=='recintos'">
                <recintos></recintos>
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
