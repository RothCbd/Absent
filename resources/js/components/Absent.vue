<template>
  <div id="absent">
    <v-row>
      <v-col cols="sm-8">
        <h3 class="grey--text text--darken-2">
          <v-icon class="mb-1" color="grey darken-2">mdi-account-cancel</v-icon>
          <span class="text-decoration-underline">Absent List</span>
          <v-chip color="grey lighten-2 grey--text text--darken-3">35</v-chip>
        </h3>
      </v-col>
      <v-col cols="sm-4" class="text-right">
        <v-btn
          small
          color="indigo"
          class="add-user white--text pa-2 font-weight-regular mb-2"
          @click="openDialog"
          ><v-icon left>mdi-plus</v-icon> Add Absent</v-btn
        >

        <v-text-field
          v-model="searchAbsent"
          hide-details
          class="mb-2 p-0"
          append-icon="mdi-magnify"
          label="Search"
          single-line
        ></v-text-field>
      </v-col>
    </v-row>

    <!-- -------table---- -->
    <v-card class="mx-auto table-card">
      <v-data-table
        :headers="headers"
        :items="absentData"
        :search="searchAbsent"
        :loading="tableLoading"
        loading-text="Loading users data"
      >
        <template v-slot:[`item.employee.name`]="{ item }">
          <v-avatar
            size="40"
            class="ma-1"
            left
            v-if="item.employee.image == 'default.png'"
          >
            <v-img :src="'/image/default.png'" />
          </v-avatar>
          <v-avatar size="40" class="ma-1" left v-else>
            <v-img :src="'/employees/' + item.employee.image" />
          </v-avatar>

          <small
            class="
              font-weight-medium
              blue-grey--text
              text--darken-3 text-capitalize
              employee-name
            "
          >
            {{ item.employee.name }}
          </small>
        </template>

        <template v-slot:[`item.day`]="{ item }">
          <v-chip
            dark
            :color="getColor(item.day)"
            class="text-capitalize absent-day-chip"
            small
          >
            {{ item.day }}
          </v-chip>
        </template>

        <template v-slot:[`item.date`]="{ item }">
          <v-chip
            class="p-1 start-date"
            small
            color="pink darken-3"
            text-color="white"
            label
          >
            <v-avatar left class="mr-0">
              <v-icon small>mdi-calendar-month</v-icon>
            </v-avatar>
            {{ formatDate(item.date) }}
          </v-chip>
        </template>

        <template v-slot:[`item.actions`]="{ item }">
          <v-icon small class="mr-2">mdi-pencil</v-icon>
          <v-icon small class="mr-2">mdi-delete</v-icon>
        </template>
      </v-data-table>
    </v-card>

    <!-- --------employee-Insert-Form------ -->
    <v-dialog v-model="absentForm" width="500" persistent overlay-opacity="0">
      <v-card>
        <v-toolbar dense flat color="indigo lighten-1" class="user-form-dialog">
          <span v-if="editMode === false" class="white--text">
            <v-icon left color="white">mdi-account-cancel</v-icon>
            {{ formTitle }}
          </span>
          <span v-else class="white--text"
            ><v-icon left dark>mdi-account-cancel</v-icon>{{ formTitle }}</span
          >
        </v-toolbar>

        <form
          @submit.prevent="editMode ? updatePost() : createAbsent()"
          enctype="multipart/form-data"
        >
          <v-card-text>
            <!-- ================= -->
            <v-autocomplete
              v-model="form.employee_id"
              :items="employeeDate"
              :item-text="(item) => item.name"
              item-value="id"
              clearable
              label="Select Employee"
              prepend-inner-icon="mdi-account-tie"
              outlined
            >
              <template v-slot:selection="data">
                <v-chip
                  v-bind="data.attrs"
                  :input-value="data.selected"
                  class="mb-1"
                >
                  <v-avatar left>
                    <v-img
                      v-if="data.item.image == 'default.png'"
                      :src="'/image/default.png'"
                      sizes="40"
                    ></v-img>
                    <v-img
                      v-else
                      :src="'/employees/' + data.item.image"
                      sizes="40"
                    ></v-img>
                  </v-avatar>
                  {{ data.item.name }}
                </v-chip>
              </template>

              <template v-slot:item="data">
                <v-list-item-avatar>
                  <v-img
                    v-if="data.item.image == 'default.png'"
                    :src="'/image/default.png'"
                    sizes="40"
                  ></v-img>
                  <v-img
                    v-else
                    :src="'/employees/' + data.item.image"
                    sizes="40"
                  ></v-img>
                </v-list-item-avatar>
                <v-list-item-content>
                  <v-list-item-title>
                    {{ data.item.name }} -
                    <v-chip small label> {{ data.item.position }} </v-chip>
                  </v-list-item-title>
                </v-list-item-content>
              </template>
            </v-autocomplete>

            <v-menu
              v-model="absentDateChoose"
              :close-on-content-click="false"
              max-width="290"
            >
              <template v-slot:activator="{ on, attrs }">
                <v-text-field
                  :value="computedDateFormattedMomentjs"
                  label="Absent Date"
                  prepend-inner-icon="mdi-calendar"
                  readonly
                  v-bind="attrs"
                  v-on="on"
                  outlined
                ></v-text-field>
              </template>
              <v-date-picker
                v-model="form.date"
                @input="absentDateChoose = false"
              ></v-date-picker>
            </v-menu>

            <v-textarea
              v-model="form.description"
              outlined
              label="Outlined textarea"
              rows="3"
            ></v-textarea>
          </v-card-text>

          <v-card-actions class="card-action">
            <v-spacer></v-spacer>
            <v-btn small color="grey lighten-2" depressed @click="closeDialog">
              cancel
            </v-btn>
            <v-btn
              color="primary"
              small
              depressed
              type="submit"
              :loading="btnSaveLoading"
            >
              save
            </v-btn>
          </v-card-actions>
        </form>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import moment from "moment";
export default {
  data() {
    return {
      absentDateChoose: false,
      editMode: false,
      searchAbsent: "",
      snackbar: false,
      editMode: false,
      tableLoading: true,
      headers: [
        {
          text: "No.",
          align: "start",
          value: "id",
        },
        { text: "Employee", value: "employee.name" },
        { text: "Day", value: "day" },
        { text: "Absent Date", value: "date" },
        { text: "Description", value: "desription" },
        { text: "Action", sortable: false, align: "center", value: "actions" },
      ],
      absentData: [],
      employeeDate: [],
      absentCount: "",
      absentForm: false,
      form: new Form({
        id: "",
        employee_id: "",
        day: "",
        date: "",
        description: "",
      }),
      btnSaveLoading: false,
      btnLoading: false,
      image_validation: "",
      alertSnackbarMsg: "",
      errorsMessage: "",
      dialogDelete: false,
    };
  },
  computed: {
    formTitle() {
      return this.editMode === false ? "Add Absent" : "Edit Absent";
    },
    computedDateFormattedMomentjs() {
      return this.form.date
        ? moment(this.form.date).format("dddd, DD-MM-YYYY")
        : "";
    },
  },
  mounted() {
    this.ReadAbsent();
    this.ReadEmployee();
    this.activateMultipleDraggableDialogs();
  },

  methods: {
    ReadAbsent() {
      axios
        .get("http://127.0.0.1:8000/api/read-absent", {
          headers: {
            Authorization:
              "Bearer " + "3|0sgWurjPC0veVBPSbxO63eTcNEBpSIJDOnQnGGRg",
          },
        })
        .then((response) => {
          this.absentData = response.data.data;
          this.absentCount = response.data.data.length;
          this.tableLoading = false;
        })
        .catch((error) => {
          console.log(error);
        });
    },

    ReadEmployee() {
      axios
        .get("http://127.0.0.1:8000/api/read-employee", {
          headers: {
            Authorization:
              "Bearer " + "3|0sgWurjPC0veVBPSbxO63eTcNEBpSIJDOnQnGGRg",
          },
        })
        .then((response) => {
          this.employeeDate = response.data.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },

    formatDate(value) {
      return moment(value).format("DD-MM-YYYY");
    },

    getColor(day) {
      if (day == "Monday") return "orange darken-2";
      else if (day == "Tuesday") return "purple";
      else if (day == "Wednesday") return "light-green";
      else if (day == "Thursday") return "green";
      else if (day == "Friday") return "blue";
      else if (day == "Saturday") return "pink darken-4";
      else if (day == "Sunday") return "red";
    },

    openDialog() {
      this.absentForm = true;
    },

    closeDialog() {
      this.absentForm = false;
      this.form.employee_id = "";
      this.form.date = "";
      this.form.description = "";
      this.tableLoading = false;
      this.errorsMessage = "";
      this.btnSaveLoading = false;
    },

    addPhone: function () {
      this.form.phone_number.push({ phone: "" });
    },

    removePhone(index) {
      this.form.phone_number.splice(index, 1);
    },
    // -------------image--------------------
    createImage(file) {
      const reader = new FileReader();
      reader.onload = (e) => {
        this.preview_profile = e.target.result;
      };
      reader.readAsDataURL(file);
    },
    onFileChange(file) {
      if (!file) {
        return;
      }
      this.createImage(file);
    },

    clearImage() {
      this.preview_profile = null;
      this.form.image = null;
    },
    // ---------------------------------

    createAbsent() {
      this.btnSaveLoading = true;
      this.tableLoading = true;
      this.form
        .post("api/create-absent", {
          headers: {
            Authorization:
              "Bearer " + "3|0sgWurjPC0veVBPSbxO63eTcNEBpSIJDOnQnGGRg",
          },
        })
        .then((response) => {
          this.ReadAbsent();
          this.closeDialog();
          this.alertSnackbarMsg = response.data.message;
          this.snackbar = true;
          this.btnSaveLoading = false;
          this.tableLoading = false;
        })
        .catch((errors) => {
          this.errorsMessage = errors.response.data.errors;
          this.btnSaveLoading = false;
          this.tableLoading = false;
        });
    },

    editUser(employee) {
      this.editMode = true;
      console.log(employee);
      this.form.id = employee.id;
      if (employee.gender == "male") {
        this.form.gender = "male";
      } else if (employee.gender == "female") {
        this.form.gender = "female";
      }
      this.form.name = employee.name;
      this.form.email = employee.email;
      this.form.phone_number = employee.phone_number;
      this.preview_profile_edit = employee.image;
      this.form.position = employee.position;
      this.form.start_date = employee.start_date;
      this.absentForm = true;
    },

    async updatePost() {
      this.btnSaveLoading = true;
      this.tableLoading = true;
      await new Promise((resolve) => setTimeout(resolve, 1000));
      this.form
        .post("/api/update-employee/" + this.form.id, {
          headers: {
            Authorization:
              "Bearer " + "3|0sgWurjPC0veVBPSbxO63eTcNEBpSIJDOnQnGGRg",
          },
        })
        .then((response) => {
          this.ReadAbsent();
          this.closeDialog();
          this.alertSnackbarMsg = response.data.message;
          this.snackbar = true;
          this.btnSaveLoading = false;
          this.tableLoading = false;
        })
        .catch((errors) => {
          this.errorsMessage = errors.response.data.errors;
          this.btnSaveLoading = false;
          this.tableLoading = false;
        });
    },

    deleteEployee(user, name) {
      this.form.id = user;
      this.userNameDelete = name;
      this.dialogDelete = true;
    },

    async submitDelete() {
      this.btnLoading = true;
      this.tableLoading = true;
      await new Promise((resolve) => setTimeout(resolve, 1000));
      axios
        .delete("/api/delete-employee/" + this.form.id, {
          headers: {
            Authorization:
              "Bearer " + "3|0sgWurjPC0veVBPSbxO63eTcNEBpSIJDOnQnGGRg",
          },
        })
        .then((response) => {
          this.ReadAbsent();
          this.dialogDelete = false;
          this.alertSnackbarMsg = response.data.message;
          this.snackbar = true;
          this.btnLoading = false;
          this.tableLoading = false;
        })
        .catch((error) => {
          this.btnLoading = false;
          this.tableLoading = false;
        });
    },
  },
};
</script>
