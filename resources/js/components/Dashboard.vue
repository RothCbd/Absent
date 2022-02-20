<template>
  <div id="dashboard">
    <h3 class="grey--text text--darken-2 pa-5">
      <v-icon class="mb-1" color="grey darken-2">mdi-view-dashboard</v-icon>
      <span class="text-decoration-underline">Dashboard</span>
    </h3>

    <v-row>
      <v-col cols="12" sm="12" md="4">
        <v-card class="widget-card">
          <v-card-text class="pa-2">
            <v-container class="pa-2">
              <div class="layout row ma-0">
                <div class="sm4 xs4 flex">
                  <div class="layout column ma-0 justify-center align-center">
                    <v-icon size="70" color="indigo"
                      >mdi-account-multiple</v-icon
                    >
                  </div>
                </div>
                <div class="layout column ma-0 justify-center">
                  <h1>5</h1>
                  <h2 class="mt-2 font-weight-medium">Users</h2>
                </div>
              </div>
            </v-container>
          </v-card-text>
        </v-card>
      </v-col>

      <v-col cols="12" sm="12" md="4">
        <v-card class="widget-card">
          <v-card-text class="pa-2">
            <v-container class="pa-2">
              <div class="layout row ma-0">
                <div class="sm4 xs4 flex">
                  <div class="layout column ma-0 justify-center align-center">
                    <v-icon size="70" color="blue">mdi-account-tie</v-icon>
                  </div>
                </div>
                <div class="layout column ma-0 justify-center">
                  <h1>10</h1>
                  <h2 class="mt-2 font-weight-medium">Employees</h2>
                </div>
              </div>
            </v-container>
          </v-card-text>
        </v-card>
      </v-col>

      <v-col cols="12" sm="12" md="4">
        <v-card class="widget-card">
          <v-card-text class="pa-2">
            <v-container class="pa-2">
              <div class="layout row ma-0">
                <div class="sm4 xs4 flex">
                  <div class="layout column ma-0 justify-center align-center">
                    <v-icon size="70" color="orange darken-3"
                      >mdi-account-cancel</v-icon
                    >
                  </div>
                </div>
                <div class="layout column ma-0 justify-center">
                  <h1>23</h1>
                  <h2 class="mt-2 font-weight-medium">Absents</h2>
                </div>
              </div>
            </v-container>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>

    <div class="table-report mt-5">
      <v-row>
        <v-col cols="12" sm="12" md="3" class="pa-1">
          <v-card>
            <v-card-title>
              <v-icon size="25" color="grey darken-2" left
                >mdi-account-cancel</v-icon
              >
              <small class="grey--text text--darken-2">
                Absent for this Week</small
              >
              <v-chip small color="teal darken-2" dark class="ml-2">3</v-chip>
            </v-card-title>

            <v-card-text class="pa-1">
              <v-data-table
                :headers="headers"
                :items="weeklyAbsentData"
                loading-text="Loading Report data"
                dense
                hide-default-footer
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
                      >
                        <v-img :src="'/image/default.png'" />
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
            </v-card-text>
          </v-card>
        </v-col>

        <v-col cols="12" sm="12" md="3" class="pa-1">
          <v-card>
            <v-card-title>
              <v-icon size="25" color="grey darken-2" left
                >mdi-account-cancel</v-icon
              >
              <small class="grey--text text--darken-2">
                Absent for this Month</small
              >
              <v-chip small color="deep-orange darken-4" dark class="ml-2"
                >3</v-chip
              >
            </v-card-title>

            <v-card-text class="pa-1">
              <v-data-table
                :headers="headers"
                :items="weeklyAbsentData"
                loading-text="Loading Report data"
                dense
                hide-default-footer
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
                      >
                        <v-img :src="'/image/default.png'" />
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
            </v-card-text>
          </v-card>
        </v-col>

        <v-col cols="12" sm="12" md="6" class="pa-1">
          <v-card>
            <chartjs-doughnut
              v-bind:labels="labels"
              v-bind:datasets="datasets"
              v-bind:option="option"
            ></chartjs-doughnut>
          </v-card>
        </v-col>
      </v-row>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      headers: [
        {
          align: "start",
          value: "id",
        },
        { text: "Employee", value: "employee.name" },
        { text: "Day", value: "day" },
        { text: "Absent Date", value: "date" },
      ],
      weeklyAbsentData: [],
      countReport: "",
      labels: [
        "Jan",
        "Feb",
        "Mar",
        "Apr",
        "May",
        "Jun",
        "Jul",
        "Aug",
        "Sep",
        "Oct",
        "Nov",
        "Dec",
      ],
      datasets: [
        {
          data: [2, 3, 5, 0, 4, 4, 2, 1, 0, 3, 2, 6],
          backgroundColor: [
            "gray",
            "Blue",
            "Green",
            "#607D8B",
            "purple",
            "pink",
            "blue",
            "#673AB7",
            "#3F51B5",
            "#009688",
            "#4CAF50",
            "#E65100",
          ],
        },
      ],
      option: {
        legend: {
          display: true,
        },
        title: {
          display: true,
          position: "bottom",
          text: "Absent for " + new Date().getFullYear(),
        },
      },
    };
  },
  mounted() {
    this.getReport();
  },

  methods: {
    getReport() {
      axios
        .get("/api/dashboard-data/", {
          headers: {
            Authorization:
              "Bearer " + "3|0sgWurjPC0veVBPSbxO63eTcNEBpSIJDOnQnGGRg",
          },
        })
        .then((response) => {
          console.log(response);
        })
        .catch((errors) => {
          console.log(errors);
        });
    },
  },
};
</script>
