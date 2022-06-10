<template>
  <div id="absent">
    <v-row>
      <v-col cols="12" sm="6">
        <v-row>
          <v-col cols="12" sm="12" md="4">
            <h3 class="grey--text text--darken-2">
              <v-icon class="mb-1" color="grey darken-2"
                >mdi-account-cancel</v-icon
              >
              <span class="text-decoration-underline">Absent List</span>
              <v-chip color="grey lighten-2 grey--text text--darken-3">{{
                absentCount
              }}</v-chip>
            </h3>
          </v-col>
          <v-col cols="12" sm="12" md="6">
            <v-text-field
              v-model="searchAbsent"
              append-icon="mdi-magnify"
              class="txt-search"
              label="Search"
              single-line
            ></v-text-field>
          </v-col>
        </v-row>
      </v-col>

      <v-col cols="12" sm="6" class="text-end">
        <v-btn
          small
          color="indigo"
          class="add-user white--text pa-2 font-weight-regular mb-2"
          @click="openDialog"
          ><v-icon left>mdi-plus</v-icon> Add Absent</v-btn
        >
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
        <template v-slot:[`item.id`]="item">
          {{ item.index + 1 }}
        </template>

        <template v-slot:[`item.employee.name`]="{ item }">
          <v-chip
            class="font-weight-medium absent-employee-name"
            small
            label
            color="transparent"
          >
            <v-avatar
              left
              class="white--text font-weight-regular"
              v-if="item.employee.image == 'default.png'"
              :color="'#' + item.employee.profile_color"
            >
              {{
                item.employee.name
                  .split(" ")
                  .map((x) => x[0].toUpperCase())
                  .join("")
              }}
            </v-avatar>
            <v-avatar left v-else>
              <v-img :src="'/employees/' + item.employee.image" />
            </v-avatar>
            {{ item.employee.name }}
          </v-chip>
        </template>

        <template v-slot:[`item.absent`]="{ item }">
          <span class="font-weight-medium">
            <span v-if="item.absent == 'fullday'" class="orange--text">
              full day
            </span>
            <span v-if="item.absent == 'halfday'" class="blue-grey--text">
              half day
            </span>
          </span>
          <span v-if="item.absent_time">
            <v-chip
              v-if="item.absent_time == 'morning'"
              class="absent-day-chip indigo--text"
              label
              small
              outlined
              color="indigo"
            >
              {{ item.absent_time
              }}<v-icon right small>mdi-weather-sunset</v-icon>
            </v-chip>

            <v-chip
              v-if="item.absent_time == 'afternoon'"
              class="absent-day-chip orange--text"
              label
              small
              outlined
              color="orange darken-3"
            >
              {{ item.absent_time }}
              <v-icon right x-small>mdi-white-balance-sunny</v-icon>
            </v-chip>
          </span>
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
            class="pa-1 absent-date"
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
          <v-icon small class="mr-2" @click="editAbsent(item)"
            >mdi-pencil</v-icon
          >
          <v-icon
            small
            class="mr-2"
            @click="deleteAbsent(item.id, item.employee.name)"
            >mdi-delete</v-icon
          >
        </template>
      </v-data-table>
    </v-card>

    <!-- --------Absent-Insert-Form------ -->
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
          @submit.prevent="editMode ? updateAbsent() : createAbsent()"
          enctype="multipart/form-data"
        >
          <v-card-text>
            <!-- ================= -->
            <v-autocomplete
                v-model="form.employee_id"
                :items="employeeData"
                :item-text="(item) => item.name"
                item-value="id"
                clearable
                label="Select Employee"
                prepend-inner-icon="mdi-account-tie"
                outlined
                :error-messages="errorsMessage.employee_id"
            >
              <template v-slot:selection="data">
                <v-chip
                  v-bind="data.attrs"
                  :input-value="data.selected"
                  class="mb-1"
                >
                  <v-avatar left>
                    <v-avatar
                      v-if="data.item.image == 'default.png'"
                      class="white--text"
                      :color="'#' + data.item.profile_color"
                    >
                      <h5 class="font-weight-regular">
                        {{
                          data.item.name
                            .split(" ")
                            .map((x) => x[0].toUpperCase())
                            .join("")
                        }}
                      </h5>
                    </v-avatar>
                    <v-img
                      v-else
                      :src="'/employees/' + data.item.image"
                      sizes="35"
                    ></v-img>
                  </v-avatar>
                  {{ data.item.name }}
                </v-chip>
              </template>

              <template v-slot:item="data">
                <v-list-item-avatar>
                  <v-avatar
                    v-if="data.item.image == 'default.png'"
                    :color="'#' + data.item.profile_color"
                    size="35"
                  >
                    <span class="white--text">{{
                      data.item.name
                        .split(" ")
                        .map((x) => x[0].toUpperCase())
                        .join("")
                    }}</span>
                  </v-avatar>

                  <v-img
                    v-else
                    :src="'/employees/' + data.item.image"
                    sizes="35"
                  ></v-img>
                </v-list-item-avatar>
                <v-list-item-content>
                  <v-list-item-title>
                    {{ data.item.name }} -
                    <!-- <v-chip small label> {{ data.item.position }} </v-chip> -->
                    <v-chip
                        label
                        dark
                        color="blue-grey darken-2"
                        class="text-capitalize pa-1"
                        outlined
                        small
                    >
                        <v-avatar left>
                            <v-icon small>mdi-account-star</v-icon>
                        </v-avatar>
                        {{ data.item.position }}
                    </v-chip>
                  </v-list-item-title>
                </v-list-item-content>
              </template>
            </v-autocomplete>

            <!-- ======================== -->
            <v-row>
              <v-col cols="7">
                <v-radio-group
                  v-model="form.absent"
                  row
                  class="ma-0 pa-0"
                  :error-messages="errorsMessage.absent"
                >
                  <v-chip>
                    <v-radio
                      class="font-weight-medium"
                      label="Full Day"
                      value="fullday"
                    ></v-radio>
                  </v-chip>
                  <v-chip class="font-weight-medium ml-3">
                    <v-radio label="Half Day" value="halfday"></v-radio>
                  </v-chip>
                </v-radio-group>
              </v-col>
              <v-col cols="5" class="ma-0 pa-0">
                <v-radio-group
                  v-if="form.absent == 'halfday'"
                  v-model="form.absent_time"
                  column
                  class="ma-0 pa-3"
                  :error-messages="errorsMessage.absent_time"
                >
                  <v-radio
                    class="font-weight-medium"
                    label="Morning"
                    value="morning"
                    color="success"
                  ></v-radio>

                  <v-radio
                    class="font-weight-medium"
                    label="Afternoon"
                    value="afternoon"
                    color="warning"
                  ></v-radio>
                </v-radio-group>
              </v-col>
            </v-row>

            <!-- ======================== -->

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
                  :error-messages="errorsMessage.date"
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
              label="Descriptions"
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

    <!-- ---------------Snacbar--------------- -->
    <v-snackbar v-model="snackbar" color="indigo lighten-1" dark>
      {{ alertSnackbarMsg }}
      <template v-slot:action="{ attrs }">
        <v-btn dark text v-bind="attrs" @click="snackbar = false" small>
          close
        </v-btn>
      </template>
    </v-snackbar>

    <!-- ----------dialogDelete------------ -->
    <v-dialog v-model="dialogDelete" max-width="330px">
      <v-card>
        <div class="text-center">
          <v-sheet class="px-7 pt-7 pb-4 mx-auto text-center d-inline-block">
            <v-icon class="text-center pb-3" x-large color="red lighten-2"
              >mdi-alert</v-icon
            >
            <div class="grey--text text--darken-3 text-body-2 mb-4">
              Are you sure delete
              <b class="red--text tex--lighten-2">{{ employeeName }}</b> absent
              ?
            </div>

            <v-btn
              :disabled="btnLoading"
              class="ma-1"
              depressed
              small
              @click="dialogDelete = false"
            >
              Cancel
            </v-btn>

            <v-btn
              :loading="btnLoading"
              class="ma-1"
              dark
              color="red"
              small
              depressed
              @click="submitDelete"
            >
              Delete
            </v-btn>
          </v-sheet>
        </div>
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
          text: "#",
          align: "start",
          value: "no",
        },
        { text: "Employee", value: "employee.name" },
        { text: "Absent", value: "absent" },
        { text: "Day", value: "day" },
        { text: "Absent Date", value: "date" },
        { text: "Description", value: "description" },
        { text: "Action", sortable: false, align: "center", value: "actions" },
      ],
      absentData: [],
      employeeData: [],
      absentCount: "",
      absentForm: false,
      form: new Form({
        id: "",
        employee_id: "",
        absent: "",
        absent_time: "",
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
      employeeName: "",
    };
  },
  computed: {
    formTitle() {
      return this.editMode === false ? "Add Absent" : "Edit Absent";
    },
    computedDateFormattedMomentjs() {
      return this.form.date
        ? moment(this.form.date).format("dddd, DD/ MM/ YYYY")
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
            Authorization: "Bearer " + localStorage.getItem("access_token"),
          },
        })
        .then((response) => {

            console.log(response.data);

          this.absentData = response.data;
          this.absentCount = response.data.length;
          this.tableLoading = false;
        })
        .catch((error) => {
          console.log(error);
        });
    },

    ReadEmployee() {
      axios
        .get("http://127.0.0.1:8000/api/active-employee", {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("access_token"),
          },
        })
        .then((response) => {
          this.employeeData = response.data.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },

    formatDate(value) {
      return moment(value).format("DD/MM/YYYY");
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
      this.editMode = false;
      this.absentForm = false;
      this.form.employee_id = "";
      this.form.date = "";
      this.form.description = "";
      this.tableLoading = false;
      this.errorsMessage = "";
      this.form.absent = "";
      this.form.absent_time = "";
      this.btnSaveLoading = false;
    },

    createAbsent() {
      this.btnSaveLoading = true;
      this.tableLoading = true;
      this.form
        .post("api/create-absent", {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("access_token"),
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

    editAbsent(absent) {
      this.editMode = true;
      this.form.id = absent.id;
      this.form.employee_id = absent.employee.id;
      this.form.day = absent.day;
      this.form.date = absent.date;
      this.form.description = absent.description;
      this.form.absent = absent.absent;
      this.form.absent_time = absent.absent_time;
      this.absentForm = true;
    },

    async updateAbsent() {
      this.btnSaveLoading = true;
      this.tableLoading = true;
      await new Promise((resolve) => setTimeout(resolve, 1000));
      this.form
        .post("/api/update-absent/" + this.form.id, {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("access_token"),
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

    deleteAbsent(absent, name) {
      this.form.id = absent;
      this.employeeName = name;
      this.dialogDelete = true;
    },

    async submitDelete() {
      this.btnLoading = true;
      this.tableLoading = true;
      await new Promise((resolve) => setTimeout(resolve, 1000));
      axios
        .delete("/api/delete-absent/" + this.form.id, {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("access_token"),
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
