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
          <button
            type="button"
            @click="abrirModal('Recintos', 'registrar')"
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
                  <option value="name">Recintos</option>
                  <option value="distritos">Distritos</option>
                  <option value="municipios">Municipios</option>
                </select>
                <input
                  type="text"
                  v-model="buscar"
                  @keyup.enter="listarData()"
                  class="form-control"
                  placeholder="Texto a buscar"
                />
                <button
                  type="submit"
                  @click="listarData()"
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
                <th>Recintos</th>
                <th>Cantidad de colegios</th>
                <th>Direccion</th>
                <th>Municipio</th>
                <th>Distrito</th>
                <th>Coordinador</th>
                <th>Coordinador Ejecutivo</th>
                <th>Coordinador Electoral</th>
                <th>Coordinador Seguridad</th>
                <th>Coordinador Finanza</th>
                <th>Activistas</th>
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
                <td v-text="model.number_colegios"></td>
                <td v-text="model.address"></td>
                <td v-text="model.municipios.name"></td>
                <td v-text="model.distritos ? model.distritos.name : ''"></td>

                <td v-if="model.coordinadores">
                  {{
                    `${model.coordinadores.first_name} ${model.coordinadores.last_name}`
                  }}
                </td>
                <td v-else></td>

                <td v-if="model.coordinadores_ejecutivos">
                  {{
                    `${model.coordinadores_ejecutivos.first_name} ${model.coordinadores_ejecutivos.last_name}`
                  }}
                </td>
                <td v-else></td>

                <td v-if="model.coordinadores_electorales">
                  {{
                    `${model.coordinadores_electorales.first_name} ${model.coordinadores_electorales.last_name}`
                  }}
                </td>
                <td v-else></td>

                <td v-if="model.coordinadores_seguridad">
                  {{
                    `${model.coordinadores_seguridad.first_name} ${model.coordinadores_seguridad.last_name}`
                  }}
                </td>
                <td v-else></td>

                <td v-if="model.coordinadores_finanzas">
                  {{
                    `${model.coordinadores_finanzas.first_name} ${model.coordinadores_finanzas.last_name}`
                  }}
                </td>
                <td v-else></td>
                <td v-if="model.activistas">
                  {{
                    `${model.activistas.first_name} ${model.activistas.last_name}`
                  }}
                </td>
                <td v-else></td>
              </tr>
            </tbody>
          </table>
          <nav>
            <sliding-pagination
              :page-count="pagination.last_page"
              :click-handler="listarProvincias"
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
                  >Recinto</label
                >
                <div class="col-md-9">
                  <input
                    type="text"
                    v-model="entity.name"
                    class="form-control"
                    placeholder="Recinto"
                  />
                  <span class="help-block"
                    >(*) Ingrese el nombre del Recinto</span
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
                  >Coordinador Ejecutivo</label
                >
                <div class="col-md-9">
                  <v-select
                    v-model="entity.coordinadores_ejecutivos_id"
                    @search="onSearchCoordinadoresEjecutivos"
                    :options="coordinadores_ejecutivos"
                    :filterable="false"
                    :reduce="(coordinador) => coordinador.id"
                  ></v-select>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="text-input"
                  >Coordinador Electoral</label
                >
                <div class="col-md-9">
                  <v-select
                    v-model="entity.coordinadores_electorales_id"
                    @search="onSearchCoordinadoresElectorales"
                    :options="coordinadores_electorales"
                    :filterable="false"
                    :reduce="(coordinador) => coordinador.id"
                  ></v-select>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="text-input"
                  >Coordinador de Seguridad</label
                >
                <div class="col-md-9">
                  <v-select
                    v-model="entity.coordinadores_seguridad_id"
                    @search="onSearchCoordinadoresSeguridad"
                    :options="coordinadores_seguridad"
                    :filterable="false"
                    :reduce="(coordinador) => coordinador.id"
                  ></v-select>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="text-input"
                  >Coordinador de Finanzas</label
                >
                <div class="col-md-9">
                  <v-select
                    v-model="entity.coordinadores_finanzas_id"
                    @search="onSearchCoordinadoresFinanzas"
                    :options="coordinadores_finanzas"
                    :filterable="false"
                    :reduce="(coordinador) => coordinador.id"
                  ></v-select>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="text-input"
                  >Activistas</label
                >
                <div class="col-md-9">
                  <v-select
                    v-model="entity.activistas_id"
                    @search="onSearchActivistas"
                    :options="activistas"
                    :filterable="false"
                    :reduce="(activista) => activista.id"
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
                    :reduce="(municipio) => municipio.id"
                  ></v-select>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="text-input"
                  >Distritos</label
                >
                <div class="col-md-9">
                  <v-select
                    v-model="entity.distritos_id"
                    @search="onSearchDistritos"
                    :options="distritos"
                    :filterable="false"
                    :reduce="(distrito) => distrito.id"
                  ></v-select>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for=""
                  >Direccion</label
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
              <div v-show="errorRecinto" class="form-group row div-error">
                <div class="text-center text-error">
                  <div
                    v-for="error in errorMostrarMsjRecinto"
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
    field: {
      type: String,
      default: "municipios_id",
    },
    permisionCondition: {
      type: String,
      default: null,
    },
  },
  data: () => {
    return {
      municipio_id: 0,
      municipio: "",
      cantidadMunicipio: 0,
      data: [],
      // distrito_municipal: '',
      // circuscripcion: '',
      municipios: [],
      distritos: [],
      people: [],
      coordinadores_ejecutivos: [],
      coordinadores_electorales: [],
      coordinadores_seguridad: [],
      coordinadores_finanzas: [],
      activistas: [],
      modal: 0,
      tituloModal: "",
      tipoAccion: 0,
      errorRecinto: 0,
      errorMostrarMsjRecinto: [],
      url: "/api/recintos",
      pagination: {
        total: 0,
        current_page: 1,
        per_page: 0,
        last_page: 0,
        from: 0,
        to: 0,
      },
      entity: {
        coordinadores_ejecutivos_id: "",
        coordinadores_electorales_id: "",
        coordinadores_seguridad_id: "",
        coordinadores_finanzas_id: "",
        coordinadores_id: 0,
        municipios_id: 0,
        distritos_id: 0,
        name: "",
        address: "",
        activistas_id: 0,
        id: 0,
      },

      offset: 3,
      criterio: "recintos",
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
    conditions: function() {
      let conditions = [];
      if (this.permisionCondition != null) {
        conditions.push({
          field: this.field,
          value: this.permisionCondition,
          condition: "whereIn",
          operator: "=",
        });
      }
      switch (this.criterio) {
        case "name":
          conditions.push({
            condition: "where",
            field: this.criterio,
            operator: "like",
            value: `%${this.buscar}%`,
          });
          this.url = "/api/recintos";
          break;
        case "municipios":
          this.url = `/api/advanced/recintos/municipios/${this.buscar}`;
          break;
        case "distritos":
          this.url = `/api/advanced/recintos/distritos/${this.buscar}`;
          break;
      }
      return conditions;
    },
  },
  methods: {
    listarData(page = 1) {
      let me = this;
      axios
        .get(this.url, {
          params: {
            eager: [
              "municipios",
              "distritos",
              "activistas",
              "coordinadores",
              "coordinadores_ejecutivos",
              "coordinadores_electorales",
              "coordinadores_seguridad",
              "coordinadores_finanzas",
            ],
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
      if (this.validarRecinto()) {
        return;
      }
      let url =
        method == "POST" ? `/api/recintos` : `/api/recintos/${this.entity.id}`;
      axios({
        url: url,
        method: method,
        data: this.entity,
      })
        .then((e) => {
          this.entity = {
            coordinadores_ejecutivos_id: "",
            coordinadores_electorales_id: "",
            coordinadores_seguridad_id: "",
            coordinadores_finanzas_id: "",
            coordinadores_id: 0,
            municipios_id: 0,
            distritos_id: 0,
            name: "",
            activistas_id: 0,
            address: "",
            id: 0,
          };
          this.listarData(1);
          this.cerrarModal();
        })
        .catch((err) => {
          console.log(err);
        });
    },
    validarRecinto() {
      this.errorRecinto = 0;
      this.errorMostrarMsjRecinto = [];

      if (!this.entity.name)
        this.errorMostrarMsjRecinto.push("El distrito no puede ir vacio.");
      if (!this.entity.address)
        this.errorMostrarMsjRecinto.push("La direccion no puede ir vacia.");
      if (this.entity.municipios_id === 0)
        this.errorMostrarMsjRecinto.push("Seleccione un municipio.");
      // if (this.entity.circunscripciones_id === 0)
      //   this.errorMostrarMsjRecinto.push("Seleccione una circunscripcion.");

      if (this.errorMostrarMsjRecinto.length) this.errorRecinto = 1;

      return this.errorRecinto;
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
          this.entity.distritos_id = data.distritos_id;
          this.entity.address = data.address;
          this.entity.coordinadores_id = data.coordinadores_id;
          this.entity.activistas_id = data.activistas_id;
          this.entity.coordinadores_ejecutivos_id =
            data.coordinadores_ejecutivos_id;
          this.entity.coordinadores_electorales_id =
            data.coordinadores_electorales_id;
          this.entity.coordinadores_seguridad_id =
            data.coordinadores_seguridad_id;
          this.entity.coordinadores_finanzas_id =
            data.coordinadores_finanzas_id;
          this.people = data.coordinadores
            ? [{ id: data.coordinadores_id, label: data.coordinadores.name }]
            : [];
          this.distritos = data.distritos
            ? [{ id: data.distritos.id, label: data.distritos.name }]
            : [];
          this.municipios = [
            { id: data.municipios.id, label: data.municipios.name },
          ];

          this.coordinadores_ejecutivos = data.coordinadores_ejecutivos
            ? [
                {
                  id: data.coordinadores_ejecutivos.id,
                  label: data.coordinadores_ejecutivos.name,
                },
              ]
            : [];

          this.coordinadores_electorales = data.coordinadores_electorales
            ? [
                {
                  id: data.coordinadores_electorales.id,
                  label: data.coordinadores_electorales.name,
                },
              ]
            : [];

          this.coordinadores_seguridad = data.coordinadores_seguridad
            ? [
                {
                  id: data.coordinadores_seguridad.id,
                  label: data.coordinadores_seguridad.name,
                },
              ]
            : [];

          this.coordinadores_finanzas = data.coordinadores_finanzas
            ? [
                {
                  id: data.coordinadores_finanzas.id,
                  label: data.coordinadores_finanzas.name,
                },
              ]
            : [];

          this.activistas = data.activistas
            ? [
                {
                  label: data.activistas.name,
                  id: data.activistas.id,
                },
              ]
            : [];
          break;
        }
      }
    },
    onSearchCoordinadores(search, loading) {
      loading(true);
      this.search(loading, "people", search, this, "card_id");
    },
    onSearchCoordinadoresEjecutivos(search, loading) {
      loading(true);
      this.search(
        loading,
        "coordinadores_ejecutivos",
        search,
        this,
        "card_id",
        "people"
      );
    },
    onSearchCoordinadoresElectorales(search, loading) {
      loading(true);
      this.search(
        loading,
        "coordinadores_electorales",
        search,
        this,
        "card_id",
        "people"
      );
    },
    onSearchCoordinadoresEjecutivos(search, loading) {
      loading(true);
      this.search(
        loading,
        "coordinadores_ejecutivos",
        search,
        this,
        "card_id",
        "people"
      );
    },
    onSearchCoordinadoresSeguridad(search, loading) {
      loading(true);
      this.search(
        loading,
        "coordinadores_seguridad",
        search,
        this,
        "card_id",
        "people"
      );
    },
    onSearchCoordinadoresFinanzas(search, loading) {
      loading(true);
      this.search(
        loading,
        "coordinadores_finanzas",
        search,
        this,
        "card_id",
        "people"
      );
    },
    onSearchActivistas(search, loading) {
      loading(true);
      this.search(loading, "activistas", search, this, "card_id", "people");
    },
    onSearchMunicipios(search, loading) {
      loading(true);
      this.search(loading, "municipios", search, this);
    },
    onSearchDistritos(search, loading) {
      loading(true);
      this.search(loading, "distritos", search, this);
    },
    search: _.debounce(
      (loading, option, search, vm, field = "name", url = null) => {
        url = !url ? option : url;
        axios(`/api/${url}`, {
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
