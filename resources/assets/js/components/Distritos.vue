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
          <i class="fa fa-align-justify"></i> Distritos
          <button
            type="button"
            @click="abrirModal('Distritos', 'registrar')"
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
                  <option value="name">Distritos</option>
                  <option value="municipios">Municipios</option>
                  <option value="circunscripciones">Circunscripciones</option>
                </select>
                <input
                  type="text"
                  v-model="buscar"
                  @keyup.enter="listarData(1, buscar, criterio)"
                  class="form-control"
                  placeholder="Texto a buscar"
                />
                <button
                  type="submit"
                  @click="listarData(1, buscar, criterio)"
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
                <th>Distrito</th>
                <th>Municipio</th>
                <th>Circunscripcion</th>
                <th>Cantidad de Recintos</th>
                <th>Coordinador</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="model in data" :key="model.id">
                <td>
                  <button
                    type="button"
                    @click="abrirModal('Distritos', 'actualizar', model)"
                    class="btn btn-warning btn-sm"
                  >
                    <i class="icon-pencil"></i>
                  </button>
                  &nbsp;
                  <button type="button" class="btn btn-danger btn-sm">
                    <i class="icon-trash"></i>
                  </button>
                </td>
                <td v-text="model.name"></td>
                <td v-text="model.municipios.name"></td>
                <td v-text="model.circunscripciones.name"></td>
                <td v-text="model.recintos_number"></td>
                <td v-if="model.coordinadores">
                  {{
                    `${model.coordinadores.first_name} ${model.coordinadores.last_name}`
                  }}
                </td>
                <td v-else></td>
              </tr>
            </tbody>
          </table>
          <nav>
            <sliding-pagination
              :page-count="pagination.last_page"
              :click-handler="listarData"
              :prev-text="'Anterior'"
              :next-text="'Siguiente'"
              :containerClass="'pagination'"
              >
            ></sliding-pagination>
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
                  >Distrito</label
                >
                <div class="col-md-9">
                  <input
                    type="text"
                    v-model="entity.name"
                    class="form-control"
                    placeholder="Distrito"
                  />
                  <span class="help-block"
                    >(*) Ingrese el nombre del Distrito</span
                  >
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="text-input"
                  >Coordinador</label
                >
                <div class="col-md-9">
                  <v-select
                    v-model="entity.coordinadores_id"
                    @search="onSearchCoordinadores"
                    :options="people"
                    :filterable="false"
                    :reduce="(coordinador) => coordinador.id"
                  ></v-select>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="text-input"
                  >Municipios</label
                >
                <div class="col-md-9">
                  <v-select
                    v-model="entity.municipios_id"
                    @search="onSearchMunicipios"
                    :options="municipios"
                    :filterable="false"
                    :reduce="(municipios) => municipios.id"
                  ></v-select>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="text-input"
                  >Circunscripcion</label
                >
                <div class="col-md-9">
                  <v-select
                    v-model="entity.circunscripciones_id"
                    @search="onSearchCircunscripciones"
                    :options="circunscripciones"
                    :filterable="false"
                    :reduce="(circuscripcion) => circuscripcion.id"
                  ></v-select>
                </div>
              </div>
              <div v-show="errorDistrito" class="form-group row div-error">
                <div class="text-center text-error">
                  <div
                    v-for="error in errorMostrarMsjDistrito"
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
              @click="save('POST')"
            >
              Guardar
            </button>
            <button
              type="button"
              v-if="tipoAccion == 2"
              class="btn btn-primary"
              @click="save('PUT')"
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
  props: {
    permisionCondition: {
      default: null,
      type: String,
    },
  },
  data() {
    return {
      municipio_id: 0,
      municipio: "",
      cantidadMunicipio: 0,
      data: [],
      people: [],
      // distrito_municipal: '',
      // circuscripcion: '',
      circunscripciones: [],
      municipios: [],
      modal: 0,
      tituloModal: "",
      tipoAccion: 0,
      errorDistrito: 0,
      errorMostrarMsjDistrito: [],
      url:'/api/distritos',
      pagination: {
        total: 0,
        current_page: 1,
        per_page: 0,
        last_page: 0,
        from: 0,
        to: 0,
      },
      entity: {
        circunscripciones_id: 0,
        coordinadores_id: 0,
        municipios_id: 0,
        name: "",
        id: 0,
      },

      offset: 3,
      criterio: "distrito",
      buscar: "",
    };
  },
  computed: {
    isActived: function() {
      return this.pagination.current_page;
    },
    //Calcula los elementos de la paginación
    pagesNumber: function() {
      if (!this.pagination.to) {
        return [];
      }

      var from = this.pagination.current_page - this.offset;
      if (from < 1) {
        from = 1;
      }

      var to = from + this.offset * 2;
      if (to >= this.pagination.last_page) {
        to = this.pagination.last_page;
      }

      var pagesArray = [];
      while (from <= to) {
        pagesArray.push(from);
        from++;
      }
      return pagesArray;
    },
    conditions(){
      let condition = [];
      if(this.permisionCondition != null){
        condition.push({
            condition: "whereIn",
            operator: "=",
            field: "municipios_id",
            value: this.permisionCondition,
          });
      }

      switch(this.criterio){
        case 'name':
          condition.push({
            condition:'where',
            operator: 'like',
            value: `%${this.buscar}%`,
            field: 'name'
          });
          this.url = '/api/distritos'
          break;
        case 'municipios':
          this.url = `/api/advanced/distritos/${this.buscar}`
          if(this.permisionCondition != null){
            condition = [{
              condition: "whereIn",
              operator: "=",
              field: "municipios_id",
              value: this.permisionCondition,
            }];
          }
          break;
        case 'circunscripciones':
          this.url = `/api/advanced/distritos/circunscripciones/${this.buscar}`
          if(this.permisionCondition != null){
            condition = [{
              condition: "whereIn",
              operator: "=",
              field: "municipios_id",
              value: this.permisionCondition,
            }];
          }
          break;
      }
      return condition;
    },
    defaultCondition() {
      return this.permisionCondition != null
        ? {
            condition: "whereIn",
            operator: "=",
            field: "municipios_id",
            value: this.permisionCondition,
          }
        : null;
    },
  },
  methods: {
    listarData(page = 1) {
      let me = this;
      axios
        .get(this.url, {
          params: {
            eager: ["municipios", "circunscripciones", "coordinadores"],
            page: page,
            q: this.conditions,
            perPage: 10,

          },
        })
        .then((response) => {
          var respuesta = response.data;
          me.data = respuesta.data;
          me.pagination.total = respuesta.total;
          me.pagination.last_page = respuesta.last_page;
          me.pagination.current_page = respuesta.current_page;
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    cambiarPagina(page, buscar, criterio) {
      let me = this;
      //Actualiza la página actual
      me.pagination.current_page = page;
      //Envia la petición para visualizar la data de esa página
      me.listarData(page, buscar, criterio);
    },
    save(method) {
      if (this.validarDistrito()) {
        return;
      }
      let url =
        method == "POST"
          ? `/api/distritos`
          : `/api/distritos/${this.entity.id}`;
      axios({
        url: url,
        method: method,
        data: this.entity,
      })
        .then((e) => {
          this.entity = {
            circunscripciones_id: 0,
            municipios_id: 0,
            name: "",
            id: 0,
          };
          this.listarData(1);
          this.cerrarModal();
        })
        .catch((err) => {
          console.log(err);
        });
    },
    validarDistrito() {
      this.errorDistrito = 0;
      this.errorMostrarMsjDistrito = [];

      if (!this.entity.name)
        this.errorMostrarMsjDistrito.push("El distrito no puede ir vacio.");
      if (this.entity.municipios_id === 0)
        this.errorMostrarMsjDistrito.push("Seleccione un municipio.");
      if (this.entity.circunscripciones_id === 0)
        this.errorMostrarMsjDistrito.push("Seleccione una circunscripcion.");

      if (this.errorMostrarMsjDistrito.length) this.errorDistrito = 1;

      return this.errorDistrito;
    },
    cerrarModal() {
      this.modal = 0;
      this.tituloModal = "";
      this.provincia = "";
    },
    abrirModal(modelo, accion, data = []) {
      switch (accion) {
        case "registrar": {
          this.modal = 1;
          this.tituloModal = `Registrar ${modelo}`;
          this.provincia = "";
          this.tipoAccion = 1;
          break;
        }
        case "actualizar": {
          console.log(data);
          this.modal = 1;
          this.tituloModal = `Actualizar ${modelo}`;
          this.tipoAccion = 2;
          this.entity.id = data.id;
          this.entity.name = data.name;
          this.entity.municipios_id = data.municipios_id;
          this.entity.circunscripciones_id = data.circunscripciones_id;
          this.entity.coordinadores_id = data.coordinadores_id;
          this.people = data.coordinadores
            ? [
                {
                  id: data.coordinadores_id,
                  label: data.coordinadores.name,
                },
              ]
            : [];
          this.circunscripciones = [
            {
              id: data.circunscripciones.id,
              label: data.circunscripciones.name,
            },
          ];
          this.municipios = [
            { id: data.municipios.id, label: data.municipios.name },
          ];
          break;
        }
      }
    },
    onSearchCoordinadores(search, loading) {
      loading(true);
      this.search(loading, "people", search, this, "card_id");
    },
    onSearchMunicipios(search, loading) {
      loading(true);
      this.search(loading, "municipios", search, this);
    },
    onSearchCircunscripciones(search, loading) {
      loading(true);
      this.search(loading, "circunscripciones", search, this);
    },
    search: _.debounce((loading, option, search, vm, field = "name") => {
      axios(`/api/${option}`, {
        params: {
          q: [
            JSON.stringify({
              condition: "where",
              field: field,
              operator: "like",
              value: `%${search}%`,
            }),
          ],
        },
      }).then((r) => {
        if (search.length > 0) {
          vm[option] = r.data.data.map(function(model) {
            return { label: model.name, id: model.id };
          });
        }
        loading(false);
      });
    }, 350),
  },
  mounted() {
    this.listarData(1);
  },
};
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
