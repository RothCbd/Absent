<template>
  <div id="employee">
    <div>
      <v-row>
        <v-col cols="12" sm="6">
          <v-row>
            <v-col cols="12" sm="12" md="5">
              <h3 class="grey--text text--darken-2">
                <v-icon class="mb-1" color="grey darken-2"
                  >mdi-account-tie</v-icon
                >
                <span class="text-decoration-underline">Employees List</span>
                <!-- <v-chip color="grey lighten-2 grey--text text--darken-3">{{
                  employeeCount
                }}</v-chip> -->
              </h3>
            </v-col>
            <v-col cols="12" sm="12" md="6">
              <v-text-field
                class="txt-search"
                v-model="searchEmployee"
                append-icon="mdi-magnify"
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
            ><v-icon left>mdi-plus</v-icon> Add employee</v-btn
          >
        </v-col>
      </v-row>

      <!-- -------table---- -->

      <v-tabs v-model="tab">
        <v-tabs-slider color="transparent"></v-tabs-slider>
        <v-tab class="text-capitalize tab" key="activeEmployee">
          <v-icon class="mr-2" left>mdi-account-multiple</v-icon>
          <span>Active Employee</span>
          <v-chip small class="ml-2 font-weight-bold indigo--text">{{
            employeeActiveCount
          }}</v-chip>
        </v-tab>
        <v-tab class="text-capitalize tab" key="inactiveEmployee">
          <v-icon class="mr-2" left>mdi-account-multiple-minus</v-icon>
          <span>inactive Employee</span>
          <v-chip small class="ml-2 font-weight-bold indigo--text">{{
            employeeInactiveCount
          }}</v-chip>
        </v-tab>
      </v-tabs>

      <v-tabs-items v-model="tab">
        <v-tab-item key="activeEmployee">
          <v-card class="mx-auto table-card">
            <v-data-table
              :headers="headers"
              :items="employeeActiveData"
              :search="searchEmployee"
              :loading="tableLoading"
              loading-text="Loading users data"
            >
              <template v-slot:[`item.id`]="item">
                {{ item.index + 1 }}
              </template>

              <!-- :color="randomColor()" -->
              <!-- color="cyan darken-2 white--text" -->
              <template v-slot:[`item.name`]="{ item }">
                <v-avatar
                  size="40"
                  class="ma-1 white--text"
                  left
                  v-if="item.image == 'default.png'"
                  :color="'#' + item.profile_color"
                >
                  {{
                    item.name
                      .split(" ")
                      .map((x) => x[0].toUpperCase())
                      .join("")
                  }}
                </v-avatar>

                <v-avatar size="38" class="ma-2" left v-else>
                  <v-img :src="'/employees/' + item.image" />
                </v-avatar>

                <small
                  class="
                    font-weight-medium
                    blue-grey--text
                    text--darken-3 text-capitalize
                    employee-name
                  "
                >
                  {{ item.name }}
                </small>
              </template>

              <template v-slot:[`item.gender`]="{ item }">
                <v-chip
                  v-if="item.gender == 'male'"
                  class="p-1 gender-chip"
                  small
                  color="indigo"
                  text-color="white"
                  label
                >
                  <v-avatar left class="mr-0">
                    <v-icon x-small>mdi-gender-male</v-icon>
                  </v-avatar>
                  {{ item.gender }}
                </v-chip>

                <v-chip
                  v-else
                  class="p-1 gender-chip"
                  small
                  color="pink"
                  text-color="white"
                  label
                >
                  <v-avatar left class="mr-0">
                    <v-icon x-small>mdi-gender-female</v-icon>
                  </v-avatar>
                  {{ item.gender }}
                </v-chip>
              </template>

              <template v-slot:[`item.position`]="{ item }">
                <v-chip
                  label
                  dark
                  color="blue-grey darken-2"
                  class="text-capitalize p-2"
                  small
                >
                  {{ item.position }}
                </v-chip>
              </template>

              <template v-slot:[`item.start_date`]="{ item }">
                <v-chip
                  class="p-1 start-date"
                  small
                  color="teal"
                  text-color="white"
                  label
                >
                  <v-avatar left class="mr-0">
                    <v-icon x-small>mdi-calendar-month</v-icon>
                  </v-avatar>
                  {{ formatDate(item.start_date) }}
                </v-chip>
              </template>

              <template v-slot:[`item.phone_number`]="{ item }">
                <span v-for="number in item.phone_number" :key="number.id">
                  <v-chip
                    v-if="number.phone != null"
                    class="p-1 start-date"
                    small
                    color="grey lighten-2"
                    text-color="blue-grey darken-3"
                    label
                  >
                    {{ number.phone }}
                    <v-avatar class="mr-0">
                      <v-icon x-small>mdi-phone</v-icon>
                    </v-avatar>
                  </v-chip>
                  <br />
                </span>
              </template>

              <template v-slot:[`item.actions`]="{ item }">
                <v-icon small class="mr-2" @click="editEmployee(item)"
                  >mdi-pencil</v-icon
                >
                <v-icon
                  small
                  class="mr-2"
                  @click="deleteEployee(item.id, item.name)"
                  >mdi-delete</v-icon
                >
              </template>
            </v-data-table>
          </v-card>
        </v-tab-item>

        <v-tab-item key="inactiveEmployee">
          <v-card class="mx-auto table-card">
            <v-data-table
              :headers="headers"
              :items="employeeInactiveData"
              :search="searchEmployee"
              :loading="tableLoading"
              loading-text="Loading users data"
            >
              <template v-slot:[`item.id`]="item">
                {{ item.index + 1 }}
              </template>

              <!-- :color="randomColor()" -->
              <!-- color="cyan darken-2 white--text" -->
              <template v-slot:[`item.name`]="{ item }">
                <v-avatar
                  size="40"
                  class="ma-1 white--text"
                  left
                  v-if="item.image == 'default.png'"
                  :color="'#' + item.profile_color"
                >
                  {{
                    item.name
                      .split(" ")
                      .map((x) => x[0].toUpperCase())
                      .join("")
                  }}
                </v-avatar>

                <v-avatar size="38" class="ma-2" left v-else>
                  <v-img :src="'/employees/' + item.image" />
                </v-avatar>

                <small
                  class="
                    font-weight-medium
                    blue-grey--text
                    text--darken-3 text-capitalize
                    employee-name
                  "
                >
                  {{ item.name }}
                </small>
              </template>

              <template v-slot:[`item.gender`]="{ item }">
                <v-chip
                  v-if="item.gender == 'male'"
                  class="p-1 gender-chip"
                  small
                  color="indigo"
                  text-color="white"
                  label
                >
                  <v-avatar left class="mr-0">
                    <v-icon x-small>mdi-gender-male</v-icon>
                  </v-avatar>
                  {{ item.gender }}
                </v-chip>

                <v-chip
                  v-else
                  class="p-1 gender-chip"
                  small
                  color="pink"
                  text-color="white"
                  label
                >
                  <v-avatar left class="mr-0">
                    <v-icon x-small>mdi-gender-female</v-icon>
                  </v-avatar>
                  {{ item.gender }}
                </v-chip>
              </template>

              <template v-slot:[`item.position`]="{ item }">
                <v-chip
                  label
                  dark
                  color="blue-grey darken-2"
                  class="text-capitalize p-2"
                  small
                >
                  {{ item.position }}
                </v-chip>
              </template>

              <template v-slot:[`item.start_date`]="{ item }">
                <v-chip
                  class="p-1 start-date"
                  small
                  color="teal"
                  text-color="white"
                  label
                >
                  <v-avatar left class="mr-0">
                    <v-icon x-small>mdi-calendar-month</v-icon>
                  </v-avatar>
                  {{ formatDate(item.start_date) }}
                </v-chip>
              </template>

              <template v-slot:[`item.phone_number`]="{ item }">
                <span v-for="number in item.phone_number" :key="number.id">
                  <v-chip
                    v-if="number.phone != null"
                    class="p-1 start-date"
                    small
                    color="grey lighten-2"
                    text-color="blue-grey darken-3"
                    label
                  >
                    {{ number.phone }}
                    <v-avatar class="mr-0">
                      <v-icon x-small>mdi-phone</v-icon>
                    </v-avatar>
                  </v-chip>
                  <br />
                </span>
              </template>

              <template v-slot:[`item.actions`]="{ item }">
                <v-icon small class="mr-2" @click="editEmployee(item)"
                  >mdi-pencil</v-icon
                >
                <v-icon
                  small
                  class="mr-2"
                  @click="deleteEployee(item.id, item.name)"
                  >mdi-delete</v-icon
                >
              </template>
            </v-data-table>
          </v-card>
        </v-tab-item>
      </v-tabs-items>

      <!-- --------employee-Insert-Form------ -->
      <v-dialog
        v-model="employeeForm"
        width="550"
        persistent
        overlay-opacity="0"
      >
        <v-card>
          <v-toolbar
            dense
            flat
            color="indigo lighten-1"
            class="user-form-dialog"
          >
            <span v-if="editMode === false" class="white--text">
              <v-icon left color="white">mdi-account-plus</v-icon>
              {{ formTitle }}
            </span>
            <span v-else class="white--text"
              ><v-icon left dark>mdi-account-edit</v-icon>{{ formTitle }}</span
            >
          </v-toolbar>

          <form
            @submit.prevent="editMode ? updateEmployee() : createEmployee()"
            enctype="multipart/form-data"
          >
            <v-card-text>
              <v-row>
                <v-col sm="8">
                  <v-text-field
                    v-model="form.name"
                    label="Name"
                    prepend-icon="mdi-account-tie"
                    :error-messages="errorsMessage.name"
                  ></v-text-field>

                  <v-radio-group
                    v-model="form.gender"
                    row
                    :error-messages="errorsMessage.gender"
                    class="p-0 m-0 ml-5 employee-radio"
                  >
                    <v-radio label="Male" value="male"></v-radio>
                    <v-radio label="Female" value="female"></v-radio>
                  </v-radio-group>

                  <v-text-field
                    v-model="form.email"
                    label="Email"
                    prepend-icon="mdi-email"
                    :error-messages="errorsMessage.email"
                  ></v-text-field>

                  <v-text-field
                    v-model="form.position"
                    label="Position"
                    prepend-icon="mdi-clipboard-account"
                    :error-messages="errorsMessage.position"
                  ></v-text-field>

                  <!-- ----------- -->
                  <v-menu
                    v-model="absentDateChoose"
                    :close-on-content-click="false"
                    max-width="290"
                  >
                    <template v-slot:activator="{ on, attrs }">
                      <v-text-field
                        label="Start Date"
                        :value="computedDateFormattedMomentjs"
                        prepend-icon="mdi-calendar"
                        readonly
                        v-bind="attrs"
                        v-on="on"
                        :error-messages="errorsMessage.start_date"
                      ></v-text-field>
                    </template>
                    <v-date-picker
                      v-model="form.start_date"
                      @input="absentDateChoose = false"
                    ></v-date-picker>
                  </v-menu>

                  <!-- ==================================== -->
                  <v-row>
                    <v-col sm="11">
                      <span
                        v-for="(number, index) in form.phone_number"
                        :key="index"
                      >
                        <v-text-field
                          v-model="number.phone"
                          label="Phone Number"
                          prepend-icon="mdi-phone"
                          v-mask="'###-###-####'"
                        ></v-text-field>
                        <small v-if="index !== 0" class="btn-remove-phoneNum">
                          <v-icon @click="removePhone(index)">mdi-close</v-icon>
                        </small>
                      </span>
                    </v-col>
                    <v-col sm="1">
                      <v-icon class="icon-add-phone" @click="addPhone"
                        >mdi-plus</v-icon
                      >
                    </v-col>
                  </v-row>
                  <v-chip v-if="editMode == true">
                    <v-checkbox
                      label="Inactive Employee"
                      v-model="form.is_inactived"
                    ></v-checkbox>
                  </v-chip>
                </v-col>

                <v-col sm="4">
                  <v-list-item-avatar
                    tile
                    size="150"
                    color="grey lighten-2"
                    height="180"
                    class="rounded-sm"
                  >
                    <v-img
                      v-if="preview_profile"
                      :src="preview_profile"
                      class="img-fluid rounded-sm"
                    ></v-img>

                    <v-img
                      v-if="
                        preview_profile_edit &&
                        preview_profile_edit != 'default.png'
                      "
                      :src="'/employees/' + preview_profile_edit"
                      class="img-fluid rounded-sm"
                    ></v-img>
                  </v-list-item-avatar>
                  <v-file-input
                    show-size
                    v-model="form.image"
                    @change="onFileChange"
                    prepend-icon="mdi-image-multiple"
                    label="employee image"
                    @click:clear="clearImage()"
                    :error-messages="errorsMessage.image"
                  />
                </v-col>
              </v-row>
            </v-card-text>

            <v-card-actions class="card-action">
              <v-spacer></v-spacer>
              <v-btn
                small
                color="grey lighten-2"
                depressed
                @click="closeDialog"
              >
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
                Are you sure to delete
                <b class="red--text tex--lighten-2">{{ userNameDelete }}</b> ?
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
  </div>
</template>

<script>
import moment from "moment";
export default {
  data() {
    return {
      tab: null,
      editMode: false,
      searchEmployee: "",
      snackbar: false,
      editMode: false,
      tableLoading: true,
      absentDateChoose: false,
      headers: [
        {
          text: "No.",
          align: "start",
          value: "id",
        },
        { text: "Name", value: "name" },
        { text: "Gender", value: "gender" },
        { text: "Email", value: "email" },
        { text: "Position", value: "position" },
        { text: "Start Date", value: "start_date" },
        { text: "Phone", value: "phone_number" },
        { text: "Inactive", value: "is_inactive" },
        { text: "Action", sortable: false, align: "center", value: "actions" },
      ],
      employeeActiveData: [],
      employeeInactiveData: [],
      employeeActiveCount: "",
      employeeInactiveCount: "",
      employeeForm: false,
      form: new Form({
        id: "",
        name: "",
        gender: "",
        email: "",
        start_date: "",
        position: "",
        phone_number: [{ phone: "" }],
        image: null,
        is_inactived: false,
      }),

      preview_profile: null,
      preview_profile_edit: null,
      btnSaveLoading: false,
      btnLoading: false,
      image_validation: "",
      alertSnackbarMsg: "",
      errorsMessage: "",
      dialogDelete: false,
      userNameDelete: "",
    };
  },
  computed: {
    formTitle() {
      return this.editMode === false ? "Add Employee" : "Edit Employee";
    },
    computedDateFormattedMomentjs() {
      return this.form.start_date
        ? moment(this.form.start_date).format("DD-MM-YYYY")
        : "";
    },
  },
  mounted() {
    this.ReadEmployeeActive();
    this.ReadEmployeeInactive();
    this.activateMultipleDraggableDialogs();
  },

  methods: {
    ReadEmployeeActive() {
      axios
        .get("http://127.0.0.1:8000/api/active-employee", {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("access_token"),
          },
        })
        .then((response) => {
          this.employeeActiveData = response.data.data;
          this.employeeActiveCount = response.data.data.length;
          this.tableLoading = false;
        })
        .catch((error) => {
          console.log(error);
        });
    },

    ReadEmployeeInactive() {
      axios
        .get("http://127.0.0.1:8000/api/inactive-employee", {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("access_token"),
          },
        })
        .then((response) => {
          this.employeeInactiveData = response.data.data;
          this.employeeInactiveCount = response.data.data.length;
          this.tableLoading = false;
        })
        .catch((error) => {
          console.log(error);
        });
    },

    // randomColor() {
    //   let getColor = "#" + ((Math.random() * 0xffffff) << 0).toString(16);
    //   return "" + getColor + "";
    // },

    formatDate(value) {
      return moment(value).format("DD-MM-YYYY");
    },

    addPhone: function () {
      this.form.phone_number.push({ phone: "" });
    },

    removePhone(index) {
      this.form.phone_number.splice(index, 1);
    },

    openDialog() {
      this.employeeForm = true;
    },

    closeDialog() {
      this.editMode = false;
      this.employeeForm = false;
      this.form.role_id = "";
      this.form.name = "";
      this.form.email = "";
      this.form.gender = null;
      this.form.position = "";
      this.form.phone_number = [{ phone: "" }];
      this.form.image = null;
      this.form.start_date = "";
      this.preview_profile = null;
      this.preview_profile_edit = null;
      this.form.password = "";
      this.form.password_confirmation = "";
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

    createEmployee() {
      this.btnSaveLoading = true;
      this.tableLoading = true;
      this.form
        .post("api/create-employee", {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("access_token"),
          },
        })
        .then((response) => {
          this.ReadEmployeeActive();
          this.ReadEmployeeInactive();
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

    editEmployee(employee) {
      this.editMode = true;
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
      this.form.is_inactived = employee.is_inactived;
      this.employeeForm = true;
    },

    async updateEmployee() {
      this.btnSaveLoading = true;
      this.tableLoading = true;
      await new Promise((resolve) => setTimeout(resolve, 1000));
      this.form
        .post("/api/update-employee/" + this.form.id, {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("access_token"),
          },
        })
        .then((response) => {
          this.ReadEmployeeActive();
          this.ReadEmployeeInactive();
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
            Authorization: "Bearer " + localStorage.getItem("access_token"),
          },
        })
        .then((response) => {
          this.ReadEmployeeActive();
          this.ReadEmployeeInactive();
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
