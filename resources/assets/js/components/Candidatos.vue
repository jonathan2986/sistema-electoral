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
                    <i class="fa fa-align-justify"></i> Candidatos
                    <button type="button" @click="abrirModal('candidatos','registrar')" class="btn btn-secondary">
                        <i class="icon-plus"></i>&nbsp;Nuevo
                    </button>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <select class="form-control col-md-3" v-model="criterio">
                                    <option value="nombre_candidato">Nombre</option>
                                    <option value="apellido_candidato">Apellido</option>
                                    <option value="tipo_candidato">Tipo</option>
                                    <option value="siglas">Siglas</option>
                                </select>
                                <input type="text" v-model="buscar" @keyup.enter="listarCandidato(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                <button type="submit" @click="listarCandidato(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                        <tr>
                            <th>Opciones</th>
                            <th>NOMBRE CANDIDATO</th>
                            <th>APELLIDO</th>
                            <th>CANDIDATURA</th>
                            <th>PARTIDO</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="candidato in arrayCandidato" :key="candidato.id">
                            <td>
                                <button type="button" @click="abrirModal('candidatos','actualizar',candidato)" class="btn btn-warning btn-sm">
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
                            <td v-text="candidato.nombre_candidato"></td>
                            <td v-text="candidato.apellido_candidato"></td>
                            <td v-text="candidato.tipo_candidatura"></td>
                            <td v-text="candidato.siglas"></td>
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
                                <label class="col-md-3 form-control-label" for="text-input">Nombre del Candidato</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="nombre_candidato" class="form-control" placeholder="Nombre del Candidato">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Apellido</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="apellido_candidato" class="form-control" placeholder="Apellido">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Candidatura</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="tipo_candidatura" class="form-control" placeholder="Candidatura">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Seleccionar Siglas</label>
                                <div class="col-md-9">
                                    <select class="form-control" v-model="idpartido">
                                        <option value="0" disabled>Seleccione</option>
                                        <option v-for="partido in arrayPartidos" :key="partido.id" :value="partido.id" v-text="partido.siglas"></option>
                                    </select>
                                </div>
                            </div>
                            <div v-show="errorCandidato" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjCandidato" :key="error" v-text="error">

                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                        <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarCandidato()">Guardar</button>
                        <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarCandidato()">Actualizar</button>
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
                candidato_id: 0,
                idpartido : 0,
                nombre_candidato : '',
                apellido_candidato : '',
                tipo_candidatura : '',
                siglas: '',
                arrayCandidato : [],
                arrayPartidos: [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorCandidato : 0,
                errorMostrarMsjCandidato : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'nombre_candidato',
                buscar : '',
                arrayColegios :[]
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
            listarCandidato (page,buscar,criterio){
                let me=this;
                var url= '/candidatos?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayCandidato = respuesta.candidatos.data;
                    me.pagination= respuesta.pagination;
                })
                    .catch(function (error) {
                        console.log(error);
                    });
            },

            selectPartido(){
                let me=this;
                var url= '/partidos/selectPartido';
                axios.get(url).then(function (response) {
                    // console.log(response);
                    var respuesta= response.data;
                    me.arrayPartidos = respuesta.partido;
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
                me.listarCandidato(page,buscar,criterio);
            },
            registrarCandidato(){
                if (this.validarCandidato()){
                    return;
                }

                let me = this;

                axios.post('/candidatos/registrar',{
                    'idpartido':this.idpartido,
                    'nombre_candidato': this.nombre_candidato,
                    'apellido_candidato': this.apellido_candidato,
                    'tipo_candidatura': this.tipo_candidatura
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarCandidato(1,'','nombre_candidato');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarCandidato(){
                if (this.validarCandidato()){
                    return;
                }

                let me = this;

                axios.put('/candidatos/actualizar',{
                    'idpartido':this.idpartido,
                    'nombre_candidato': this.nombre_candidato,
                    'apellido_candidato': this.apellido_candidato,
                    'tipo_candidatura': this.tipo_candidatura,
                    'id': this.candidato_id
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarCandidato(1,'','nombre_candidato');
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
            validarCandidato(){
                this.errorCandidato=0;
                this.errorMostrarMsjCandidato =[];

                if (this.idpartido == 0) this.errorMostrarMsjCandidato.push("Seleccione el partido de candidato.");
                if (!this.nombre_candidato) this.errorMostrarMsjCandidato.push("El nombre del candidato no puede estar vacío.");
                if (!this.apellido_candidato) this.errorMostrarMsjCandidato.push("El apellido del candidato no puede estar vacía.");
                if (!this.tipo_candidatura) this.errorMostrarMsjCandidato.push("Ingrese un tipo de candidatura.");
                if (this.errorMostrarMsjCandidato.length) this.errorCandidato = 1;

                return this.errorCandidato;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.nombre_candidato = '';
                this.apellido_candidato='';
                this.tipo_candidatura = '';
                this.errorCandidato = 0;
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "candidatos":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Candidato';
                                this.idpartido = 0;
                                this.nombre_candidato = '';
                                this.apellido_candidato='';
                                this.tipo_candidatura = '';
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                //console.log(data);
                                this.modal=1;
                                this.tituloModal='Actualizar Candidato';
                                this.tipoAccion=2;
                                this.candidato_id=data['id'];
                                this.idpartido=data['idpartido'];
                                this.nombre_candidato = data['nombre_candidato'];
                                this.apellido_candidato= data['apellido_candidato'];
                                this.tipo_candidatura = data['tipo_candidatura'];
                                break;
                            }
                        }
                    }
                }
                this.selectPartido();
            }

        },
        mounted() {
            this.listarCandidato(1,this.buscar,this.criterio);
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
