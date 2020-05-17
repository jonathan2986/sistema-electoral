<template>
  <div
    class="modal fade"
    :class="{ mostrar: show }"
    id="exampleModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-primary modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Crear Nuevo Miembro</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" @click="$emit('close')">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="container-fluid">
              <form action method="post" enctype="multipart/form-data" class="form-horizontal">
                <div class="form-group row">
                  <label class="col-md-3 form-control-label" for="text-input">Cedula</label>
                  <div class="col-md-9">
                    <input
                      type="text"
                      v-model="entity.card_id"
                      v-mask="'###-#######-#'"
                      class="form-control"
                      placeholder="Cedula"
                      required
                    />
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                  <div class="col-md-9">
                    <input
                      type="text"
                      class="form-control"
                      v-model="entity.first_name"
                      placeholder="Nombre"
                      required
                    />
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-md-3 form-control-label" for="text-input">Apellido</label>
                  <div class="col-md-9">
                    <input
                      type="text"
                      class="form-control"
                      v-model="entity.last_name"
                      placeholder="Apellido"
                      required
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
              </form>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button
            type="button"
            class="btn btn-secondary"
            data-dismiss="modal"
            @click="$emit('close')"
          >Cerrar</button>
          <button type="button" @click="save()" class="btn btn-primary">Guardar Cambios</button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  props: {
    comitesBasesId: {
      default: null
    },
    show: {
      default: false,
      type: Boolean
    }
  },
  data() {
    return {
      entity: {
        first_name: "",
        last_name: "",
        card_id: "",
        phone_number: "",
        municipios_id: 2,
        circunscripciones_id: 0,
        distritos_id: 0,
        recintos_id: 0,
        colegios_electorales_id: 0,
        comites_bases_id: 0
      },
      circunscripciones: [],
      distritos: [],
      provincias: [],
      recintos: [],
      municipios: [
        {
          id: 2,
          label: "Santiago de los Caballeros"
        }
      ],
      colegios_electorales: []
    };
  },
  methods: {
    save() {
      this.entity.comites_bases_id = this.comitesBasesId;
      axios({
        url: "/api/people",
        method: "POST",
        data: this.entity
      })
        .then(e => {
          this.entity = {
            first_name: "",
            last_name: "",
            card_id: "",
            phone_number: "",
            municipios_id: 2,
            circunscripciones_id: 0,
            distritos_id: 0,
            recintos_id: 0,
            colegios_electorales_id: 0,
            comites_bases_id: 0
          };
          this.$emit("listarPadre");
          this.$emit("close");
        })
        .catch(err => {
          alert("Error! La cedula ya esta registrada");
        });
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