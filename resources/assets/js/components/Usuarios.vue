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
                    <i class="fa fa-align-justify"></i> Personas
                    <button type="button" @click="abrirModal('personas','registrar')" class="btn btn-secondary">
                        <i class="icon-plus"></i>&nbsp;Nuevo
                    </button>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <select class="form-control col-md-3" v-model="criterio">
                                    <option value="nombre">Nombre</option>
                                    <option value="apellido">Apellido</option>
                                    <option value="cedula">Cedula</option>
                                    <option value="telefono">Telefono</option>
                                </select>
                                <input type="text" v-model="buscar" @keyup.enter="listarUsuarios(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                <button type="submit" @click="listarUsuarios(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                        <tr>
                            <th>Opciones</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Cedula</th>
                            <th>Direccion</th>
                            <th>Email</th>
                            <th>Telefono</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="usuario in arrayUsuarios" :key="usuario.id">
                            <td>
                                <button type="button" @click="abrirModal('personas','actualizar', usuario)" class="btn btn-warning btn-sm">
                                    <i class="icon-pencil"></i>
                                </button> &nbsp;
                                <button type="button"  class="btn btn-danger btn-sm">
                                    <i class="icon-trash"></i>
                                </button>
                            </td>
                            <td v-text="usuario.nombre"></td>
                            <td v-text="usuario.apellido"></td>
                            <td v-text="usuario.cedula"></td>
                            <td v-text="usuario.direccion"></td>
                            <td v-text="usuario.email"></td>
                            <td v-text="usuario.telefono"></td>
                        </tr>
                        </tbody>
                    </table>
                    <nav>
                        <ul class="pagination">
                            <li class="page-item" v-if="pagination.current_page > 1">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                            </li>
                            <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(page)" v-text="page">1</a>
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
                                <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="nombre"  class="form-control" placeholder="Nombre">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Apellido</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="apellido" class="form-control" placeholder="Apellido">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Cedula</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="cedula" class="form-control" placeholder="Cedula">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Direccion</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="direccion"  class="form-control" placeholder="Direccion">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Email</label>
                                <div class="col-md-9">
                                    <input type="email" v-model="email"  class="form-control" placeholder="Email">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Telefono</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="telefono"  class="form-control" placeholder="Telefono">
                                </div>
                            </div>
                            <div v-show="errorUsuario" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjUsuario" :key="error" v-text="error">

                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                        <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarUsuario()">Guardar</button>
                        <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarUsuario()">Actualizar</button>
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
                usuario_id: 0,
                nombre: '',
                apellido: '',
                cedula: '',
                direccion: '',
                email: '',
                telefono: '',
                arrayUsuarios: [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorUsuario: 0,
                errorMostrarMsjUsuario: [],
                pagination: {
                    total: 0,
                    current_page: 0,
                    per_page: 0,
                    last_page: 0,
                    from: 0,
                    to: 0
                },
                offset: 3,
                criterio : 'nombre',
                buscar : ''
            }
        },
        computed:{
            isActived: function(){
                return this.pagination.current_page;
            },
            pagesNumber: function(){
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
            listarUsuarios(page, buscar, criterio){
                let me = this;
                var url= '/usuarios?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayUsuarios = respuesta.personas.data;
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
            registrarUsuario(){
                if (this.validarUsuario()){
                    return;
                }

                let me = this;

                axios.post('/usuarios/registrar',{
                    'nombre': this.nombre,
                    'apellido': this.apellido,
                    'cedula': this.cedula,
                    'direccion': this.direccion,
                    'email': this.email,
                    'telefono': this.telefono
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarUsuarios(1, '','nombre');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarUsuario(){
                if (this.validarUsuario()){
                    return;
                }

                let me = this;

                axios.put('/usuarios/actualizar',{
                    'nombre': this.nombre,
                    'apellido': this.apellido,
                    'cedula': this.cedula,
                    'direccion': this.direccion,
                    'email': this.email,
                    'telefono': this.telefono,
                    'id': this.usuario_id
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarUsuarios(1, '','nombre');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            validarUsuario(){
                this.errorUsuario=0;
                this.errorMostrarMsjUsuario =[];

                if (!this.nombre) this.errorMostrarMsjUsuario.push("El campo nombre no puede estar vacio.");
                if (!this.apellido) this.errorMostrarMsjUsuario.push("El campo apellido no puede estar vacio.");
                if (!this.cedula) this.errorMostrarMsjUsuario.push("Debe registrar una cedula de identidad.");
                if (!this.direccion) this.errorMostrarMsjUsuario.push("El campo direccion no puede estar vacio.");

                if (this.errorMostrarMsjUsuario.length) this.errorUsuario = 1;

                return this.errorUsuario;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.nombre = '';
                this.apellido = '';
                this.cedula = '';
                this.direccion = '';
                this.email = '';
                this.telefono = '';
            },
            abrirModal(modelo, accion, data = []) {
                switch(modelo){
                    case "personas":
                    {
                        switch (accion) {
                            case "registrar":
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Persona';
                                this.nombre = '';
                                this.apellido = '';
                                this.cedula = '';
                                this.direccion = '';
                                this.email = '';
                                this.telefono = '';
                                this.tipoAccion = 1;
                                break;
                            }
                            case "actualizar":
                            {
                                //console.log(data);
                                this.modal=1;
                                this.tituloModal='Actualizar datos de la persona';
                                this.tipoAccion=2;
                                this.usuario_id=data['id'];
                                this.nombre = data['nombre'];
                                this.apellido= data['apellido'];
                                this.cedula = data['cedula'];
                                this.direccion = data['direccion'];
                                this.email = data['email'];
                                this.telefono = data['telefono'];
                                break;
                            }
                        }
                    }
                }
            }
        },
        mounted() {
            this.listarUsuarios(1,this.buscar,this.criterio);
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