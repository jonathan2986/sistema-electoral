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
                    <i class="fa fa-align-justify"></i> Electores
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
                                <input type="text" v-model="buscar" @keyup.enter="listarElectores(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                <button type="submit" @click="listarElectores(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
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
                            <th>Telefono</th>
                            <th>Colegio</th>
                            <th>Usuario</th>
                            <th>Voto</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="elector in arrayElectores" :key="elector.id">
                            <td>
                                <button type="button" @click="abrirModal('personas','actualizar', elector)" class="btn btn-warning btn-sm">
                                    <i class="icon-pencil"></i>
                                </button>
                                <template v-if="usuario.votosComputados">
                                    <button type="button" class="btn btn-danger btn-sm" @click="cancelarVoto(usuario.id)">
                                        <i class="icon-trash"></i>
                                    </button>
                                </template>
                                <template v-else>
                                    <button type="button" class="btn btn-info btn-sm" @click="agregarVoto(usuario.id)">
                                        <i class="icon-check"></i>
                                    </button>
                                </template>
                            </td>
                            <td v-text="elector.nombre"></td>
                            <td v-text="elector.apellido"></td>
                            <td v-text="elector.cedula"></td>
                            <td v-text="elector.direccion"></td>
                            <td v-text="elector.telefono"></td>
                            <td v-text="elector.numero_colegio"></td>
                            <td v-text="elector.usuario"></td>
                            <td v-text="elector.votosComputados"></td>
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
                                <label class="col-md-3 form-control-label" for="text-input">Seleccionar Colegio</label>
                                <div class="col-md-9">
                                    <select class="form-control" v-model="idcolegio_electoral">
                                        <option value="0" disabled>Seleccione</option>
                                        <option v-for="colegio in arrayColegiosE" :key="colegio.id" :value="colegio.id" v-text="colegio.numero_colegio"></option>
                                    </select>
                                </div>
                            </div>
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
                                <label class="col-md-3 form-control-label" for="text-input">Telefono</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="telefono"  class="form-control" placeholder="Telefono">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">Rol (*)</label>
                                <div class="col-md-9">
                                    <select class="form-control" v-model="idusuario">
                                        <option value="0" disabled>Seleccione un usuario</option>
                                        <option v-for="usuario in arrayUsuarios" :key="usuario.id" :value="usuario.id" v-text="usuario.usuario"></option>
                                    </select>
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
                idusuario: 0,
                electores_id: 0,
                idcolegio_electoral: 0,
                idpersona: 0,
                nombre: '',
                apellido: '',
                cedula: '',
                direccion: '',
                telefono: '',
                votosComputados: 0,
                usuario: '',
                arrayElectores: [],
                arrayUsuarios : [],
                arrayColegiosE: [],
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
            listarElectores(page, buscar, criterio){
                let me = this;
                var url= '/electores?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayElectores = respuesta.electores.data;
                    me.pagination = respuesta.pagination;
                    console.log(response);
                })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                    })
            },
            selectUsuario(){
                let me=this;
                var url= '/users/selectUsuario';
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayUsuarios = respuesta.usuarios;
                })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            selectColegio(){
                let me=this;
                var url= '/colegios-electorales/selectColegio';
                axios.get(url).then(function (response) {
                    // console.log(response);
                    var respuesta= response.data;
                    me.arrayColegiosE = respuesta.colegio_electoral;
                })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            cambiarPagina(page, buscar, criterio){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarUsuarios(page,buscar,criterio);
            },
            registrarUsuario(){
                if (this.validarUsuario()){
                    return;
                }

                let me = this;

                axios.post('/electores/registrar',{
                    'idcolegio_electoral':this.idcolegio_electoral,
                    'nombre': this.nombre,
                    'apellido': this.apellido,
                    'cedula': this.cedula,
                    'direccion': this.direccion,
                    'telefono': this.telefono,
                    'votosComputados':this.votosComputados,
                    'idusuario': this.idusuario,
                    'idpersona': this.idpersona
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarElectores(1, '','nombre');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarUsuario(){
                if (this.validarUsuario()){
                    return;
                }

                let me = this;

                axios.put('/electores/actualizar',{
                    'idcolegio_electoral':this.idcolegio_electoral,
                    'nombre': this.nombre,
                    'apellido': this.apellido,
                    'cedula': this.cedula,
                    'direccion': this.direccion,
                    'telefono': this.telefono,
                    'voto':this.voto,
                    'usuario': this.usuario,
                    'password': this.password,
                    'idrol' : this.idrol,
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
                if (this.idusuario == 0) this.errorMostrarMsjUsuario.push("Seleccione un usuario.");
                if (this.idcolegio_electoral == 0) this.errorMostrarMsjUsuario.push("Seleccione un colegio Electoral");
                if (this.errorMostrarMsjUsuario.length) this.errorUsuario = 1;

                return this.errorUsuario;
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
                this.tituloModal='';
                this.nombre = '';
                this.apellido = '';
                this.cedula = '';
                this.direccion = '';
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
                                this.tituloModal = 'Registrar Elector';
                                this.nombre = '';
                                this.apellido = '';
                                this.cedula = '';
                                this.direccion = '';
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
                                this.idcolegio_electoral=data['idcolegio_electoral'];
                                this.idrol = data['idrol'];
                                this.nombre = data['nombre'];
                                this.apellido= data['apellido'];
                                this.cedula = data['cedula'];
                                this.direccion = data['direccion'];
                                this.telefono = data['telefono'];
                                this.usuario = data['usuario'];
                                this.password = data['password'];
                                break;
                            }
                        }
                    }
                }
                this.selectColegio();
                this.selectUsuario();
            }
        },
        mounted() {
            this.listarElectores(1,this.buscar,this.criterio);
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