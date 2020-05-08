<template>
  <main class="main">
    <!-- Breadcrumb -->
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="/">Escritorio</a>
      </li>
    </ol>
    <div class="container-fluid">
      <!-- Ejemplo de tabla Listado -->
      <div class="card">
        <div class="card-header">
          <i class="fa fa-align-justify"></i> Electores
          <button
            type="button"
            @click="abrirModal('Electores', 'registrar')"
            class="btn btn-secondary"
          >
            <i class="icon-plus"></i>&nbsp;Nuevo
          </button>
        </div>
        <div class="card-body">
          <div class="form-group row">
            <div class="col-md-6">
              <div class="input-group">
                <select class="form-control col-md-3" @change="conditions()" v-model="criterio">
                  <option value="first_name">Nombre</option>
                  <option value="card_id">Cedula</option>
                  <option value="phone_number">Telefono</option>
                  <option value="sexo">Sexo</option>
                  <option value="profession">Profesion</option>
                  <option value="recintos">Recintos</option>
                  <option value="comites_bases">Comite de Base</option>
                  <option value="colegios_electorales">Colegios Electorales</option>
                </select>
                <input
                  type="text"
                  v-model="buscar"
                  @keyup.enter="listarData(1, buscar, criterio)"
                  v-on:input="conditions"
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
          <div class="table-responsive">
            <table class="table table-bordered table-striped table-sm">
              <thead>
                <tr>
                  <th>Opciones</th>
                  <th>Nombre</th>
                  <th>Cedula</th>
                  <th>Direccion</th>
                  <th>Sector</th>
                  <th>Telefono</th>
                  <th>Celular</th>
                  <th>Edad</th>
                  <th>Sexo</th>
                  <th>Profesion</th>
                  <th>Municipio</th>
                  <th>Distrito</th>
                  <th>Recinto</th>
                  <th>Colegio Electoral</th>
                  <th>Comite de Base</th>
                  <th>Contactado</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="model in data" :key="model.id">
                  <td>
                    <button
                      type="button"
                      @click="abrirModal('Electores', 'actualizar', model)"
                      class="btn btn-warning btn-sm"
                    >
                      <i class="icon-pencil"></i>
                    </button>
                    &nbsp;
                    <button
                      @click="borrar(model.id)"
                      type="button"
                      class="btn btn-danger btn-sm"
                    >
                      <i class="icon-trash"></i>
                    </button>
                  </td>
                  <td v-text="`${model.first_name} ${model.last_name}`"></td>
                  <td v-text="model.card_id"></td>
                  <td v-text="model.address"></td>
                  <td v-text="model.sector"></td>
                  <td v-text="model.phone_number"></td>
                  <td v-text="model.celphone"></td>
                  <td v-text="model.age"></td>
                  <td v-text="model.sexo"></td>
                  <td v-text="model.profession"></td>
                  <td v-text="model.municipios ? model.municipios.name : ''"></td>
                  <td v-text="model.distritos ? model.distritos.name : ''"></td>
                  <td v-text="model.recintos ? model.recintos.name : ''"></td>
                  <td
                    v-text="
                      model.colegios_electorales
                        ? model.colegios_electorales.name
                        : ''
                    "
                  ></td>
                  <td v-text="model.comites_bases ? model.comites_bases.name : ''"></td>
                  <td>
                    <button
                      v-if="!model.confirmado"
                      @click="confirmarElector(model)"
                      type="button"
                      class="btn btn-primary"
                    >Confirmar</button>
                    <span v-else>Contactado</span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <nav>
            <sliding-pagination
              :page-count="pagination.last_page"
              :click-handler="listarData"
              :prev-text="'Anterior'"
              :next-text="'Siguiente'"
              :containerClass="'pagination'"
            ></sliding-pagination>
          </nav>
        </div>
      </div>
      <!-- Fin ejemplo de tabla Listado -->
    </div>
    <!--Inicio del modal agregar/actualizar-->
    <div
      class="modal fade persona"
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
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true" @click="cerrarModal()">×</span>
            </button>
          </div>
          <div class="modal-body">
            <form action method="post" enctype="multipart/form-data" class="form-horizontal">
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
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
                <label class="col-md-3 form-control-label" for="text-input">Apellido</label>
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
                <label class="col-md-3 form-control-label" for="text-input">Cedula</label>
                <div class="col-md-9">
                  <input
                    type="text"
                    v-model="entity.card_id"
                    v-mask="'###-#######-#'"
                    class="form-control"
                    placeholder="Cedula"
                  />
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="text-input">Telefono</label>
                <div class="col-md-9">
                  <input
                    type="text"
                    v-model="entity.phone_number"
                    v-mask="'###-###-####'"
                    class="form-control"
                    placeholder="Telefono"
                  />
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="text-input">Celular</label>
                <div class="col-md-9">
                  <input
                    type="text"
                    v-mask="'###-###-####'"
                    v-model="entity.celphone"
                    class="form-control"
                    placeholder="Celular"
                  />
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="text-input">Email</label>
                <div class="col-md-9">
                  <input
                    type="text"
                    v-model="entity.email"
                    class="form-control"
                    placeholder="Email"
                  />
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="text-input">Fecha de Nacimiento</label>
                <div class="col-md-9">
                  <input
                    type="date"
                    v-model="entity.date_birthdate"
                    class="form-control"
                    placeholder="Fecha de Nacimiento"
                  />
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="text-input">Profesion</label>
                <div class="col-md-9">
                  <input
                    type="text"
                    v-model="entity.profession"
                    class="form-control"
                    placeholder="Profesion"
                  />
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="text-input">Direccion</label>
                <div class="col-md-9">
                  <input
                    type="text"
                    v-model="entity.address"
                    class="form-control"
                    placeholder="Direccion"
                  />
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="text-input">Sector</label>
                <div class="col-md-9">
                  <input
                    type="text"
                    v-model="entity.sector"
                    class="form-control"
                    placeholder="Ingrese el sector"
                  />
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="text-input">Sexo</label>
                <div class="col-md-9">
                  <select v-model="entity.sexo" class="form-control" id>
                    <option value disabled selected>Seleccione el sexo</option>
                    <option value="Masculino">M</option>
                    <option value="Femenino">F</option>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="text-input">Circunscripcion</label>
                <div class="col-md-9">
                  <v-select
                    v-model="entity.circunscripciones_id"
                    @search="onSearchCircunscripciones"
                    :options="circunscripciones"
                    :filterable="false"
                    placeholder="Seleccione la Circunscripcion"
                    :reduce="(circunscripcion) => circunscripcion.id"
                  ></v-select>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="text-input">Municipios</label>
                <div class="col-md-9">
                  <v-select
                    v-model="entity.municipios_id"
                    @search="onSearchMunicipios"
                    :options="municipios"
                    :filterable="false"
                    placeholder="Seleccione el municipio"
                    :reduce="(municipio) => municipio.id"
                  ></v-select>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="text-input">Distrito</label>
                <div class="col-md-9">
                  <v-select
                    v-model="entity.distritos_id"
                    @search="onSearchDistritos"
                    :options="distritos"
                    :filterable="false"
                    placeholder="Seleccione el distrito municipal"
                    :reduce="(distrito) => distrito.id"
                  ></v-select>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="text-input">Recintos</label>
                <div class="col-md-9">
                  <v-select
                    v-model="entity.recintos_id"
                    @search="onSearchRecintos"
                    :options="recintos"
                    :filterable="false"
                    placeholder="Seleccione el recinto electoral"
                    :reduce="(recinto) => recinto.id"
                  ></v-select>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="text-input">Colegios Electorales</label>
                <div class="col-md-9">
                  <v-select
                    v-model="entity.colegios_electorales_id"
                    @search="onSearchColegiosElectorales"
                    :options="colegios_electorales"
                    :filterable="false"
                    placeholder="Seleccione el colegio"
                    :reduce="(colegio) => colegio.id"
                  ></v-select>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="text-input">Comites de Bases</label>
                <div class="col-md-9">
                  <v-select
                    v-model="entity.comites_bases_id"
                    @search="onSearchComitesBases"
                    :options="comites_bases"
                    :filterable="false"
                    placeholder="Seleccione el comite de base"
                    :reduce="(comite_base) => comite_base.id"
                  ></v-select>
                </div>
              </div>
              <div v-show="errorPersona" class="form-group row div-error">
                <div class="text-center text-error">
                  <div v-for="error in errorMostrarMsjPersona" :key="error" v-text="error"></div>
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
            <button
              type="button"
              v-if="tipoAccion == 1"
              class="btn btn-primary"
              @click="save('POST')"
            >Guardar</button>
            <button
              type="button"
              v-if="tipoAccion == 2"
              class="btn btn-primary"
              @click="save('PUT')"
            >Actualizar</button>
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
    <loading :show="loading" />
  </main>
</template>

<script>
import { mask } from "vue-the-mask";
export default {
  directives: { mask: mask },
  data() {
    return {
      municipio_id: 0,
      municipio: "",
      cantidadMunicipio: 0,
      data: [],
      loading: false,
      circunscripciones: [],
      distritos: [],
      provincias: [],
      municipios: [],
      recintos: [],
      colegios_electorales: [],
      modal: 0,
      tituloModal: "",
      tipoAccion: 0,
      errorPersona: 0,
      errorMostrarMsjPersona: [],
      url: "/api/people",
      comites_bases: [],
      pagination: {
        total: 0,
        current_page: 1,
        per_page: 0,
        last_page: 0,
        from: 0,
        to: 0
      },
      entity: {
        first_name: "",
        last_name: "",
        card_id: "",
        phone_number: "",
        celphone: "",
        email: "",
        date_birthdate: "",
        profession: "",
        address: "",
        sector: "",
        sexo: "",
        id: 0,
        municipios_id: 0,
        circunscripciones_id: 0,
        distritos_id: 0,
        recintos_id: 0,
        colegios_electorales_id: 0
      },

      offset: 3,
      criterio: "",
      buscar: ""
    };
  },
  created() {
    this.searchDependeciesTables();
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
    borrar(id) {
      let r = confirm("Esta seguro que quiere borrar este votante");
      if (r) {
        axios({
          url: `/api/people/${id}`,
          method: "DELETE"
        }).then(r => {
          this.listarData();
        });
      }
    },
    listarData(page = 1) {
      let me = this;
      // this.loading = true;
      this.conditions();
      axios
        .get(this.url, {
          params: {
            page: page,
            perPage: 10,
            q: this.conditions(),
            eager: [
              "municipios:id,name",
              "circunscripciones:id,name",
              "distritos:id,name",
              "recintos:id,name",
              "colegios_electorales:id,name",
              "comites_bases:id,name"
            ]
          }
        })
        .then(response => {
          var respuesta = response.data;
          me.data = respuesta.data;
          me.pagination.total = respuesta.total;
          me.pagination.last_page = respuesta.last_page;
          me.pagination.current_page = respuesta.current_page;
          this.loading = false;
        })
        .catch(err => {
          // console.log(error);
          this.loading = false;
        });
    },
    cambiarPagina(page, buscar, criterio) {
      let me = this;
      //Actualiza la página actual
      me.pagination.current_page = page;
      //Envia la petición para visualizar la data de esa página
      me.listarData(page, buscar, criterio);
    },
    confirmarElector(model) {
      axios.put(`/api/people/${model.id}`, {
        confirmado: 1
      }).then(res =>{
        model.confirmado = 1;
      });
    },
    save(method) {
      if (this.validarPersona()) {
        return;
      }
      let url =
        method == "POST" ? `/api/people` : `/api/people/${this.entity.id}`;
      axios({
        url: url,
        method: method,
        data: this.entity
      })
        .then(e => {
          this.entity = {
            first_name: "",
            last_name: "",
            card_id: "",
            phone_number: "",
            celphone: "",
            email: "",
            date_birthdate: "",
            profession: "",
            address: "",
            sector: "",
            sexo: "",
            municipios_id: 0,
            circunscripciones_id: 0,
            distritos_id: 0,
            recintos_id: 0,
            colegios_electorales_id: 0,
            comites_bases_id: 0,
            id: 0
          };
          this.listarData(this.pagination.current_page);
          this.cerrarModal();
        })
        .catch(err => {
          alert("Error! La cedula ya esta registrada");
        });
    },
    validarPersona() {
      this.errorPersona = 0;
      this.errorMostrarMsjPersona = [];

      if (!this.entity.first_name)
        this.errorMostrarMsjPersona.push("El nombre no puede ir vacio.");
      if (!this.entity.last_name)
        this.errorMostrarMsjPersona.push("El apellido no puede ir vacio.");
      if (!this.entity.card_id)
        this.errorMostrarMsjPersona.push("Ingrese una cedula");

      if (this.errorMostrarMsjPersona.length) this.errorPersona = 1;

      return this.errorPersona;
    },
    cerrarModal() {
      this.modal = 0;
      this.tituloModal = "";
      this.provincia = "";
      this.entity = {
        first_name: "",
        last_name: "",
        card_id: "",
        phone_number: "",
        celphone: "",
        email: "",
        date_birthdate: "",
        profession: "",
        address: "",
        sector: "",
        sexo: "",
        municipios_id: 0,
        circunscripciones_id: 0,
        distritos_id: 0,
        recintos_id: 0,
        colegios_electorales_id: 0,
        comites_bases_id: 0,
        id: 0
      };
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
          this.entity.first_name = data.first_name;
          this.entity.last_name = data.last_name;
          this.entity.card_id = data.card_id;
          this.entity.celphone = data.celphone;
          this.entity.phone_number = data.phone_number;
          this.entity.email = data.email;
          this.entity.date_birthdate = data.date_birthdate;
          this.entity.profession = data.profession;
          this.entity.address = data.address;
          this.entity.sector = data.sector;
          this.entity.sexo = data.sexo;
          this.entity.municipios_id = data.municipios_id;
          this.entity.provincias_id = data.provincias_id;
          this.entity.circunscripciones_id = data.circunscripciones_id;
          this.entity.distritos_id = data.distritos_id;
          this.entity.recintos_id = data.recintos_id;
          this.entity.colegios_electorales_id = data.colegios_electorales_id;
          this.entity.comites_bases_id = data.comites_bases_id;
          if (this.municipios) {
            this.municipios = data.municipios
              ? [
                  {
                    label: data.municipios.name,
                    id: data.municipios_id
                  }
                ]
              : [];
            this.circunscripciones = data.circunscripciones
              ? [
                  {
                    label: data.circunscripciones.name,
                    id: data.circunscripciones_id
                  }
                ]
              : [];
            this.distritos = data.distritos
              ? [
                  {
                    label: data.distritos.name,
                    id: data.distritos_id
                  }
                ]
              : [];
            this.recintos = data.recintos
              ? [
                  {
                    label: data.recintos.name,
                    id: data.recintos_id
                  }
                ]
              : [];
            this.colegios_electorales = data.colegios_electorales
              ? [
                  {
                    label: data.colegios_electorales.name,
                    id: data.colegios_electorales_id
                  }
                ]
              : [];
            this.comites_bases = data.comites_bases
              ? [
                  {
                    label: data.comites_bases.name,
                    id: data.comites_bases_id
                  }
                ]
              : [];
          }
          break;
        }
      }
    },
    onSearchMunicipios(search, loading) {
      loading(true);
      this.search(loading, "municipios", search, this);
    },
    onSearchProvincias(search, loading) {
      loading(true);
      this.search(loading, "provincias", search, this);
    },
    onSearchCircunscripciones(search, loading) {
      loading(true);
      this.search(loading, "circunscripciones", search, this);
    },
    conditions: function() {
      let condition = [];
      switch (this.criterio) {
        case "recintos":
          condition = [];
          this.url = `/api/advanced/people/recintos/${this.buscar}`;
          break;
        case "comites_bases":
          condition = [];
          this.url = `/api/advanced/people/comites_bases/${this.buscar}`;
          break;
        case "colegios_electorales":
          condition = [];
          this.url = `/api/advanced/people/colegios_electorales/${this.buscar}`;
          break;
        default:
          if (this.criterio.length > 0) {
            condition.push({
              field: this.criterio,
              value: `%${this.buscar}%`,
              condition: "where",
              operator: "like"
            });
          }

          this.url = "/api/people";
          break;
      }
      return condition;
    },
    onSearchDistritos(search, loading) {
      loading(true);
      this.search(loading, "distritos", search, this);
    },
    onSearchRecintos(search, loading) {
      loading(true);
      this.search(loading, "recintos", search, this);
    },
    onSearchColegiosElectorales(search, loading) {
      loading(true);
      this.search(loading, "colegios_electorales", search, this);
    },
    onSearchComitesBases(search, loading) {
      loading(true);
      this.search(loading, "comites_bases", search, this);
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
    }, 350),
    searchDependeciesTables() {}
  },
  mounted() {
    this.listarData(1);
  }
};
</script>
<style>
.persona {
  overflow-y: scroll;
}
.table {
  overflow: scroll;
}
.modal-content {
  width: 100% !important;
  position: absolute !important;
}
.table {
  overflow-x: auto;
}
.horizontal-scrollable {
  overflow-x: auto;
  overflow-y: hidden;

  white-space: nowrap;
}

.horizontal-scrollable {
  display: inline-block;
  float: none;
}
::-webkit-scrollbar {
  display: none;
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
