<template>
    <main class="main">
        <!-- Breadcrumb -->
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Escritorio</a></li>
        </ol>
        <div class="container-fluid">
            <!-- Ejemplo de tabla Listado -->
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> Colegios Electorales
                    <button type="button" @click="abrirModal('colegios','registrar')" class="btn btn-secondary">
                        <i class="icon-plus"></i>&nbsp;Nuevo
                    </button>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <select class="form-control col-md-3" v-model="criterio">
                                    <option value="numero_colegio">Numero de Colegio</option>
                                    <option value="cantidad_electores">Cantidad de Electores</option>
                                </select>
                                <input type="text" v-model="buscar" @keyup.enter="listarColegiosE(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                <button type="submit" @click="listarColegiosE(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                        <tr>
                            <th>Opciones</th>
                            <th>Recinto Electoral</th>
                            <th>Numero de Colegio</th>
                            <th>Cantidad de Electores</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="colegio in arrayColegiosE" :key="colegio.id">
                            <td>
                                <button type="button" @click="abrirModal('colegios','actualizar',colegio)" class="btn btn-warning btn-sm">
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
                            <td v-text="colegio.nombre_recinto"></td>
                            <td v-text="colegio.numero_colegio"></td>
                            <td v-text="colegio.cantidad_electores"></td>
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
                                <label class="col-md-3 form-control-label" for="text-input">Nombre del Recinto</label>
                                <div class="col-md-9">
                                    <select class="form-control" v-model="idrecinto">
                                        <option value="0" disabled>Seleccione</option>
                                        <option v-for="recinto in arrayRecinto" :key="recinto.id" :value="recinto.id" v-text="recinto.nombre_recinto"></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Numero de Colegio</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="numero_colegio" class="form-control" placeholder="Numero de Colegio">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Cantidad de Electores</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="cantidad_electores" class="form-control" placeholder="Cantidad de Electores">
                                </div>
                            </div>
                            <div v-show="errorColegioE" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjColegioE" :key="error" v-text="error">

                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                        <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarColegiosE()">Guardar</button>
                        <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarColegioE()">Actualizar</button>
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
                colegio_id: 0,
                idrecinto : 0,
                nombre_recinto : '',
                numero_colegio : '',
                cantidad_electores : 0,
                arrayColegiosE : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorColegioE : 0,
                errorMostrarMsjColegioE : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'numero_colegio',
                buscar : '',
                arrayRecinto:[]
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
            listarColegiosE (page,buscar,criterio){
                let me=this;
                var url= '/colegios-electorales?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayColegiosE = respuesta.colegio_electoral.data;
                    me.pagination= respuesta.pagination;
                }).catch(function (error) {
                        console.log(error);
                    });
            },

            selectRecinto(){
                let me=this;
                var url= '/recintos/selectRecinto';
                axios.get(url).then(function (response) {
                    // console.log(response);
                    var respuesta= response.data;
                    me.arrayRecinto = respuesta.recintos;
                })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarColegios(page,buscar,criterio);
            },
            registrarColegiosE(){
                if (this.validarColegioE()){
                    return;
                }

                let me = this;

                axios.post('/colegios-electorales/registrar',{
                    'idrecinto':this.idrecinto,
                    'numero_colegio': this.numero_colegio,
                    'cantidad_electores': this.cantidad_electores
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarColegiosE(1,'','numero_colegio');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarColegioE(){
                if (this.validarColegioE()){
                    return;
                }

                let me = this;

                axios.put('/colegios-electorales/actualizar',{
                    'idrecinto':this.idrecinto,
                    'numero_colegio': this.numero_colegio,
                    'cantidad_electores': this.cantidad_electores,
                    'id': this.colegio_id
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarColegiosE(1,'','numero_colegio');
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
                            me.listarCategoria(1,'','nombre');
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
            validarColegioE(){
                this.errorRecinto=0;
                this.errorMostrarMsjRecinto =[];

                if (this.idrecinto == 0) this.errorMostrarMsjColegioE.push("Seleccione el nombre del recinto electoral.");
                if (!this.numero_colegio) this.errorMostrarMsjColegioE.push("El numero de colegios no puede estar vacío.");
                if (!this.cantidad_electores) this.errorMostrarMsjColegioE.push("La direccion del recinto no puede estar vacío.");
                if (this.errorMostrarMsjRecinto.length) this.errorRecinto = 1;

                return this.errorCategoria;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.nombre_recinto='';
                this.numero_colegio='';
                this.cantidad_electores = 0;
                this.errorColegioE = 0;
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "colegios":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Colegios Electorales';
                                this.idrecinto = 0;
                                this.nombre_recinto= '';
                                this.numero_colegio= '';
                                this.cantidad_electores = 0;
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                //console.log(data);
                                this.modal=1;
                                this.tituloModal='Actualizar Colegios Electorales';
                                this.tipoAccion=2;
                                this.colegio_id=data['id'];
                                this.idrecinto=data['idrecinto'];
                                this.numero_colegio = data['numero_colegio'];
                                this.cantidad_electores= data['cantidad_electores'];
                                break;
                            }
                        }
                    }
                }
                this.selectRecinto();
            }

        },
        mounted() {
            this.listarColegiosE(1,this.buscar,this.criterio);
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
