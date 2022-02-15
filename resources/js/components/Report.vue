<template>
  <div id="report">
    <h3 class="grey--text text--darken-2">
      <v-icon class="mb-1" color="grey darken-2">mdi-chart-bar</v-icon>
      <span class="text-decoration-underline">Report</span>
    </h3>

    <v-row>
      <v-col cols="12" sm="12" md="4" class="justify-center">
        <v-card>
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
                v-model="dateRangeText"
                :value="computedDateFormattedMomentjs"
                label="Choose Date"
                prepend-inner-icon="mdi-calendar"
                readonly
                v-bind="attrs"
                v-on="on"
                outlined
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
        </v-card>
      </v-col>
      <!-- class="d-flex justify-center" -->
      <v-col cols="12" sm="12" md="8">
        <v-card>
          <v-data-table
            :headers="headers"
            :items="reportData"
            :loading="tableLoading"
            loading-text="Loading users data"
          >
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
      ],
      reportData: [],
      employeeData: [],
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
  },
};
</script>
