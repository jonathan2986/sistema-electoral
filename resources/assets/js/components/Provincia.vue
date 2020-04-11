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
          <i class="fa fa-align-justify"></i> Provincias
          <button
            type="button"
            @click="abrirModal('provincia', 'registrar')"
            class="btn btn-secondary"
          >
            <i class="icon-plus"></i>&nbsp;Nuevo
          </button>
        </div>
        <div class="card-body">
          <div class="form-group row">
            <div class="col-md-6">
              <div class="input-group">
                <select class="form-control col-md-3" v-model="criterio">
                  <option value="provincia">Provincia</option>
                </select>
                <input
                  type="text"
                  v-model="buscar"
                  @keyup.enter="listarProvincias(1, buscar, criterio)"
                  class="form-control"
                  placeholder="Texto a buscar"
                />
                <button
                  type="submit"
                  @click="listarProvincias(1, buscar, criterio)"
                  class="btn btn-primary"
                >
                  <i class="fa fa-search"></i> Buscar
                </button>
              </div>
            </div>
          </div>
          <table
            class="table table-responsive table-bordered table-striped table-sm"
          >
            <thead>
              <tr>
                <th>Opciones</th>
                <th>Provincia</th>
                <th>Cantidad de Municipios</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="provincia in arrayProvincias" :key="provincia.id">
                <td>
                  <button
                    type="button"
                    @click="abrirModal('provincia', 'actualizar', provincia)"
                    class="btn btn-warning btn-sm"
                  >
                    <i class="icon-pencil"></i>
                  </button>
                  &nbsp;
                  <button type="button" class="btn btn-danger btn-sm">
                    <i class="icon-trash"></i>
                  </button>
                </td>
                <td v-text="provincia.name"></td>
                <td v-text="provincia.number_municipios"></td>
              </tr>
            </tbody>
          </table>
          <nav>
            <ul class="pagination">
              <li class="page-item" v-if="pagination.current_page > 1">
                <a
                  class="page-link"
                  href="#"
                  @click.prevent="cambiarPagina(pagination.current_page - 1)"
                  >Ant</a
                >
              </li>
              <li
                class="page-item"
                v-for="page in pagination.last_page"
                :key="page"
                :class="[page == isActived ? 'active' : '']"
                @click="listarProvincias(page)"
              >
                <a
                  class="page-link"
                  href="#"
                  @click.prevent="cambiarPagina(page)"
                  v-text="page"
                ></a>
              </li>
              <li
                class="page-item"
                v-if="pagination.current_page < pagination.last_page"
              >
                <a
                  class="page-link"
                  href="#"
                  @click.prevent="cambiarPagina(pagination.current_page + 1)"
                  >Sig</a
                >
              </li>
            </ul>
          </nav>
        </div>
      </div>
      <!-- Fin ejemplo de tabla Listado -->
    </div>
    <!--Inicio del modal agregar/actualizar-->
    <div
      class="modal fade"
      tabindex="-1"
      :class="{ mostrar: modal }"
      role="dialog"
      aria-labelledby="myModalLabel"
      style="display: none;"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-primary modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" v-text="tituloModal"></h4>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true" @click="cerrarModal()">×</span>
            </button>
          </div>
          <div class="modal-body">
            <form
              action=""
              method="post"
              enctype="multipart/form-data"
              class="form-horizontal"
            >
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="text-input"
                  >Provincia</label
                >
                <div class="col-md-9">
                  <input
                    type="text"
                    v-model="provincia"
                    class="form-control"
                    placeholder="Provincia"
                  />
                  <span class="help-block"
                    >(*) Ingrese el nombre de la provincia</span
                  >
                </div>
              </div>
              <div v-show="errorProvincia" class="form-group row div-error">
                <div class="text-center text-error">
                  <div
                    v-for="error in errorMostrarMsjProvincia"
                    :key="error"
                    v-text="error"
                  ></div>
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              @click="cerrarModal()"
            >
              Cerrar
            </button>
            <button
              type="button"
              v-if="tipoAccion == 1"
              class="btn btn-primary"
              @click="registrarProvincia()"
            >
              Guardar
            </button>
            <button
              type="button"
              v-if="tipoAccion == 2"
              class="btn btn-primary"
              @click="actualizarProvincia()"
            >
              Actualizar
            </button>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!--Fin del modal-->
    <!-- Inicio del modal Eliminar -->
    <div
      class="modal fade"
      id="modalEliminar"
      tabindex="-1"
      role="dialog"
      aria-labelledby="myModalLabel"
      style="display: none;"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-danger" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Eliminar Categoría</h4>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <p>Estas seguro de eliminar la categoría?</p>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-dismiss="modal"
            >
              Cerrar
            </button>
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
            provincia_id: 0,
            provincia: '',
            cantidadMunicipio: 0,
            // distrito_municipal: '',
            // circuscripcion: '',
            arrayProvincias: [],
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
        listarProvincias(page = 1){
            let me = this;
           axios.get('/api/provincias/?page=' + page).then((response)=>{
               var respuesta = response.data;
               me.arrayProvincias = respuesta.data;
               me.pagination.total = respuesta.total;
               me.pagination.last_page = respuesta.last_page;
               me.pagination.current_page = respuesta.current_page;
               console.log(this.arrayProvincias);
           }).catch(function (error) {
               console.log(error)
           })
        },
        cambiarPagina(page, buscar, criterio){
            let me = this;
            //Actualiza la página actual
            me.pagination.current_page = page;
            //Envia la petición para visualizar la data de esa página
            me.listarProvincias(page,buscar,criterio);
        },
        registrarProvincia(){
            if (this.validarProvincia()){
                return;
            }

            let me = this;

            axios.post('/api/provincias',{
                'name': this.provincia

            }).then(function (response) {
                me.cerrarModal();
                me.listarProvincias(1);
            }).catch(function (error) {
                console.log(error);
            });
        },
        actualizarProvincia(){
            if (this.validarProvincia()){
                return;
            }

            let me = this;

            axios.put(`/api/provincias/${this.provincia_id}`,{
                'name': this.provincia,
            }).then(function (response) {
                me.cerrarModal();
                me.listarProvincias(1);
            }).catch(function (error) {
                console.log(error);
            });
        },
        validarProvincia(){
            this.errorProvincia=0;
            this.errorMostrarMsjProvincia =[];

            if (!this.provincia) this.errorMostrarMsjProvincia.push("La provincia no puede estar vacía.");

            if (this.errorMostrarMsjProvincia.length) this.errorProvincia = 1;

            return this.errorProvincia;
        },
        cerrarModal(){
            this.modal=0;
            this.tituloModal='';
            this.provincia = '';
        },
        abrirModal(modelo, accion, data = []) {
            switch(modelo){
                case "provincia":
                {
                    switch (accion) {
                        case "registrar":
                        {
                            this.modal = 1;
                            this.tituloModal = 'Registrar Provincia';
                            this.provincia = '';
                            this.tipoAccion = 1;
                            break;
                        }
                        case "actualizar":
                        {
                            //console.log(data);
                            this.modal=1;
                            this.tituloModal='Actualizar Provincia';
                            this.tipoAccion=2;
                            this.provincia_id=data['id'];
                            this.provincia = data['name'];
                            break;
                        }
                    }
                }
            }
        }
    },
    mounted() {
        this.listarProvincias(1);
    }
}
</script>
<style>
.modal-content {
  width: 100% !important;
  position: absolute !important;
}
.mostrar {
  display: list-item !important;
  opacity: 1 !important;
  position: absolute !important;
  background-color: #3c29297a !important;
}
.div-error {
  display: flex;
  justify-content: center;
}
.text-error {
  color: red !important;
  font-weight: bold;
}
</style>
