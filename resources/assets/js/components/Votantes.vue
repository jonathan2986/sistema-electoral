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
          <i class="fa fa-align-justify"></i> Votantes
          <button
            type="button"
            @click="abrirModal('votantes', 'registrar')"
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
                  <option value="municipio">Votantes</option>
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
                <th>Nombre</th>
                <th>Cedula</th>
                <th>Circunscripcion</th>
                <th>Municipio</th>
                <th>Distrito</th>
                <th>Recinto</th>
                <th>Colegio</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="model in data" :key="model.id">
                <td>
                  <button
                    type="button"
                    @click="abrirModal('votantes', 'actualizar', model)"
                    class="btn btn-warning btn-sm"
                  >
                    <i class="icon-pencil"></i>
                  </button>
                  &nbsp;
                  <button type="button" class="btn btn-danger btn-sm">
                    <i class="icon-trash"></i>
                  </button>
                </td>
                <td>{{ `${model.first_name} ${model.last_name}` }}</td>
                <td v-text="model.card_id"></td>
                <td v-text="model.circunscripciones.name"></td>
                <td v-text="model.municipios.name"></td>
                <td v-text="model.distritos ? model.distritos.name : ''"></td>
                <td v-text="model.recintos.name"></td>
                <td v-text="model.colegios_electorales.name"></td>
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
                v-for="page in pagesNumber"
                :key="page"
                :class="[page == isActived ? 'active' : '']"
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
                  >Cedula</label
                >
                <div class="col-md-9">
                  <v-select
                    v-model="cedula"
                    @search="onSearchPeople"
                    :options="people"
                    :filterable="false"
                    :reduce="people => people.id"
                    @input="setPeople"
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
                    v-model="entity.first_name"
                    disabled
                    class="form-control"
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
                    v-model="entity.last_name"
                    disabled
                    class="form-control"
                  />
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
                    :reduce="municipio => municipio.id"
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
                    :reduce="circunscripcion => circunscripcion.id"
                  ></v-select>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="text-input"
                  >Distrito</label
                >
                <div class="col-md-9">
                  <v-select
                    v-model="entity.distritos_id"
                    @search="onSearchDistritos"
                    :options="distritos"
                    :filterable="false"
                    :reduce="distrito => distrito.id"
                  ></v-select>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="text-input"
                  >Recintos</label
                >
                <div class="col-md-9">
                  <v-select
                    v-model="entity.recintos_id"
                    @search="onSearchRecintos"
                    :options="recintos"
                    :filterable="false"
                    :reduce="recinto => recinto.id"
                  ></v-select>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="text-input"
                  >Colegios</label
                >
                <div class="col-md-9">
                  <v-select
                    v-model="entity.colegios_electorales_id"
                    @search="onSearchColegios"
                    :options="colegios_electorales"
                    :filterable="false"
                    :reduce="colegio => colegio.id"
                  ></v-select>
                </div>
              </div>
              <div v-show="errorMunicipio" class="form-group row div-error">
                <div class="text-center text-error">
                  <div
                    v-for="error in errorMostrarMsjMunicipio"
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
import {mask} from 'vue-the-mask'
export default {
  data() {
    return {
      municipio_id: 0,
      municipio: "",
      cantidadMunicipio: 0,
      data: [],
      circunscripciones: [],
      provincias: [],
      municipios: [],
      recintos: [],
      distritos: [],
      colegios_electorales: [],
      people: [],
      modal: 0,
      tituloModal: "",
      tipoAccion: 0,
      errorMunicipio: 0,
      errorMostrarMsjMunicipio: [],
      pagination: {
        total: 0,
        current_page: 1,
        per_page: 0,
        last_page: 0,
        from: 0,
        to: 0
      },
      cedula: '',
      entity: {
        people_id: "",
        circunscripciones_id: "",
        municipios_id: "",
        distritos_id: null,
        recintos_id: "",
        colegios_electorales_id: "",
        first_name: "",
        last_name: "",
        card_id: "",
        id: 0
      },

      offset: 3,
      criterio: "votantes",
      buscar: ""
    };
  },
  props: {
    permisionCondition: {
      default: null,
      type: String,
    },
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
    }
  },
  methods: {
    listarData(page) {
      let me = this;
      let condition = [];
      if(this.permisionCondition){
        condition.push({
          field:'colegios_electorales_id',
          condition:'whereIn',
          operator:'=',
          value:this.permisionCondition
        });
      }
      axios
        .get("/api/votantes/?page=" + page, {
          params: {
            q: condition,
            eager: [
              "municipios",
              "circunscripciones",
              "distritos",
              "recintos",
              "colegios_electorales",
              "people"
            ]
          }
        })
        .then(response => {
          console.log(response.data);
          var respuesta = response.data;
          me.data = respuesta.data;
          me.pagination = respuesta.current_page;
          console.log(this.arrayMunicipios);
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
      //   if (this.validarMunicipio()) {
      //     return;
      //   }
      let url =
        method == "POST" ? `/api/votantes` : `/api/votantes/${this.entity.id}`;
      axios({
        url: url,
        method: method,
        data: this.entity
      })
        .then(e => {
          this.entity = {
            people_id: "",
            circunscripciones_id: "",
            municipios_id: "",
            distritos_id: null,
            recintos_id: "",
            colegios_electorales_id: "",
            first_name: "",
            last_name: "",
            card_id: "",
            id: 0
          };
          this.listarData(1);
          this.cerrarModal();
        })
        .catch(err => {
          console.log(err);
        });
    },
    validarMunicipio() {
      this.errorMunicipio = 0;
      this.errorMostrarMsjMunicipio = [];

      if (!this.entity.name)
        this.errorMostrarMsjMunicipio.push("El municipio no puede ir vacio.");
      if (this.entity.provincias_id === 0)
        this.errorMostrarMsjMunicipio.push("Seleccione una provincia.");
      if (this.entity.circunscripciones_id === 0)
        this.errorMostrarMsjMunicipio.push("Seleccione una circunscripcion.");

      if (this.errorMostrarMsjMunicipio.length) this.errorMunicipio = 1;

      return this.errorMunicipio;
    },
    cerrarModal() {
      this.modal = 0;
      this.tituloModal = "";
      this.provincia = "";
    },
    setPeople(value) {
      axios(`/api/people/${value}`).then(res => {
        this.entity.first_name = res.data.first_name;
        this.entity.last_name = res.data.last_name;
        this.entity.card_id = res.data.card_id;
        this.entity.people_id = res.data.id;
        this.cedula = res.data.card_id;
      });
    },
    abrirModal(modelo, accion, data = []) {
      switch (modelo) {
        case "votantes": {
          switch (accion) {
            case "registrar": {
              this.modal = 1;
              this.tituloModal = "Registrar Votantes";
              this.provincia = "";
              this.tipoAccion = 1;
              break;
            }
            case "actualizar": {
              //console.log(data);
              this.modal = 1;
              this.tituloModal = "Actualizar Votantes";
              this.tipoAccion = 2;
              this.entity.id = data.id;
              this.entity.first_name = data.first_name;
              this.entity.last_name = data.last_name;
              this.entity.circunscripciones_id = data.circunscripciones_id;
              this.entity.people_id = data.people_id;
              this.entity.municipios_id = data.municipios_id;
              this.entity.distritos_id = data.distritos_id;
              this.entity.recintos_id = data.recintos_id;
              this.entity.colegios_electorales_id = data.colegios_electorales_id;
              this.entity.card_id = data.card_id;
              this.cedula = data.people_id;
              this.circunscripciones = [
                {
                  label: data.circunscripciones.name,
                  id: data.circunscripciones.id
                }
              ];
              this.municipios = [
                { label: data.municipios.name, id: data.municipios.id }
              ];
              this.distritos = data.distritos
                ? [{ label: data.distritos.name, id: data.distritos.id }]
                : [];
              this.recintos = [
                { label: data.recintos.name, id: data.recintos.id }
              ];
              this.colegios_electorales = [
                {
                  label: data.colegios_electorales.name,
                  id: data.colegios_electorales.id
                }
              ];
              this.people = [{ label: data.people.name, id: data.people.id }];
              break;
            }
          }
        }
      }
    },
    onSearchPeople(search, loading) {
      loading(true);
      this.search(loading, "people", search, this, "card_id");
    },
    onSearchMunicipios(search, loading) {
      loading(true);
      this.search(loading, "municipios", search, this);
    },
    onSearchDistritos(search, loading) {
      loading(true);
      this.search(loading, "distritos", search, this);
    },
    onSearchRecintos(search, loading) {
      loading(true);
      this.search(loading, "recintos", search, this);
    },
    onSearchCircunscripciones(search, loading) {
      loading(true);
      this.search(loading, "circunscripciones", search, this);
    },
    onSearchColegios(search, loading) {
      loading(true);
      this.search(loading, "colegios_electorales", search, this);
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
