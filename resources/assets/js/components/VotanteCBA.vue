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
        phone_number: ""
      }
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
            phone_number: ""
          };
          this.$emit("listarPadre");
          this.$emit("close");
        })
        .catch(err => {
          alert("Error! La cedula ya esta registrada");
        });
    }
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