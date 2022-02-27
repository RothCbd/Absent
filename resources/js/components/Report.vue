<template>
  <div id="report">
    <h3 class="grey--text text--darken-2">
      <v-icon class="mb-1" color="grey darken-2">mdi-chart-bar</v-icon>
      <span class="text-decoration-underline">Report {{ countReport }}</span>

      <v-btn
        v-if="reportData.length > 0"
        small
        color="pink accent-4"
        class="ma-2"
        dark
        @click="generatePDF"
        text
        fab
      >
        <v-icon large>mdi-file-pdf-box</v-icon>
      </v-btn>
    </h3>

    <v-row class="flex-row-reverse">
      <v-col cols="12" sm="12" md="4">
        <v-card class="pa-5">
          <v-alert
            v-model="alert"
            class="alert-report-message"
            text
            prominent
            type="error"
            icon="mdi-cloud-alert"
          >
            {{ alertMessageText }}
          </v-alert>

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
                  @click:clear="clearDate()"
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
              @click:clear="clearEmployee()"
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
                    <v-avatar
                      v-if="data.item.image == 'default.png'"
                      color="cyan darken-2 white--text"
                    >
                      {{
                        data.item.name
                          .split(" ")
                          .map((x) => x[0].toUpperCase())
                          .join("")
                      }}
                    </v-avatar>
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
                  <v-avatar
                    v-if="data.item.image == 'default.png'"
                    color="cyan darken-2 white--text"
                    size="40"
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
                    v-if="items[0].employee.pic == 'default.png'"
                    color="cyan darken-2 white--text"
                  >
                    {{
                      items[0].employee.name
                        .split(" ")
                        .map((x) => x[0].toUpperCase())
                        .join("")
                    }}
                  </v-avatar>
                  <v-avatar left v-else>
                    <v-img :src="'/employees/' + items[0].employee.pic" />
                  </v-avatar>
                  {{ group }} :
                  <span class="red--text font-weight-bold ml-1">{{
                    items.length
                  }}</span>
                </v-chip>
              </td>
            </template>

            <template v-slot:[`item.id`]="item">
              <v-chip
                x-small
                color="grey darken-1"
                class="count-absent-chip"
                dark
              >
                {{ item.index + 1 }}
              </v-chip>
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

          <!-- ==============PDF==================== -->

          <vue-html2pdf
            :show-layout="false"
            :float-layout="true"
            :enable-download="false"
            :preview-modal="true"
            :paginate-elements-by-height="1400"
            filename="flavourmap.pdf"
            :pdf-quality="9"
            :manual-pagination="false"
            pdf-format="a4"
            pdf-orientation="portrait"
            pdf-content-width="800px"
            ref="html2Pdf"
          >
            <section slot="pdf-content">
              <!-- PDF Content Here -->
              <section class="pdf-item" id="pdf-content">
                <h1 class="title-hearder">
                  <v-icon>mdi-file-document-outline</v-icon> Absent Report
                </h1>
                <p class="report-date" v-if="form.dates[0]">
                  Date : {{ formatDate(form.dates[0]) }}
                  <span v-if="form.dates[1]">
                    To Date : {{ formatDate(form.dates[1]) }}</span
                  >
                </p>

                <div class="report-date-time">
                  <p>
                    Report Date:
                    <v-icon small>mdi-calendar-month</v-icon>
                    {{
                      formatDate(
                        new Date().toJSON().slice(0, 10).replace(/-/g, "-")
                      )
                    }}
                  </p>
                </div>

                <div>
                  <v-data-table
                    :headers="headers"
                    :items="reportData"
                    :loading="tableLoading"
                    loading-text="Loading Report data"
                    dense
                    :hide-default-footer="true"
                    group-by="employee.name"
                  >
                    <template
                      v-slot:[`group.header`]="{ group, headers, items }"
                    >
                      <td :colspan="headers.length" class="group-header">
                        <span class="employee-name-report">{{ group }}</span> :
                        <v-chip
                          x-small
                          color="grey darken-1"
                          class="count-absent-chip-report"
                        >
                          {{ items.length }}</v-chip
                        >
                      </td>
                    </template>

                    <template v-slot:[`item.id`]="item">
                      {{ item.index + 1 }}
                    </template>

                    <template v-slot:[`item.day`]="{ item }">
                      <span class="text-lowercase"> {{ item.day }}</span>
                    </template>

                    <template v-slot:[`item.date`]="{ item }">
                      <span class="date-formate">{{
                        formatDate(item.date)
                      }}</span>
                    </template>
                  </v-data-table>
                  <div class="border-bottom"></div>
                </div>
              </section>
            </section>
          </vue-html2pdf>
          <!-- --------- -->
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
      alert: false,
      btnPDF: false,
      alertMessageText: "",
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
        employee_id: [],
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

    remove(item) {
      const index = this.form.employee_id.indexOf(item.id);
      if (index >= 0) this.form.employee_id.splice(index, 1);
    },

    getReport() {
      this.btnSaveLoading = true;
      this.tableLoading = true;

      if (this.form.employee_id.length == 0 && this.form.dates.length == 0) {
        this.alertMessageText = "Please choose any Date or Employee.";
        this.alert = true;
        this.btnSaveLoading = false;
        this.tableLoading = false;
      } else {
        this.form
          .post("/api/read-report/", {
            headers: {
              Authorization: "Bearer " + localStorage.getItem("access_token"),
            },
          })
          .then((response) => {
            if (response.data.length > 0) {
              this.reportData = response.data;
              this.countReport = response.data.length;
              this.btnPDF = true;
              this.alert = false;
            }
            this.btnSaveLoading = false;
            this.tableLoading = false;
          })
          .catch((errors) => {
            console.log(errors);
          });
      }
    },

    formatDate(value) {
      return moment(value).format("DD-MM-YYYY");
    },

    clearDate() {
      this.form.dates = [];
      this.reportData = [];
      this.countReport = "";
    },
    clearEmployee() {
      this.form.employee_id = [];
      this.reportData = [];
      this.countReport = "";
    },

    generatePDF() {
      this.$refs.html2Pdf.generatePdf();
    },
  },
};
</script>
