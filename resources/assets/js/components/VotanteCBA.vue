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
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">
            Crear Nuevo Miembro
          </h5>
          <button
            type="button"
            class="close"
            data-dismiss="modal"
            aria-label="Close"
          >
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="container-fluid">
              <form action="">
                <div class="row">
                  <div class="form-group">
                    <label for="">Nombre</label>
                    <input
                      type="text"
                      class="form-control"
                      v-model="entity.first_name"
                      placeholder="Nombre"
                    />
                  </div>
                </div>
                <div class="row">
                  <div class="form-group">
                    <label for="">Apellido</label>
                    <input
                      type="text"
                      class="form-control"
                      v-model="entity.last_name"
                      placeholder="Apellido"
                    />
                  </div>
                </div>
                <div class="row">
                  <div class="form-group">
                    <label for="">Cedula</label>
                    <input
                      type="text"
                      v-model="entity.card_id"
                      v-mask="'###-#######-#'"
                      class="form-control"
                      placeholder="Cedula"
                    />
                  </div>
                </div>
                <div class="row">
                  <div class="form-group">
                    <label for="">Telefono</label>
                    <input
                      type="text"
                      v-model="entity.phone"
                      v-mask="'###-###-####'"
                      class="form-control"
                      placeholder="Cedula"
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
          >
            Close
          </button>
          <button type="button" @click="save()" class="btn btn-primary">
            Save changes
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  props: {
    comitesBasesId: {
      default: null,
    },
    show: {
      default: false,
      type: Boolean,
    },
  },
  data() {
    return {
      entity: {
        first_name: "",
        last_name: "",
        card_id: "",
      },
    };
  },
  methods: {
    save() {
      this.entity.comites_bases_id = this.comitesBasesId;
      axios({
        url: "/api/people",
        method: "POST",
        data: this.entity,
      })
        .then((e) => {
          this.$emit("listarPadre");
          this.$emit("close");
        })
        .catch((err) => {
          alert("Ha ocurrido un error");
        });
    },
  },
};
</script>
