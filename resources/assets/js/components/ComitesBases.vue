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
          <i class="fa fa-align-justify"></i> Comites de Bases
          <button
            type="button"
            @click="abrirModal('Comites de Bases', 'registrar')"
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
                  <option value="municipio">Comites de Bases</option>
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
                <th>Codigo Comite de Base</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Cedula</th>
                <th>Numeros de Miembros</th>
                <th>Agregar Miembros</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="model in data" :key="model.id">
                <td>
                  <button
                    type="button"
                    @click="abrirModal('Comite de Base', 'actualizar', model)"
                    class="btn btn-warning btn-sm"
                  >
                    <i class="icon-pencil"></i>
                  </button>
                  &nbsp;
                  <button type="button" class="btn btn-danger btn-sm">
                    <i class="icon-trash"></i>
                  </button>
                </td>
                <td>{{ model.name }}</td>
                <td v-text="model.people.first_name"></td>
                <td v-text="model.people.last_name"></td>
                <td v-text="model.people.card_id"></td>
                <td v-text="model.miembros.length"></td>
                <td>
                  <button
                    class="btn btn-primary"
                    @click="abrirModalVotantes(model.id)"
                  >
                    Nuevo Miembro
                  </button>
                </td>
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
                @click="listarData(page)"
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
                  >Digite la Cedula del Votante</label
                >
                <div class="col-md-9">
                  <v-select
                    v-model="entity.people_id"
                    @search="onSearcPeople"
                    :options="people"
                    :filterable="false"
                    :reduce="(people) => people.id"
                  ></v-select>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="text-input"
                  >Codigo del Comite de Base</label
                >
                <div class="col-md-9">
                  <input
                    type="text"
                    class="form-control"
                    v-model="entity.name"
                    name=""
                    id=""
                  />
                </div>
              </div>
              <div class="form-group row" v-if="tipoAccion == 1">
                <label class="col-md-3 form-control-label" for="text-input"
                  >Miembros</label
                >
                <div class="col-md-9">
                  <v-select
                    multiple
                    @search="onSearchMiembros"
                    v-model="miemborsNuevosSelect"
                    :options="miembrosNuevos"
                  ></v-select>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="text-input"
                  >Nombre</label
                >
                <div class="col-md-9">
                  <input
                    type="text"
                    class="form-control"
                    v-model="miembro.first_name"
                    name=""
                    id=""
                  />
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="text-input"
                  >Apellido</label
                >
                <div class="col-md-9">
                  <input
                    type="text"
                    class="form-control"
                    v-model="miembro.last_name"
                    name=""
                    id=""
                  />
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="text-input"
                  >Cedula</label
                >
                <div class="col-md-9">
                  <input
                    type="text"
                    class="form-control"
                    v-model="miembro.card_id"
                    v-mask="'###-#######-#'"
                    name=""
                    id=""
                  />
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="text-input"
                  >Telefono</label
                >
                <div class="col-md-9">
                  <input
                    type="text"
                    class="form-control"
                    v-model="miembro.phone"
                    v-mask="'###-###-####'"
                    name=""
                    id=""
                  />
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
            <div class="form-group row">
              <div class="col-md-3">
                <button
                  class="btn btn-primary"
                  type="button"
                  @click="agregarMiembro"
                >
                  Guardar
                </button>
              </div>
            </div>
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
    <votantes-cba
      @listarPadre="listarData()"
      :show="showModalVotantes"
      :comites-bases-id="comites_bases_id"
      @close="showModalVotantes = false"
    />
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
      // distrito_municipal: '',
      // circuscripcion: '',
      circunscripciones: [],
      people: [],
      comites_bases_id: 0,
      miembros: [],
      modal: 0,
      tituloModal: "",
      tipoAccion: 0,
      errorDistrito: 0,
      showModalVotantes: false,
      errorMostrarMsjDistrito: [],
      miembrosNuevos: [],
      miemborsNuevosSelect: [],
      miembro: {
        first_name: "",
        last_name: "",
        card_id: "",
        phone: "",
      },
      pagination: {
        total: 0,
        current_page: 1,
        per_page: 0,
        last_page: 0,
        from: 0,
        to: 0,
      },
      entity: {
        miembros: [],
        people_id: 0,
        name: "",
        id: 0,
      },
      offset: 3,
      criterio: "",
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
    abrirModalVotantes(id) {
      this.showModalVotantes = true;
      this.comites_bases_id = id;
    },
    agregarMiembro() {
      this.miembro.label = `${this.miembro.first_name} ${this.miembro.last_name} ${this.miembro.card_id}`
      this.miembrosNuevos.push(this.miembro);
      this.miemborsNuevosSelect.push(this.miembro);
      this.miembro = {
        first_name: "",
        last_name: "",
        card_id: "",
        phone: "",
      };
    },
    listarData(page = 1) {
      let me = this;
      let conditions = [];
      if (this.defaultCondition != null) {
        conditions.push(this.defaultCondition);
      }
      axios
        .get("/api/comites_bases", {
          params: {
            eager: ["people", "miembros"],
            page: page,
            q: conditions,
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
      let url =
        method == "POST"
          ? `/api/comites_bases`
          : `/api/comites_bases/${this.entity.id}`;
      axios({
        url: url,
        method: method,
        data: this.entity,
      })
        .then((e) => {
          // this.actualizarVotante(e.data.people_id, e.data.id);
          this.savMiembros(e.data.id);
          this.entity = {
            votantes_id: 0,
            first_name: "",
            last_name: "",
            card_id: "",
            id: 0,
          };
          this.listarData(1);
          this.cerrarModal();
        })
        .catch((err) => {
          console.log(err);
        });
    },
    savMiembros(comiteBaseId){
      axios({
        url: '/api/people_bulk_edit',
        method: 'POST',
        data: {comites_bases_id: comiteBaseId, miembros:this.miemborsNuevosSelect}
      }).catch(err=>{
        alert("Hubo un problema registrando los miembros");
      })
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
    actualizarVotante(votantes_id, id) {
      axios({
        method: "PUT",
        url: `/api/people/${votantes_id}`,
        data: {
          comites_bases_id: id,
        },
      });
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
          this.entity.people_id = data.people_id;
          this.people = [
            {
              id: data.people.id,
              label: data.people.name,
            },
          ];
          break;
        }
      }
    },
    onSearcPeople(search, loading) {
      loading(true);
      this.search(loading, "people", search, this, "card_id");
    },
    onSearchMiembros(search, loading) {
      this.search(loading, "miembros", search, this, "card_id", "people");
    },
    search: _.debounce(
      (loading, option, search, vm, field = "name", endpoint = null) => {
        endpoint = endpoint != null ? endpoint : option;
        axios(`/api/${endpoint}`, {
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
      },
      350
    ),
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
