<template>
    <main class="main">
        <!-- Breadcrumb -->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Home</li>
            <li class="breadcrumb-item"><a href="#">Admin</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
        <div class="container-fluid">
            <!-- Ejemplo de tabla Listado -->
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> Provincias
                    <button type="button" @click="abrirModal('provincia','registrar')" class="btn btn-secondary">
                        <i class="icon-plus"></i>&nbsp;Nuevo
                    </button>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <select class="form-control col-md-3" v-model="criterio">
                                    <option value="nombre">Nombre</option>
                                    <option value="cantidad">Cantidad de Municipio</option>
                                </select>
                                <input type="text" v-model="buscar" @keyup.enter="listarProvincias()" class="form-control" placeholder="Texto a buscar">
                                <button type="submit" @click="listarProvincias()" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                        <tr>
                            <th>Opciones</th>
                            <th>Provincias</th>
                            <th>Cantidad de Municipios</th>
                            <th>Estado</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="provincia in arrayProvincias" :key="provincia.id">
                            <td>
                                <button type="button" @click="abrirModal('provincia','actualizar', provincia)" class="btn btn-warning btn-sm">
                                    <i class="icon-pencil"></i>
                                </button> &nbsp;
                                <template>
                                    <button type="button" class="btn btn-danger btn-sm">
                                        <i class="icon-trash"></i>
                                    </button>
                                </template>
                                <template>
                                    <button type="button" class="btn btn-info btn-sm">
                                        <i class="icon-check"></i>
                                    </button>
                                </template>
                            </td>
                            <td v-text="provincia.nombre"></td>
                            <td v-text="provincia.cantidadMunicipio"></td>
                            <td>
                                <div>
                                    <span class="badge badge-success">Activo</span>
                                </div>
                                <div>
                                    <span class="badge badge-danger">Desactivado</span>
                                </div>

                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <nav>
                        <ul class="pagination">
                            <li class="page-item" v-if="pagination.current_page > 1">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                            </li>
                            <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                            </li>
                            <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Sig</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <!-- Fin ejemplo de tabla Listado -->
        </div>
        <!--Inicio del modal agregar/actualizar-->
        <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-primary modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" v-text="tituloModal"></h4>
                        <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Provincia</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="nombre" class="form-control" placeholder="Nombre de la Provincia">

                                </div>
                            </div>
                            <div v-show="errorProvincia" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjProvincia" :key="error" v-text="error">

                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                        <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarProvincia()">Guardar</button>
                        <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarCategoria()">Actualizar</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!--Fin del modal-->
    </main>
</template>

<script>
    export default {
        data (){
            return {
                provincia_id: 0,
                nombre : '',
                cantidadMunicipio : '',
                arrayProvincias : [
                    {
                        nombre: 'Santiago',
                        cantidadMunicipio: 4
                    }
                ],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorProvincia : 0,
                errorMostrarMsjProvincia : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'nombre',
                buscar : ''
            }
        },
        computed:{
            isActived: function(){
                return this.pagination.current_page;
            },
            //Calcula los elementos de la paginación
            pagesNumber: function() {
                if(!this.pagination.to) {
                    return [];
                }

                var from = this.pagination.current_page - this.offset;
                if(from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2);
                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }

                var pagesArray = [];
                while(from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;

            }
        },
        methods : {
            // listarProvincias (page,buscar,criterio){
            //     let me=this;
            //     var url= '/categoria?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
            //     axios.get(url).then(function (response) {
            //         var respuesta= response.data;
            //         me.arrayCategoria = respuesta.categorias.data;
            //         me.pagination= respuesta.pagination;
            //     })
            //         .catch(function (error) {
            //             console.log(error);
            //         });
            // },
            listarProvincias(){
                let me=this;
                var respuesta = me.arrayProvincias;
                console.log(respuesta);
                return respuesta
            },
            registrarProvincia(){
                if (this.validarProvincia()){
                    return;
                }
                this.arrayProvincias.push({nombre: this.nombre, cantidadMunicipio: 0 });
                this.cerrarModal();
            },
            actualizarProvincia(){

            },
            cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarProvincias(page,buscar,criterio);
            },
            registrarCategoria(){
                if (this.validarProvincia()){
                    return;
                }

                let me = this;

                axios.post('/categoria/registrar',{
                    'nombre': this.nombre
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarProvincia(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarCategoria(){
                if (this.validarCategoria()){
                    return;
                }

                let me = this;

                axios.put('/categoria/actualizar',{
                    'nombre': this.nombre,
                    'descripcion': this.descripcion,
                    'id': this.categoria_id
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarCategoria(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            desactivarCategoria(id){
                swal({
                    title: 'Esta seguro de desactivar esta categoría?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Aceptar!',
                    cancelButtonText: 'Cancelar',
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false,
                    reverseButtons: true
                }).then((result) => {
                    if (result.value) {
                        let me = this;

                        axios.put('/categoria/desactivar',{
                            'id': id
                        }).then(function (response) {
                            me.listarCategoria(1,'','nombre');
                            swal(
                                'Desactivado!',
                                'El registro ha sido desactivado con éxito.',
                                'success'
                            )
                        }).catch(function (error) {
                            console.log(error);
                        });


                    } else if (
                        // Read more about handling dismissals
                        result.dismiss === swal.DismissReason.cancel
                    ) {

                    }
                })
            },
            activarCategoria(id){
                swal({
                    title: 'Esta seguro de activar esta categoría?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Aceptar!',
                    cancelButtonText: 'Cancelar',
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false,
                    reverseButtons: true
                }).then((result) => {
                    if (result.value) {
                        let me = this;

                        axios.put('/categoria/activar',{
                            'id': id
                        }).then(function (response) {
                            me.listarProvincias(1,'','nombre');
                            swal(
                                'Activado!',
                                'El registro ha sido activado con éxito.',
                                'success'
                            )
                        }).catch(function (error) {
                            console.log(error);
                        });


                    } else if (
                        // Read more about handling dismissals
                        result.dismiss === swal.DismissReason.cancel
                    ) {

                    }
                })
            },
            validarProvincia(){
                this.errorProvincia=0;
                this.errorMostrarMsjProvincia=[];

                if (!this.nombre) this.errorMostrarMsjProvincia.push("El nombre de la provincia no puede estar vacío.");

                if (this.errorMostrarMsjProvincia.length) this.errorProvincia = 1;

                return this.errorProvincia;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.nombre='';
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "provincia":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Provincia';
                                this.nombre= '';
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                //console.log(data);
                                this.modal=1;
                                this.tituloModal='Actualizar Provincia';
                                this.tipoAccion=2;
                                this.provin_id=data['id'];
                                this.nombre = data['nombre'];
                                break;
                            }
                        }
                    }
                }
            }
        },
        mounted() {
            // this.listarCategoria(1,this.buscar,this.criterio);
            this.listarProvincias();
        }
    }
</script>
<style>
    .modal-content{
        width: 100% !important;
        position: absolute !important;
    }
    .mostrar{
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #3c29297a !important;
    }
    .div-error{
        display: flex;
        justify-content: center;
    }
    .text-error{
        color: red !important;
        font-weight: bold;
    }
</style>
