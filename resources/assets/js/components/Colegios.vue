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
                                    <option value="provincia">Provincia</option>
                                    <option value="municipio">Municipio</option>
                                    <option value="distrito_municipal">Distrito Municipal</option>
                                    <option value="Circuscripcion">Circuscripcion</option>
                                </select>
                                <input type="text" v-model="buscar" @keyup.enter="listarColegios(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                <button type="submit" @click="listarColegios(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                        <tr>
                            <th>Opciones</th>
                            <th>Provincia</th>
                            <th>Municipio</th>
                            <th>Distrito Municipal</th>
                            <th>Circuscripcion</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="colegio in arrayColegios" :key="colegio.id">
                            <td>
                                <button type="button" @click="abrirModal('colegios','actualizar', colegio)" class="btn btn-warning btn-sm">
                                    <i class="icon-pencil"></i>
                                </button> &nbsp;
                                <button type="button"  class="btn btn-danger btn-sm">
                                    <i class="icon-trash"></i>
                                </button>
                            </td>
                            <td v-text="colegio.provincia"></td>
                            <td v-text="colegio.municipio"></td>
                            <td v-text="colegio.distrito_municipal"></td>
                            <td v-text="colegio.circuscripcion"></td>
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
                                <label class="col-md-3 form-control-label" for="text-input">Provincia</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="provincia"  class="form-control" placeholder="Provincia">
                                    <span class="help-block">(*) Ingrese el nombre de la provincia</span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Municipio</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="municipio" class="form-control" placeholder="Municipio">
                                    <span class="help-block">(*) Ingrese el nombre del municipio</span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Distrito Municipal</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="distrito_municipal" class="form-control" placeholder="Distrito Municipal">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Circuscripcion</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="circuscripcion"  class="form-control" placeholder="Circuscripcion">
                                </div>
                            </div>
                            <div v-show="errorColegio" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjColegio" :key="error" v-text="error">

                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                        <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarColegios()">Guardar</button>
                        <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarColegio()">Actualizar</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
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
                colegio_id: 0,
                provincia: '',
                municipio: '',
                distrito_municipal: '',
                circuscripcion: '',
                arrayColegios: [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorColegio: 0,
                errorMostrarMsjColegio: [],
                pagination: {
                    total: 0,
                    current_page: 0,
                    per_page: 0,
                    last_page: 0,
                    from: 0,
                    to: 0
                },
                offset: 3,
                criterio : 'provincia',
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
            listarColegios(page, buscar, criterio){
                let me = this;
                var url= '/colegios?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                        me.arrayColegios = respuesta.colegios.data;
                        me.pagination = respuesta.pagination;
                        //console.log(response);
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                    })
            },
            cambiarPagina(page, buscar, criterio){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarColegios(page,buscar,criterio);
            },
            registrarColegios(){
                if (this.validarColegio()){
                    return;
                }

                let me = this;

                axios.post('/colegios/registrar',{
                    'provincia': this.provincia,
                    'municipio': this.municipio,
                    'distrito_municipal': this.distrito_municipal,
                    'circuscripcion': this.circuscripcion

                }).then(function (response) {
                    me.cerrarModal();
                    me.listarColegios(1, '','provincia');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarColegio(){
                if (this.validarColegio()){
                    return;
                }

                let me = this;

                axios.put('/colegios/actualizar',{
                    'provincia': this.provincia,
                    'municipio': this.municipio,
                    'distrito_municipal': this.distrito_municipal,
                    'circuscripcion': this.circuscripcion,
                    'id': this.colegio_id
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarColegios(1, '','provincia');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            validarColegio(){
                this.errorColegio=0;
                this.errorMostrarMsjColegio =[];

                if (!this.provincia) this.errorMostrarMsjColegio.push("La provincia no puede estar vacía.");
                if (!this.municipio) this.errorMostrarMsjColegio.push("El municipio no puede estar vacío.");
                if (!this.distrito_municipal) this.errorMostrarMsjColegio.push("El distrito municipal no puede estar vacío.");
                if (!this.circuscripcion) this.errorMostrarMsjColegio.push("La circuscripcion no puede estar vacío.");

                if (this.errorMostrarMsjColegio.length) this.errorColegio = 1;

                return this.errorColegio;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.provincia = '';
                this.municipio = '';
                this.distrito_municipal = '';
                this.circuscripcion = '';
            },
            abrirModal(modelo, accion, data = []) {
                switch(modelo){
                    case "colegios":
                    {
                        switch (accion) {
                            case "registrar":
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Colegio';
                                this.provincia = '';
                                this.municipio = '';
                                this.distrito_municipal = '';
                                this.circuscripcion = '';
                                this.tipoAccion = 1;
                                break;
                            }
                            case "actualizar":
                            {
                                //console.log(data);
                                this.modal=1;
                                this.tituloModal='Actualizar colegio';
                                this.tipoAccion=2;
                                this.colegio_id=data['id'];
                                this.provincia = data['provincia'];
                                this.municipio= data['municipio'];
                                this.distrito_municipal = data['distrito_municipal'];
                                this.circuscripcion = data['circuscripcion'];
                                break;
                            }
                        }
                    }
                }
            }
        },
        mounted() {
            this.listarColegios(1,this.buscar,this.criterio);
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