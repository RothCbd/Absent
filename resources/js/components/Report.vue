<template>
  <div id="report">
    <h3 class="grey--text text--darken-2">
      <v-icon class="mb-1" color="grey darken-2">mdi-chart-bar</v-icon>
      <span class="text-decoration-underline">Report {{ countReport }}</span>
    </h3>

    <v-row class="flex-row-reverse">
      <!-- class="d-flex justify-center" -->
      <v-col cols="12" sm="12" md="4">
        <v-card class="pa-5">
          <form @submit.prevent="getReport()">
            <v-menu
              v-model="menu2"
              :close-on-content-click="false"
              :nudge-right="40"
              :nudge-top="40"
              transition="scale-transition"
              offset-y
              min-width="auto"
            >
              <template v-slot:activator="{ on, attrs }">
                <v-text-field
                  :value="dateRangeText"
                  label="Choose Date"
                  prepend-inner-icon="mdi-calendar"
                  readonly
                  v-bind="attrs"
                  v-on="on"
                  outlined
                  clearable
                  @click:clear="form.dates = []"
                ></v-text-field>
              </template>
              <v-date-picker
                v-model="form.dates"
                range
                @input="menu2 = true"
              ></v-date-picker>
            </v-menu>

            <v-autocomplete
              v-model="form.employee_id"
              :items="employeeData"
              :item-text="(item) => item.name"
              item-value="id"
              clearable
              label="Select Employee"
              prepend-inner-icon="mdi-account-tie"
              outlined
              multiple
            >
              <template v-slot:selection="data">
                <v-chip
                  v-bind="data.attrs"
                  :input-value="data.selected"
                  class="mb-1"
                  close
                  @click="data.select"
                  @click:close="remove(data.item)"
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

            <v-btn
              color="primary"
              small
              type="submit"
              :loading="btnSaveLoading"
              block
            >
              <v-icon left> mdi-chart-bar </v-icon>
              report
            </v-btn>
          </form>
        </v-card>
      </v-col>

      <v-col cols="12" sm="12" md="8" class="justify-center">
        <v-card class="pa-2">
          <v-data-table
            :headers="headers"
            :items="reportData"
            :loading="tableLoading"
            loading-text="Loading Report data"
            dense
            group-by="employee.name"
          >
            <template
              v-slot:[`group.header`]="{
                group,
                headers,
                toggle,
                isOpen,
                items,
              }"
            >
              <td :colspan="headers.length" class="group-header">
                <v-btn
                  @click="toggle"
                  small
                  icon
                  :ref="group"
                  :data-open="isOpen"
                >
                  <v-icon v-if="isOpen">mdi-chevron-up</v-icon>
                  <v-icon v-else>mdi-chevron-down</v-icon>
                </v-btn>

                <v-chip class="ma-1 font-weight-medium" small>
                  <v-avatar
                    left
                    v-if="items[0].employee.image == 'default.png'"
                  >
                    <v-img :src="'/image/default.png'" />
                  </v-avatar>
                  <v-avatar left v-else>
                    <v-img :src="'/employees/' + items[0].employee.image" />
                  </v-avatar>
                  {{ group }} :
                  <span class="red--text font-weight-bold ml-1">{{
                    items.length
                  }}</span>
                </v-chip>
              </td>
            </template>

            <template v-slot:[`item.day`]="{ item }">
              <span class="text-lowercase"> {{ item.day }}</span>
            </template>

            <template v-slot:[`item.date`]="{ item }">
              <v-chip text-color="blue-grey darken-2" label color="white">
                <v-avatar left class="mr-0">
                  <v-icon small>mdi-calendar-month</v-icon>
                </v-avatar>
                {{ formatDate(item.date) }}
              </v-chip>
            </template>
          </v-data-table>
        </v-card>
      </v-col>
    </v-row>
  </div>
</template>

<script>
import moment from "moment";
export default {
  data() {
    return {
      tableLoading: false,
      menu2: false,
      btnSaveLoading: false,
      headers: [
        {
          align: "start",
          value: "id",
        },
        { text: "Employee", value: "employee.name" },
        { text: "Day", value: "day" },
        { text: "Absent Date", value: "date" },
        { text: "Description", value: "desription" },
      ],
      reportData: [],
      employeeData: [],
      countReport: "",
      form: new Form({
        employee_id: "",
        dates: [],
      }),
    };
  },
  computed: {
    dateRangeText() {
      return this.form.dates.join(" ~ ");
    },
    computedDateFormattedMomentjs() {
      return this.form.dates
        ? moment(this.form.dates).format("DD-MM-YYYY")
        : "";
    },
  },
  mounted() {
    this.ReadEmployee();
  },

  methods: {
    ReadEmployee() {
      axios
        .get("http://127.0.0.1:8000/api/read-employee", {
          headers: {
            Authorization:
              "Bearer " + "3|0sgWurjPC0veVBPSbxO63eTcNEBpSIJDOnQnGGRg",
          },
        })
        .then((response) => {
          this.employeeData = response.data.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },

    remove(item) {
      const index = this.form.employee_id.indexOf(item.id);
      if (index >= 0) this.form.employee_id.splice(index, 1);
    },

    getReport() {
      this.btnSaveLoading = true;
      this.tableLoading = true;
      this.form
        .post("/api/read-report/", {
          headers: {
            Authorization:
              "Bearer " + "3|0sgWurjPC0veVBPSbxO63eTcNEBpSIJDOnQnGGRg",
          },
        })
        .then((response) => {
          this.reportData = response.data.data;
          this.countReport = response.data.data.length;
          this.btnSaveLoading = false;
          this.tableLoading = false;
        })
        .catch((errors) => {
          console.log(errors);
        });
    },

    formatDate(value) {
      return moment(value).format("DD-MM-YYYY");
    },
  },
};
</script>
