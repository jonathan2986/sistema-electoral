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
                <th>Nombre del Coordinador</th>
                <th>Apellido del Coordinador</th>
                <th>Cedula del Coordinador</th>
                <th>Direccion</th>
                <th>Numeros de Miembros</th>
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
                <td>{{ pad(model.id,3) }}</td>
                <td v-text="model.first_name"></td>
                <td v-text="model.last_name"></td>
                <td v-text="model.card_id"></td>
                <td v-text="model.address"></td>
                <td v-text="model.members_count"></td>
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
                    v-model="entity.votantes_id"
                    @search="onSearchVotantes"
                    :options="votantes"
                    :filterable="false"
                    :reduce="votante => votante.id"
                    @input="setVotantes"
                  ></v-select>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="text-input"
                  >Nombre del Coordinador</label
                >
                <div class="col-md-9">
                  <input
                    type="text"
                    v-model="entity.first_name"
                    class="form-control"
                    placeholder="Nombre"
                  />
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="text-input"
                  >Apellido del Coordinador</label
                >
                <div class="col-md-9">
                  <input
                    type="text"
                    v-model="entity.last_name"
                    class="form-control"
                    placeholder="Apellido"
                  />
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="text-input"
                  >Cedula del Coordinador</label
                >
                <div class="col-md-9">
                  <input
                    type="text"
                    v-model="entity.card_id"
                    class="form-control"
                    placeholder="Cedula"
                  />
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for=""
                  >Direccion del Coordinador</label
                >
                <div class="col-md-9">
                  <textarea
                    v-model="entity.address"
                    name=""
                    class="form-control"
                    id=""
                    cols="10"
                    rows="5"
                  ></textarea>
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
      type: String
    }
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
      votantes: [],
      modal: 0,
      tituloModal: "",
      tipoAccion: 0,
      errorDistrito: 0,
      errorMostrarMsjDistrito: [],
      pagination: {
        total: 0,
        current_page: 1,
        per_page: 0,
        last_page: 0,
        from: 0,
        to: 0
      },
      entity: {
        votantes_id: 0,
        first_name: "",
        last_name: "",
        card_id: "",
        address: "",
        id: 0
      },

      offset: 3,
      criterio: "",
      buscar: ""
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
            value: this.permisionCondition
          }
        : null;
    }
  },
  methods: {
    listarData(page = 1) {
      let me = this;
      let conditions = [];
      if (this.defaultCondition != null) {
        conditions.push(this.defaultCondition);
      }
      axios
        .get("/api/coordinadores_comites_bases", {
          params: {
            eager: ["votantes"],
            page: page,
            q: conditions
          }
        })
        .then(response => {
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
    setVotantes(id) {
      axios({
        method: "GET",
        url: `/api/votantes/${id}`
      }).then(res => {
        this.entity.first_name = res.data.first_name;
        this.entity.last_name = res.data.last_name;
        this.entity.card_id = res.data.card_id;
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
          ? `/api/coordinadores_comites_bases`
          : `/api/coordinadores_comites_bases/${this.entity.id}`;
      axios({
        url: url,
        method: method,
        data: this.entity
      })
        .then(e => {
          this.actualizarVotante(e.data.votantes_id, e.data.id);
          this.entity = {
            circunscripciones_id: 0,
            municipios_id: 0,
            name: "",
            id: 0
          };
          this.listarData(1);
          this.cerrarModal();
        })
        .catch(err => {
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
    actualizarVotante(votantes_id, id){
      axios({
        method:'PUT',
        url:`/api/votantes/${idvotantes_id}`,
        data:{
          comites_bases_id:id
        }
      })
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
          //console.log(data);
          this.modal = 1;
          this.tituloModal = `Actualizar ${modelo}`;
          this.tipoAccion = 2;
          this.entity.id = data.id;
          this.entity.first_name = data.name;
          this.entity.last_name = data.municipios_id;
          this.entity.card_id = data.card_id;
          this.entity.votantes_id = data.votantes_id;
          this.entity.address = data.address;
          this.votantes = [
            {
              id: data.votantes.id,
              label: data.votantes.card_id
            }
          ];
          break;
        }
      }
    },
    onSearchVotantes(search, loading) {
      loading(true);
      this.search(loading, "votantes", search, this, "card_id");
    },
    onSearchCircunscripciones(search, loading) {
      loading(true);
      this.search(loading, "circunscripciones", search, this);
    },
    pad(number, length) {
      var str = "" + number;
      while (str.length < length) {
        str = "0" + str;
      }

      return str;
    },
    search: _.debounce((loading, option, search, vm, field = "name") => {
      axios(`/api/${option}`, {
        params: {
          q: [
            JSON.stringify({
              condition: "where",
              field: field,
              operator: "like",
              value: `%${search}%`
            })
          ]
        }
      }).then(r => {
        if (search.length > 0) {
          vm[option] = r.data.data.map(function(model) {
            return { label: model.name, id: model.id };
          });
        }
        loading(false);
      });
    }, 350)
  },
  mounted() {
    this.listarData(1);
  }
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
