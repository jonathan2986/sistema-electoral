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
                    <i class="fa fa-align-justify"></i> Votos
                    <button type="button" @click="abrirModal('votos','registrar')" class="btn btn-secondary">
                        <i class="icon-plus"></i>&nbsp;Nuevo
                    </button>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <select class="form-control col-md-3" v-model="criterio">
                                    <option value="nombre_candidato">Nombre</option>
                                    <option value="partido">Partido</option>
                                </select>
                                <input type="text" v-model="buscar" @keyup.enter="listarVotos(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                <button type="submit" @click="listarVotos(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                        <tr>
                            <th>Opciones</th>
                            <th>Nombre</th>
                            <th>Candidatura</th>
                            <th>Partidos</th>
                            <th>Votos Candidatos</th>
<!--                            <th>Votos Nulo</th>-->
<!--                            <th>Votos Valido</th>-->
<!--                            <th>Boletas Observada</th>-->
<!--                            <th>Total de Votos</th>-->
                            <th>Porcentaje</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="voto in arrayVotos" :key="voto.id">
                            <td>
                                <button type="button" @click="abrirModal('votos','actualizar', voto)" class="btn btn-warning btn-sm">
                                    <i class="icon-pencil"></i>
                                </button>
                                <template>
                                    <button type="button" class="btn btn-info btn-sm">
                                        <i class="icon-check"></i>
                                    </button>
                                </template>
                            </td>
                            <td v-text="voto.nombre_candidato"></td>
                            <td v-text="voto.tipo_candidatura"></td>
                            <td v-text="voto.siglas"></td>
                            <td v-text="voto.voto_candidato"></td>
<!--                            <td v-text="voto.voto_nulo"></td>-->
<!--                            <td v-text="voto.votos_valido"></td>-->
<!--                            <td v-text="voto.boletas_observada"></td>-->
<!--                            <td v-text="voto.total_voto"></td>-->
                            <td v-if="voto.voto_candidato > 0">{{((voto.voto_candidato*100)/voto.total_voto).toFixed(2)}}%</td>
                            <td v-else>No tienen porcentaje</td>
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
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" @click="cerrarModal()">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Seleccionar Candidato</label>
                                <div class="col-md-9">
                                    <select class="form-control" v-model="idcandidato">
                                        <option value="0" disabled>Seleccione</option>
                                        <option v-for="candidato in arrayCandidato" :key="candidato.id" :value="candidato.id" v-text="candidato.nombre_candidato"></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Seleccionar Candidatura</label>
                                <div class="col-md-9">
                                    <select class="form-control" v-model="idcandidato">
                                        <option value="0" disabled>Seleccione</option>
                                        <option v-for="candidatura in arrayCandidato" :key="candidatura.id" :value="candidatura.id" v-text="candidatura.tipo_candidatura"></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">Seleccione un partido</label>
                                <div class="col-md-9">
                                    <select class="form-control" v-model="idpartido">
                                        <option value="0">Seleccione</option>
                                        <option v-for="partido in arrayPartidos" :key="partido.id" :value="partido.id" v-text="partido.siglas">

                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Voto Candidato</label>
                                <div class="col-md-9">
                                    <input type="number" v-model="voto_candidato"  class="form-control" placeholder="Voto del candidato">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Votos Nulo</label>
                                <div class="col-md-9">
                                    <input type="number" v-model="voto_nulo" class="form-control" placeholder="Votos nulo">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Votos valido</label>
                                <div class="col-md-9">
                                    <input type="number" v-model="votos_valido" class="form-control" placeholder="Votos Valido">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Boletas Observada</label>
                                <div class="col-md-9">
                                    <input type="number" v-model="boletas_observada"  class="form-control" placeholder="Boletas Observada">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Total Votos</label>
                                <div class="col-md-9">
                                    <input type="number" v-model="total_voto"  class="form-control" placeholder="Total de votos">
                                </div>
                            </div>

                            <div v-show="errorVotos" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjVoto" :key="error" v-text="error">

                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                        <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarVoto()">Guardar</button>
                        <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarVoto()">Actualizar</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

        <div class="form-group row border">
            <div class="table-responsive col-md-12">
                <table class="table table-bordered table-striped table-sm">
                    <thead>
                    <tr>
                        <th>Opciones</th>
                        <th>Votos Validos</th>
                        <th>Votos Nulos</th>
<!--                        <th>Boletas Observada</th>-->
                        <th>Total de Votos</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="voto in arrayTotalvotos" :key="voto.id">
                        <td>
                            <button type="button" class="btn btn-danger btn-sm">
                                <i class="icon-close"></i>
                            </button>
                        </td>
                        <td v-text="voto.votos_valido"></td>
                        <td v-text="voto.voto_nulo"></td>
<!--                        <td v-text="voto.boletas_observada"></td>-->
                        <td v-text="voto.total_voto"></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!--Fin del modal-->
        <!-- Inicio del modal Eliminar -->
        <div class="modal fade" id="modalEliminar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-danger" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Eliminar Categoría</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Estas seguro de eliminar la categoría?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-danger">Eliminar</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- Fin del modal Eliminar -->
    </main>
</template>

<script>
    export default {
        data() {
            return {
                idvoto: 0,
                idcandidato: 0,
                idpartido: 0,
                nombre_candidato: '',
                tipo_candidatura: '',
                siglas: '',
                voto_candidato: 0,
                votos_valido: 0,
                voto_nulo: 0,
                boletas_observada: 0,
                total_voto: 0,
                porcentaje:0,
                arrayVotos: [],
                arrayCandidato : [],
                totalPorcentaje:0,
                arrayPartidos: [],
                arrayTotalvotos: [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorVotos: 0,
                errorMostrarMsjVoto: [],
                pagination: {
                    total: 0,
                    current_page: 0,
                    per_page: 0,
                    last_page: 0,
                    from: 0,
                    to: 0
                },
                offset: 3,
                criterio : 'nombre_candidato',
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
        methods: {
            listarVotos(page, buscar, criterio){
                let me = this;
                var url= '/votos?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayVotos = respuesta.votos.data;
                    me.pagination = respuesta.pagination;
                    //console.log(response);
                })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                    })
            },
            selectCandidato(){
                let me=this;
                var url= '/candidatos/selectCandidato';
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayCandidato = respuesta.candidatos;
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
            mostrarTotalVotos(){
                let me=this;
                var url= '/votos/selectTotalVotos';
                axios.get(url).then(function (response) {
                    console.log(response);
                    var respuesta= response.data;
                    me.arrayTotalvotos = respuesta.votos;
                })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            // sacarPorcentaje(){
            //     let me = this;
            //     let porcentaje = 0;
            //     var url= '/votos?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
            //     axios.get(url).then(function (response) {
            //         var respuesta = response.data;
            //         me.total_voto = respuesta.votos.data.total_voto;
            //         me.voto_candidato = respuesta.votos.data.voto_candidato;
            //         me.voto_nulo = respuesta.votos.data.voto_nulo;
            //         me.votos_valido = respuesta.votos.data.votos_valido;
            //         porcentaje = (me.voto_candidato + me.votos_valido + me.voto_nulo)/100;
            //         return porcentaje;
            //         me.pagination = respuesta.pagination;
            //
            //
            //         //console.log(response);
            //     })
            //         .catch(function (error) {
            //             // handle error
            //             console.log(error);
            //         })
            // },
            cambiarPagina(page, buscar, criterio){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarVotos(page,buscar,criterio);
            },
            registrarVoto(){
                if (this.validarVoto()){
                    return;
                }

                let me = this;

                axios.post('/votos/registrar',{
                    'idcandidato':this.idcandidato,
                    'idpartido': this.idpartido,
                    'voto_candidato': this.voto_candidato,
                    'voto_nulo': this.voto_nulo,
                    'votos_valido': this.votos_valido,
                    'total_voto':this.total_voto,
                    'boletas_observada': this.boletas_observada
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarVotos(1, '','nombre_candidato');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarVoto(){
                if (this.validarVoto()){
                    return;
                }

                let me = this;

                axios.put('/votos/actualizar',{
                    'idcandidato':this.idcandidato,
                    'idpartido': this.idpartido,
                    'voto_candidato': this.voto_candidato,
                    'voto_nulo': this.voto_nulo,
                    'votos_valido': this.votos_valido,
                    'total_voto':this.total_voto,
                    'boletas_observada': this.boletas_observada,
                    'id': this.idvoto
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarVotos(1, '','nombre');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            validarVoto(){
                this.errorUsuario=0;
                this.errorMostrarMsjUsuario =[];

                // if (!this.voto_candidato) this.errorMostrarMsjVoto.push("Ingrese los voto del candidato.");
                // if (!this.voto_nulo) this.errorMostrarMsjVoto.push("Ingrese los votos nulo");
                // if (!this.votos_valido) this.errorMostrarMsjVoto.push("Ingrese los votos valido");
                // if (!this.boletas_observada) this.errorMostrarMsjVoto.push("Ingrese las voletas observada.");
                // if (!this.total_voto) this.errorMostrarMsjVoto.push("Ingrese el total de votos");
                if (this.idcandidato==0) this.errorMostrarMsjVoto.push("Seleccione un candidato.");
                if (this.idpartido==0) this.errorMostrarMsjVoto.push("Seleccione un partido.");

                if (this.errorMostrarMsjVoto.length) this.errorVotos = 1;

                return this.errorVotos;
            },
            desactivarUsuario(id){
                swal({
                    title: 'Esta seguro de desactivar este usuario?',
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

                        axios.put('/users/desactivar',{
                            'id': id
                        }).then(function (response) {
                            me.listarUsuarios(1,'','nombre');
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
            activarUsuario(id){
                swal({
                    title: 'Esta seguro de activar este usuario?',
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

                        axios.put('/users/activar',{
                            'id': id
                        }).then(function (response) {
                            me.listarUsuarios(1,'','nombre');
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
            cerrarModal(){
                    this.modal=0;
                    this.voto_candidato= 0;
                    this.votos_valido= 0;
                    this.voto_nulo= 0;
                    this.boletas_observada= 0;
                    this.total_voto= 0;
                    this.idpartido= 0;
                    this.idcandidato=0;
            },
            abrirModal(modelo, accion, data = []) {

                switch(modelo){
                    case "votos":
                    {
                        switch (accion) {
                            case "registrar":
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Votos';
                                this.voto_candidato= 0;
                                this.votos_valido= 0;
                                this.voto_nulo= 0;
                                this.boletas_observada= 0;
                                this.total_voto= 0;
                                this.idpartido= 0;
                                this.idcandidato=0;
                                this.tipoAccion = 1;
                                break;
                            }
                            case "actualizar":
                            {
                                //console.log(data);
                                this.modal=1;
                                this.tituloModal='Actualizar Registros';
                                this.tipoAccion=2;
                                this.idvoto=data['id'];
                                this.idcandidato=data['idcandidato'];
                                this.idpartido = data['idpartido'];
                                this.voto_candidato = data['voto_candidato'];
                                this.votos_valido= data['votos_valido'];
                                this.voto_nulo = data['voto_nulo'];
                                this.boletas_observada = data['boletas_observada'];
                                this.total_voto = data['total_voto'];
                                break;
                            }
                        }
                    }
                }
                this.selectCandidato();
                this.selectPartido();
            }
        },
        mounted() {
            this.listarVotos(1,this.buscar,this.criterio);
            this.mostrarTotalVotos();
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