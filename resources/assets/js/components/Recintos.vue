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
                    <i class="fa fa-align-justify"></i> Recintos
                    <button type="button" @click="abrirModal('Distritos','registrar')" class="btn btn-secondary">
                        <i class="icon-plus"></i>&nbsp;Nuevo
                    </button>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <select class="form-control col-md-3" v-model="criterio">
                                    <option value="municipio">Recintos</option>
                                </select>
                                <input type="text" v-model="buscar" @keyup.enter="listarData(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                <button type="submit" @click="listarData(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                            </div>
                        </div>
                    </div>
                    <table class="table table-responsive table-bordered table-striped table-sm">
                        <thead>
                        <tr>
                            <th>Opciones</th>
                            <th>Recintos</th>
                            <th>Municipio</th>
                            <th>Distrito</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="model in data" :key="model.id">
                            <td>
                                <button type="button" @click="abrirModal('Distritos','actualizar', model)" class="btn btn-warning btn-sm">
                                    <i class="icon-pencil"></i>
                                </button> &nbsp;
                                <button type="button"  class="btn btn-danger btn-sm">
                                    <i class="icon-trash"></i>
                                </button>
                            </td>
                            <td v-text="model.name"></td>
                            <td v-text="model.municipios.name"></td>
                            <td v-text="model.distritos.name"></td>
                        </tr>
                        </tbody>
                    </table>
                    <nav>
                        <ul class="pagination">
                            <li class="page-item" v-if="pagination.current_page > 1">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1)">Ant</a>
                            </li>
                            <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(page)" v-text="page"></a>
                            </li>
                            <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1)">Sig</a>
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
                                <label class="col-md-3 form-control-label" for="text-input">Recinto</label>
                                <div class="col-md-9">
                                    <input type="text"  v-model="entity.name" class="form-control" placeholder="Recinto">
                                    <span class="help-block">(*) Ingrese el nombre del Recinto</span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Municipios</label>
                                <div class="col-md-9">
                                    <select class="form-control" name="" id="" v-model="entity.municipios_id">
                                        <option :value="municipio.id" v-for="municipio in municipios" :key="municipio.id">{{municipio.name}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Distritos</label>
                                <div class="col-md-9">
                                        <v-select v-model="entity.distritos_id" :options="distritosOptions"></v-select>
                                </div>
                            </div>
                            <!-- <div v-show="errorProvincia" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjProvincia" :key="error" v-text="error">

                                    </div>
                                </div>
                            </div> -->

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                        <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="save('POST')">Guardar</button>
                        <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="save('PUT')">Actualizar</button>
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
                municipio_id: 0,
                municipio: '',
                cantidadMunicipio: 0,
                data:[],
                // distrito_municipal: '',
                // circuscripcion: '',
                circunscripciones: [],
                distritos: [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorProvincia: 0,
                errorMostrarMsjProvincia: [],
                pagination: {
                    total: 0,
                    current_page: 1,
                    per_page: 0,
                    last_page: 0,
                    from: 0,
                    to: 0
                },
                entity: {
                    municipios_id: 0,
                    distritos_id: 0,
                    name: '',
                    id: 0,
                },

                offset: 3,
                criterio : 'recintos',
                buscar : ''
            }
        },
        created() {
            this.searchDependeciesTables()
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

            },
            distritosOptions: function(){ 
                let option = [];
                let distritos = this.distritos;
                    console.log(distritos);
                for(let i = 0; i < distritos.length; i++){
                    option.push({label: distritos[i].name, id: distritos[i].name})
                }
                return option;
            }
        },
        methods: {
            listarData(page){
                let me = this;
                axios.get('/api/recintos',
                {
                    params :{
                        eager: ['municipios', 'distritos'],
                        page: page
                    }
                }
                ).then((response)=>{
                    var respuesta = response.data;
                    me.data = respuesta.data;
                    me.pagination = respuesta.current_page;
                }).catch(function (error) {
                    console.log(error)
                })
            },
            cambiarPagina(page, buscar, criterio){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarData(page,buscar,criterio);
            },
            save(method){
                // if(!this.validarForm()){
                // }
                let url  = method == 'POST' ? `/api/recintos` : `/api/recintos/${this.entity.id}` 
                axios({
                    'url' : url,
                    'method': method,
                    'data': this.entity
                }).then(e => {
                  this.entity= {
                      distritos_id: 0,
                      municipios_id: 0,
                      name: '',
                      id: 0,
                  }
                    this.listarData(1)
                    this.cerrarModal()
                }).catch(err => {
                    console.log(err);
                })
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.provincia = '';
            },
            abrirModal(modelo, accion, data = []) {
                switch (accion) {
                    case "registrar":
                    {
                        this.modal = 1;
                        this.tituloModal = `Registrar ${modelo}`;
                        this.provincia = '';
                        this.tipoAccion = 1;
                        break;
                    }
                    case "actualizar":
                    {
                        //console.log(data);
                        this.modal=1;
                        this.tituloModal = `Actualizar ${modelo}`;
                        this.tipoAccion=2;
                        this.entity.id = data.id;
                        this.entity.name = data.name;
                        this.entity.municipios_id = data.municipios_id;
                        this.entity.distritos_id = data.distritos_id;
                        break;
                    }
                }
            },
            searchDependeciesTables(){
                axios('/api/municipios').then(e=>{this.municipios = e.data.data})
                axios('/api/distritos').then(e=>{this.distritos = e.data.data})
            }
        },
        mounted() {
            this.listarData(1);
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